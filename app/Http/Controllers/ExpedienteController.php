<?php

namespace App\Http\Controllers;

use App\Expediente;
use App\Anexo;
use App\Auditoria;
use App\Comment;
use App\ExpedienteUsuarios;
use App\User;
use Storage;
use App\Log;
use Datatables;
use Mail;
use App\ClasificacionAnexo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\TipoExpediente;
use App\Http\Requests\ExpedienteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class ExpedienteController extends Controller
{
      public function loadPermiso($expediente)
      {
            $permiso = DB::table('expediente_usuarios')->where([
                  ['expediente_id', '=', $expediente->id],
                  ['user_id', '=', Auth::user()->id],
            ])->exists();
            $user = User::find(Auth::user()->id);
            $admin = ($user->getRoles()[0] == 'admin')?true:false;
            return $permiso OR $admin;
      }
      public function misexpedientes()
      {
           $expedientes = Expediente::where('user_id', Auth::user()->id)->get();
           Session::put('proviene', 'misexpedientes');
           return view('expedientes.index', [
             'expedientes' => $expedientes,
             'action'=>'index'
           ]);

      }

      public function expPermisos()
      {
           $use = Auth::user()->id;
           $expedientes = Expediente::with(['tipoexpediente', 'user', 'expUsuarios'])
                        ->whereHas('expUsuarios', function($q) use ($use){
                              $q->where('user_id', Auth::user()->id);
                        })
                        ->where('user_id', '!=', Auth::user()->id)
                        ->get();

            return view('expedientes.index', [
             'expedientes' => $expedientes,
             'action'=>'index'
            ]);

      }


      public function index()
      {

            $expedientes = Expediente::all();
            Session::put('proviene', 'index');
            return view('expedientes.index', [
                  'expedientes' => $expedientes,
                  'action'=>'index'
            ]);
      }

      /*
            Va a mostrar los expedientes con borrado lógico
       */
      public function eliminated()
      {
            $expedientes = Expediente::onlyTrashed()->get();
            return view('expedientes.eliminated', ['expedientes' => $expedientes, 'action' => 'restore']);
      }


      public function agregarAnexo(Expediente $expediente)
      {
            if (!($this->loadPermiso($expediente))){
                  Session::flash('message-danger', 'Ud no tiene permisos para ver ni editar este expediente.');
                  return redirect()->route('expediente.index');
            }
            $clasificacionAnexo = ClasificacionAnexo::all()->pluck('nombre','id');
            return view('anexos.create_exp',[
                  'expediente' => $expediente,
                  'clasificacionAnexo' => $clasificacionAnexo,
            ]);
      }

      public function create()
      {
            $tipoExpedientes = TipoExpediente::all()->pluck('nombre_and_letra','id');
            $usuarios = DB::Select ("
                                    SELECT DISTINCT u.* FROM
                                    users u
                                    INNER JOIN role_user ON role_user.`user_id` = u.`id`
                                    WHERE role_user.`role_id` != 1
                                    ");
            return view('expedientes.create', [
                  'tipoExpedientes'=> $tipoExpedientes,
                  'usuarios'=>$usuarios,
            ]);
      }

      public function store(ExpedienteRequest $expedienteRequest)
      {
            DB::beginTransaction();
            try {
                  $data = $expedienteRequest->all();
                  $letra = TipoExpediente::where('id', $data['tipo_expediente_id'])->first();
                  $numero = DB::table('nroExpediente')->max('id');
                  $numero2 = str_pad($numero, 4, "0", STR_PAD_LEFT);
                  $anio = date('Y');
                  $data['numero'] = "$letra->letra-$numero2-$anio";
                  $data['slug'] = str_slug($data['caratula']) . "-" . rand(50,1000);
                  DB::table('nroExpediente')->increment('id');
                  $creado = Expediente::create($data);

                  if (isset($data['usuarios']))
                  {
                        // Agrego a todos los usuarios tildados como Habilitados para editar el expediente
                        // Y les envio un mail avisandoles
                        foreach ($data['usuarios'] as $key => $value) {
                              $permisos = new ExpedienteUsuarios();
                              $permisos->expediente_id = $creado['id'];
                              $permisos->user_id = (int)$value;
                              $permisos->slug = str_slug($creado['id'] . '-' . $value . '-' . rand(5,10000));
                              if($permisos->save())
                              {
                                    $usuario = DB::select("SELECT * FROM users u WHERE u.id =" . $value);
                                    $this->enviar_aviso($creado, $usuario[0]);
                              }
                        }
                  }

                  // SI NO ES ADMINISTRADOR
                  // Agrego al usuario logueado, es decir el que acaba de crear el Expediente como usuario habilitado
                  // para editar el expediente
                  // Y le envio un mail avisando de esto

                  $rol_logueado = DB::Select ("
                                    SELECT roles.slug FROM
                                    users u
                                    INNER JOIN role_user ON role_user.user_id = u.id
                                    INNER JOIN roles ON roles.id = role_user.role_id
                                    WHERE u.id =" .  Auth::user()->id
                                    );
                  if(!($rol_logueado[0]->slug == 'admin'))
                  {
                        $permisos = new ExpedienteUsuarios();
                        $permisos->expediente_id = $creado['id'];
                        $permisos->user_id = Auth::user()->id;
                        $permisos->slug = str_slug($creado['id'] . '-' . str_slug($creado['caratula']) . '-' . rand(5000,10000));
                        if($permisos->save())
                        {
                              $usuario = DB::select("SELECT * FROM users u WHERE u.id =" . Auth::user()->id);
                              $this->enviar_aviso($creado, $usuario[0]);
                        }

                  }
                  // A LOS ADMINISTRADORES DEL SISTEMA
                  $email_administradores = DB::select("
                        SELECT u.email FROM users u, roles r, role_user ru WHERE ru.role_id = r.id AND ru.`user_id` = u.`id` AND  r.name = 'Administrador'
                  ");
                  if ($email_administradores){
                        foreach ($email_administradores as $administrador) {
                              $this->enviar_aviso_admin($creado, $administrador->email);
                        }
                  }
                  DB::commit();
            }catch(ValidationException $e)
            {
                  $control = new Log();
                  $control->user_id = Auth::user()->id;
                  $control->username = Auth::user()->name;
                  $control->expediente_id = $creado['id'];
                  $control->campo = 'Caratulacion';
                  $control->descripcion = 'Error al intentar crear el registro en ExpedienteUsuarios';
                  $control->save();
                  DB::rollback();
                  return redirect()->route('expediente.index')->with('error','Ha ocurrido un problema al intentar crear el expediente.');
            }catch (\Exception $e) {
                  $control = new Log();
                  $control->user_id = Auth::user()->id;
                  $control->username = Auth::user()->name;
                  $control->expediente_id = $creado['id'];
                  $control->campo = 'Caratulacion';
                  $control->descripcion = 'Error al intentar crear el registro en ExpedienteUsuarios';
                  $control->save();
                  DB::rollback();
                  throw $e;
            }
            return redirect()->route('expediente.misexpedientes')->with('success','Expediente Creado satisfactoriamente');
      }
      public function show(Expediente $expediente)
      {
            if (!($this->loadPermiso($expediente))){
                  return redirect()->route('expediente.index')->with('warning', 'Ud no tiene permisos para ver ni editar este expediente.');
            }
            $logs = DB::select("SELECT auditorias.* FROM auditorias WHERE expediente_id = $expediente->id ORDER BY created_at desc");

            $anexos = DB::select("SELECT
                  a.created_at,
                  a.file,
                  e.numero,
                  a.descripcion,
                  a.username,
                  a.url,
                  a.fecha_vto,
                  a.id,
                  a.foja,
                  a.anexo_providencia,
                  b.nombre AS clasificacion,
                  COUNT(c.id) AS cant_comentarios
                  FROM anexo a
                  INNER JOIN
                  clasificacion_anexo b ON a.clasificacion_id = b.id
                  INNER JOIN expediente e ON a.expediente_id = e.id
                  LEFT JOIN
                  comments c ON a.id = c.anexo_id
                  WHERE a.expediente_id = $expediente->id
                  GROUP BY a.created_at, a.file, e.numero, a.descripcion, a.username, a.id, a.foja, a.url, a.fecha_vto,a.anexo_providencia, b.nombre
                  ORDER BY a.id
            ");

            /*
            foreach ($anexos as $anexo) {
                  $pdfContent = Storage::get(asset($anexo->url . $anexo->file));
            }
            dd($pdfContent);
            */


            return view('expedientes.show', [
                  'logs'=>$logs,
                  'anexos'=>$anexos,
                  'expediente'=>$expediente,
            ]);
      }

      public function showPDF()
      {
            $pdf = PDF::loadView('http://expedientes.desarrollostello.com/uploads/R-0001-2019/2019-06-12-CD10074057.pdf');
            return $pdf->stream();
      }

      public function edit(Expediente $expediente)
      {
            if ($expediente->archivado == 0)
            {
                  $habilitados = DB::select("
                        SELECT
                        eu.user_id AS id,
                        eu.expediente_id,
                        users.`email`,
                        users.`name` AS usuario
                        FROM
                        expediente_usuarios eu
                        INNER JOIN users ON users.`id` = eu.`user_id`
                        WHERE
                        eu.expediente_id = $expediente->id
                        ");
                  //dd($habilitados);
                  //
                  $no_habilitados = DB::select("
                        SELECT DISTINCT
                        u.id,
                        u.email,
                        u.name AS usuario,
                        u.nombre
                        FROM
                        users u,
                        role_user
                        WHERE
                        u.id = role_user.user_id
                        AND
                        role_user.`role_id` != 1
                        AND NOT EXISTS (
                              SELECT DISTINCT
                              eu.user_id,
                              role_user.user_id,
                              eu.expediente_id
                              FROM
                              expediente_usuarios eu
                              WHERE
                              role_user.user_id = eu.user_id
                              AND
                              eu.expediente_id = $expediente->id
                              )
                  ");
                  /*
                  $no_habilitados = DB::select("
                        SELECT
                        u.id,
                        u.email,
                        u.name AS usuario,
                        u.nombre,
                        r.name AS rol
                        FROM
                        users u,
                        roles r,
                        role_user
                        WHERE
                        u.id = role_user.user_id
                        AND
                        role_user.role_id = r.id
                        AND
                        r.name != 'Administrador'
                        AND NOT EXISTS (
                              SELECT
                              eu.user_id,
                              role_user.user_id,
                              eu.expediente_id
                              FROM
                              expediente_usuarios eu
                              WHERE
                              role_user.user_id = eu.user_id
                              AND
                              eu.expediente_id = $expediente->id
                              )
                        ");
                  */
                  $logs = DB::select("SELECT
                        logs.*
                        FROM logs
                        WHERE
                        expediente_id = $expediente->id
                        ORDER BY created_at desc");

                  $anexos = DB::select("SELECT
                       a.created_at,
                       a.file,
                       a.descripcion,
                       a.username,
                       a.url,
                       a.fecha_vto,
                       a.id,
                       a.anexo_providencia,
                       b.nombre AS clasificacion,
                       COUNT(c.id) AS cant_comentarios
                       FROM anexo a
                       INNER JOIN
                       clasificacion_anexo b ON a.clasificacion_id = b.id
                       LEFT JOIN
                       comments c ON a.id = c.anexo_id
                       WHERE a.expediente_id = $expediente->id
                       GROUP BY a.created_at, a.file, a.descripcion, a.username, a.id, a.url, a.fecha_vto,a.anexo_providencia, b.nombre
                  ");

                    $tipoExpedientes = TipoExpediente::all()->pluck('nombre', 'id');
                    return view('expedientes.edit', [
                      'expediente' => $expediente,
                      'tipoExpedientes' => $tipoExpedientes,
                      'anexos' => $anexos,
                      'logs' =>$logs,
                      'habilitados' => $habilitados,
                      'no_habilitados'=>$no_habilitados
                    ]);
            }
      }

      public function update(ExpedienteRequest $expedienteRequest, Expediente $expediente)
      {
            if (!($this->loadPermiso($expediente))){
                  return redirect()->route('expediente.index')->with('warning', 'Ud no tiene permisos para ver ni editar este expediente.');
            }
            DB::beginTransaction();
            try
            {
                  /*
                  $administradores = DB::Select ("
                        SELECT
                        u.id AS usuario,
                        r.name AS rol
                        FROM
                        users u, roles r, role_user
                        WHERE
                        role_user.`role_id` = r.`id`
                        AND
                        role_user.`user_id` = u.`id`
                        AND
                        r.name = 'Administrador'
                        ");

                  foreach ($administradores as $admin) {
                        $idAdmin[] = $admin->usuario;
                  }
                  */
                  // Lo que hice fue capturar tosos los ID de los usuarios Administradores
                  $data = $expedienteRequest->all();
                  $expediente->fill($data)->update();

                  $permisosActuales = DB::table('expediente_usuarios')->where([
                                    ['expediente_id', '=', $expediente->id],
                  ])->delete();

                  /*
                  if ($permisosActuales)
                  {

                        foreach ($permisosActuales as $borrar)
                        {
                              //if (!(in_array($borrar->user_id, $idAdmin)))
                              //{

                              $borrado = DB::delete('delete from expediente_usuarios where user_id = ?',[$borrar->user_id]);
                              if($borrado)
                              {
                                    $email = DB::select("SELECT email FROM users u WHERE u.id = ?", [$borrar->user_id] );
                                    dd($email[0]->email);
                                    $this->enviar3($expediente);
                              }

                              //}
                        }

                  }
                  */

                  // Luego agrego los nuevos usuarios marcados para que puedan editar el expediente
                  if (isset($data['usuarios']))
                  {
                        foreach ($data['usuarios'] as $key => $value) {
                              $permisos = new ExpedienteUsuarios();
                              $permisos->expediente_id = $expediente->id;
                              $permisos->user_id = (int) $value;
                              $permisos->slug = str_slug($value . $expediente->id . rand(5,1000));
                              if($permisos->save())
                              {
                                    $usuario = DB::Select("SELECT * FROM users WHERE id = $value");
                                    $this->enviar_aviso($expediente, $usuario[0]);
                              }
                        }
                  }
                  /*
                  $email_administradores = DB::select("
                        SELECT u.email FROM users u, roles r, role_user ru WHERE ru.role_id = r.id AND ru.`user_id` = u.`id` AND  r.name = 'Administrador'
                  ");
                  if ($email_administradores)
                  {
                        foreach ($email_administradores as $administrador) {
                              $this->enviar_aviso_admin($expediente, $administrador->email);
                        }
                  }
                  */

            } catch(ValidationException $e)
            {
                $control = new Log();
                $control->user_id = Auth::user()->id;
                $control->username = Auth::user()->name;
                $control->expediente_id = $data['id'];
                $control->campo = 'Actualización';
                $control->descripcion = 'Error al intentar actualizar el Expediente: ' . $data['numero'];
                $control->save();
                  DB::rollback();
                  return redirect()->route('expediente.index')->with('error','Ha ocurrido un problema al intentar Actualizar el expediente.');
            }catch (\Exception $e) {
                  /*
                $control = new Log();
                $control->user_id = Auth::user()->id;
                $control->username = Auth::user()->name;
                $control->expediente_id = $data['id'];
                $control->campo = 'Actualización';
                $control->descripcion = 'Error al intentar actualizar el Expediente: ' . $data['numero'];
                $control->save();
                */
                  DB::rollback();
                  throw $e;
            }
            DB::commit();
            return redirect()->route('expediente.index')->with('success', 'Expediente actualizado satisfactoriamente');
      }

      public function avisar($expediente, $accion)
      {
            $funcion = '';
            if($accion == 'restore')
            {
                  $funcion = 'e_restore';
            }

            $habilitados = DB::select("
            SELECT
            u.id,
            u.email,
            u.name AS usuario,
            u.nombre,
            r.name AS rol
            FROM
            users u,
            roles r,
            role_user
            WHERE
            u.id = role_user.user_id
            AND
            role_user.role_id = r.id
            AND
            r.name != 'Administrador'
            AND EXISTS (
                  SELECT
                  eu.user_id,
                  role_user.user_id,
                  eu.expediente_id
                  FROM
                  expediente_usuarios eu
                  WHERE
                  role_user.user_id = eu.user_id
                  AND
                  eu.expediente_id = $expediente->id
                  )
            ");
            if($habilitados)
            {
                  foreach ($habilitados as $habilitado) {
                        $this->$funcion($expediente, $habilitado->email);
                  }
            }

            //$email_usuario_actual = DB::select("SELECT u.email FROM users u WHERE u.id =" . Auth::user()->id);
            //$this->enviar2($new_anexo, $email_usuario_actual[0]->email);
            $email_administradores = DB::select("
                  SELECT u.email FROM users u, roles r, role_user ru WHERE ru.role_id = r.id AND ru.`user_id` = u.`id` AND  r.name = 'Administrador'
            ");
            if ($email_administradores)
            {
                  foreach ($email_administradores as $administrador) {
                        $this->$funcion($expediente, $administrador->email);
                  }
            }
      }
            /*
                  Restaura un expediente que estaba en borrado logico
             */
      public function restore($id)
      {
            DB::beginTransaction();
            try
            {
                  $expediente = Expediente::withTrashed()->where('id', '=', $id)->first();
                  if($expediente->restore())
                  {
                        $this->avisar($expediente, 'restore');
                  }
            }catch(ValidationException $e)
            {
                $control = new Log();
                $control->user_id = Auth::user()->id;
                $control->username = Auth::user()->name;
                $control->expediente_id = $id;
                $control->campo = 'Restore';
                $control->descripcion = 'Error al intentar restaurar el Expediente: ' . $expediente->numero;
                $control->save();
                  DB::rollback();
                  return redirect()->route('expediente.index')->with('error','Ha ocurrido un problema al intentar Restaurar el expediente.');
            }catch (\Exception $e) {
                $control = new Log();
                $control->user_id = Auth::user()->id;
                $control->username = Auth::user()->name;
                $control->expediente_id = $id;
                $control->campo = 'Restore';
                $control->descripcion = 'Error al intentar restaurar el Expediente: ' . $expediente->numero;
                $control->save();
                  DB::rollback();
                  throw $e;
            }

            DB::commit();
            return redirect()->route('expediente.index')->with('success', 'Expediente Activado satisfactoriamente.');
      }

      /*
            El destroy es el borrado logico es el SoftDelete
       */
      public function delete(Expediente $expediente)
      {
            // Cuando ACtivo  o Archivo Expediente tengo que comunicarlo por mail a todos los que tenian acceso
            if (!($this->loadPermiso($expediente))){
                  return redirect()->route('expediente.index')->with('warning', 'Ud no tiene permisos para ver ni editar este expediente.');
            }

            DB::beginTransaction();
            try
            {
                  $expediente->delete();
            }catch(ValidationException $e)
            {
                $control = new Log();
                $control->user_id = Auth::user()->id;
                $control->username = Auth::user()->name;
                $control->expediente_id = $id;
                $control->campo = 'Delete';
                $control->descripcion = 'Error al intentar Borrar el Expediente: ' . $expediente->numero;
                $control->save();
                  DB::rollback();
                  return redirect()->route('expediente.index')->with('error','Ha ocurrido un problema al intentar Archivar el expediente.');
            }catch (\Exception $e) {
                  DB::rollback();
                  throw $e;
            }

            DB::commit();
            return redirect()->route('expediente.index')->with('success', 'Expediente Archivado satisfactoriamente.');
      }

      /*
            Borar es el borrado definitivo del sistema es el forceDelete()
       */
      public function borrar(Expediente $expediente)
      {
            // Cuando BOORA DEFINITIVAMENTE Expediente tengo que comunicarlo por mail a todos los que tenian acceso
            if (!($this->loadPermiso($expediente))){
                  return redirect()->route('expediente.index')->with('warning', 'Ud no tiene permisos para ver ni editar este expediente.');
            }

            DB::beginTransaction();
            try
            {
                  $expediente->forceDelete();
            }catch(ValidationException $e)
            {
                $control = new Log();
                $control->user_id = Auth::user()->id;
                $control->username = Auth::user()->name;
                $control->expediente_id = $id;
                $control->campo = 'Borrar Definitivamente';
                $control->descripcion = 'Error al intentar Borrar Definitivamente el Expediente: ' . $expediente->numero;
                $control->save();
                  DB::rollback();
                  return redirect()->route('expediente.index')->with('error','Ha ocurrido un problema al intentar Archivar el expediente.');
            }catch (\Exception $e) {
                  DB::rollback();
                  throw $e;
            }

            DB::commit();
            return redirect()->route('expediente.index')->with('success', 'Expediente BORRADO satisfactoriamente.');
      }

      private function enviar_aviso_admin($expediente, $email)
      {
            \Mail::Send('emails.enviar_aviso_admin',['nombre'=>'Asignación de Permiso', 'expediente'=>$expediente],function($message) use ($email){
                  $message->from('expedientes@desarrollostello.com', 'Expedientes');
                  $message->to($email)->subject('Sistema Expedientes - Nuevo Expediente');
            });
      }

      private function enviar_aviso($expediente, $usuario)
      {
            \Mail::Send('emails.permisosusuarios',['nombre'=>'Asignación de Permiso', 'expediente'=>$expediente, 'usuario'=>$usuario],function($message) use ($usuario){
                  $message->from('expedientes@desarrollostello.com', 'Expedientes');
                  $message->to($usuario->email)->subject('Sistema Expedientes - Nuevo Permiso');
            });
      }

      private function enviar2($expediente, $email)
      {
            \Mail::Send('emails.permisos',['nombre'=>'Asignación de Permiso', 'expediente'=>$expediente],function($message) use ($email){
                  $message->from('expedientes@desarrollostello.com', 'Expedientes');
                  $message->to($email)->subject('Sistema Expedientes - Nuevo Permiso');
            });
      }
      private function enviar3($expediente, $email)
      {
            \Mail::Send('emails.quitarpermiso',['nombre'=>'Quita de Permiso', 'expediente'=>$expediente],function($message) use ($email){
                  $message->from('expedientes@desarrollostello.com', 'Expedientes');
                  $message->to($email)->subject('Sistema Expedientes - Quita de Permiso');
            });
      }
      private function e_restore($expediente, $email)
      {
            \Mail::Send('emails.e-restore',['nombre'=>'Expediente Restaurado', 'expediente'=>$expediente],function($message) use ($email){
                  $message->from('expedientes@desarrollostello.com', 'Expedientes');
                  $message->to($email)->subject('Sistema Expedientes - Restaurar');
            });
      }
}
