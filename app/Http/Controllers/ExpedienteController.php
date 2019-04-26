<?php

namespace App\Http\Controllers;

use App\Expediente;
use App\Anexo;
use App\Auditoria;
use App\Comment;
use App\ExpedienteUsuarios;
use App\User;
use App\Log;
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
            /*
            $user = User::findOrFail(1);
            Mail::send('emails.permisosprueba',['user' => $user], function ($message) {
                  $message->from('maurotello73@gmail.com', $name = null);
                  $message->sender('maurotello73@gmail.com', $name = null);
                  $message->to('maurotello73@gmail.com', $name = null);
                  $message->subject('Prueba');
                  $message->getSwiftMessage();
            });*/
            /*
              Mail::send('emails.permisosprueba', ['user' => $user], function ($m) use ($user) {
                  $m->from('desarrollostello@gmail.com', 'Your Application');
                  $m->to($user->email, $user->name)->subject('Your Reminder!');
              });
              */
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
            $usuarios = User::get();
            // $usersNOadministrador = DB::select('SELECT u.id, u.username, u.nombre FROM users u, roles r WHERE u.rol_id = r.id AND r.nombre != :admin', ['admin' => 'administrador']);
            // TENGO QUE VER DE NO PASARLE LOS ADMINISTRADORES
            return view('expedientes.create', [
                  'tipoExpedientes'=> $tipoExpedientes,
                  'usuarios'=>$usuarios,
            ]);
      }

      public function store(ExpedienteRequest $expedienteRequest)
      {

            DB::beginTransaction();
            try {

                  //$errorCreacionLog = 0;
                  $data = $expedienteRequest->all();
                  $letra = TipoExpediente::where('id', $data['tipo_expediente_id'])->first();
                  $numero = DB::table('nroExpediente')->max('id');
                  $numero2 = str_pad($numero, 4, "0", STR_PAD_LEFT);
                  $anio = date('Y');
                  $data['numero'] = "$letra->letra-$numero2-$anio";
                  $data['slug'] = str_slug($data['caratula']) . "-" . rand(50,1000);
                  DB::table('nroExpediente')->increment('id');
                  $creado = Expediente::create($data);
                  /*
                  if ($enviado)
                  {
                        $control = new Log();
                        $control->user_id = Auth::user()->id;
                        $control->username = Auth::user()->name;
                        $control->expediente_id = $creado['id'];
                        $control->campo = 'MAIL ENVIADO';
                        $control->descripcion = 'MAIL ENVIDAO';
                        $control->save();
                  }else{


                        $control = new Log();
                        $control->user_id = Auth::user()->id;
                        $control->username = Auth::user()->name;
                        $control->expediente_id = $creado['id'];
                        $control->campo = 'MAIL NO ENVIADO';
                        $control->descripcion = 'MAIL NO ENVIDAO';
                        $control->save();
                  }
                  */

                  $administradores = DB::select('SELECT * FROM role_user ru, users u, roles r WHERE ru.role_id = r.id AND ru.`user_id` = u.`id` AND  r.name = :admin', ['admin' => 'Administrador']);


                  $email_administradores = DB::select("
                        SELECT u.email FROM users u, roles r, role_user ru WHERE ru.role_id = r.id AND ru.`user_id` = u.`id` AND  r.name = 'Administrador'
                  ");
                  if (isset($data['usuarios']))
                  {
                        foreach ($data['usuarios'] as $key => $value) {
                              $permisos = new ExpedienteUsuarios();
                              $permisos->expediente_id = $creado['id'];
                              $permisos->user_id = (int)$value;
                              $permisos->slug = str_slug($creado['id'] . '-' . $value . '-' . rand(5,10000));
                              $permisos->save();
                              $email_usuario = DB::select("SELECT u.email FROM users u WHERE u.id =" . $permisos->user_id);

                              $this->enviar2($creado, $email_usuario[0]->email);
                        }
                  }
                  $permisos = new ExpedienteUsuarios();
                  $permisos->expediente_id = $creado['id'];
                  $permisos->user_id = Auth::user()->id;
                  $permisos->slug = str_slug($creado['id'] . '-' . str_slug($creado['caratula']) . '-' . rand(5000,10000));
                  $permisos->save();
                  $email_usuario_actual = DB::select("SELECT u.email FROM users u WHERE u.id =" . Auth::user()->id);
                  //dd($email_usuario_actual[0]->email);
                  $this->enviar2($creado, $email_usuario_actual[0]->email);
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


            return redirect()->route('expediente.index')->with('success','Expediente Creado satisfactoriamente');
      }
      public function show(Expediente $expediente)
      {
            if (!($this->loadPermiso($expediente))){
                  return redirect()->route('expediente.index')->with('warning', 'Ud no tiene permisos para ver ni editar este expediente.');
            }
            $logs = DB::select("SELECT logs.* FROM logs WHERE expediente_id = $expediente->id ORDER BY created_at desc");
            //dd($logs['0']);
            /*
            $logs = DB::select("SELECT
                  created_at,
                  expediente_id,
                  clasificacion,
                  username,
                  descripcion,
                  user_id,
                  anexo_providencia,
                  url,
                  archivo FROM
                  ( SELECT
                  created_at,
                  expediente_id,
                  campo AS clasificacion,
                  username,
                  campo AS descripcion,
                  user_id,
                  'Providencia' AS anexo_providencia,
                  null AS url,
                  null AS archivo
                  FROM logs
                  UNION SELECT
                  anexo.created_at,
                  expediente_id,
                  clasificacion_anexo.nombre AS clasificacion,
                  username,
                  descripcion,
                  user_id,
                  anexo_providencia,
                  url,
                  file as archivo
                  FROM anexo
                  JOIN clasificacion_anexo
                  ON anexo.clasificacion_id=clasificacion_anexo.id) AS a
                  WHERE expediente_id = $expediente->id
                  ORDER BY created_at desc");
            */

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

            //dd($logs);
                  /*
                    $anexos = DB::select("SELECT
                      a.created_at,
                      a.file,
                      a.descripcion,
                      a.username,
                      a.url,
                      a.fecha_vto,
                      a.anexo_providencia,
                      c.nombre AS clasificacion
                      FROM anexo a, clasificacion_anexo c
                      WHERE
                      a.clasificacion_id = c.id
                      AND a.expediente_id = $expediente->id
                      ORDER BY a.created_at desc");
                        */
                      //$comentarios = $anexos->comments();
            return view('expedientes.show', [
                  'logs'=>$logs,
                  //'comentarios' => $comentarios,
                  'anexos'=>$anexos,
                  'expediente'=>$expediente,
            ]);
      }

      public function edit(Expediente $expediente)
      {
            if ($expediente->archivado == 0)
            {
                $habilitados = DB::select("
                        SELECT
                        u.id,
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
                $no_habilitados = DB::select("
                        SELECT
                        u.id,
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
                  $logs = DB::select("SELECT logs.* FROM logs WHERE expediente_id = $expediente->id ORDER BY created_at desc");

                  /*
                $logs = DB::select("SELECT
                created_at,
                expediente_id,
                clasificacion,
                username,
                descripcion,
                user_id,
                anexo_providencia,
                url,
                archivo FROM
                ( SELECT
                  created_at,
                  expediente_id,
                  campo AS clasificacion,
                  username,
                  campo AS descripcion,
                  user_id,
                 'Providencia' AS anexo_providencia,
                  null AS url,
                  null AS archivo
                  FROM logs
                  UNION SELECT
                  anexo.created_at,
                  expediente_id,
                  clasificacion_anexo.nombre AS clasificacion,
                  username,
                  descripcion,
                  user_id,
                  anexo_providencia,
                  url,
                  file as archivo
                  FROM anexo
                  JOIN clasificacion_anexo
                  ON anexo.clasificacion_id=clasificacion_anexo.id) AS a
                  WHERE expediente_id = $expediente->id
                  ORDER BY created_at desc");
                  */
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
                  /*
                  $logs = DB::table('logs')
                      ->where('expediente_id', '=', $expediente->id)
                      ->get();
                      $anexos = Anexo::join('clasificacion_anexo AS c', 'clasificacion_id', '=', 'c.id')
                                    ->where('expediente_id', '=', $expediente->id)
                                    ->get();
                */
                    $tipoExpedientes = TipoExpediente::all()->pluck('nombre', 'id');
                    return view('expedientes.edit', [
                      'expediente' => $expediente,
                      'tipoExpedientes' => $tipoExpedientes,
                      'anexos' => $anexos,
                      'logs' =>$logs,
                      'habilitados' => $habilitados,
                      'no_habilitados'=>$no_habilitados
                    ]);
                  //  return view('roles.edit', compact('rol'));

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

                        //$usuarioAdministrador = $administradores[0]->usuario;
                  foreach ($administradores as $admin) {
                        $idAdmin[] = $admin->usuario;
                  }
                  $data = $expedienteRequest->all();
                  $expediente->fill($data)->update();

                  $permisosBorrados = DB::table('expediente_usuarios')->where([
                                    ['expediente_id', '=', $expediente->id],
                  ])->get();

                  foreach ($permisosBorrados as $borrar) {
                        if (!(in_array($borrar->user_id, $idAdmin)))
                        {
                            DB::delete('delete from expediente_usuarios where user_id = ?',[$borrar->user_id]);
                        }
                  }
                  if ($permisosBorrados){
                        if (isset($data['usuarios']))
                        {
                              foreach ($data['usuarios'] as $key => $value) {
                                    $permisos = new ExpedienteUsuarios();
                                    $permisos->expediente_id = $expediente->id;
                                    $permisos->user_id = (int) $value;
                                    $permisos->slug = str_slug($value . $expediente->id . rand(5,1000));
                                    $permisos->save();
                              }
                        }
                  }
            } catch(ValidationException $e)
            {
                  DB::rollback();
                  return redirect()->route('expediente.index')->with('error','Ha ocurrido un problema al intentar Actualizar el expediente.');
            }catch (\Exception $e) {
                  DB::rollback();
                  throw $e;
            }
            DB::commit();
            return redirect()->route('expediente.index')->with('success', 'Expediente actualizado satisfactoriamente');
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
                  $expediente->restore();
            }catch(ValidationException $e)
            {
                  DB::rollback();
                  return redirect()->route('expediente.index')->with('error','Ha ocurrido un problema al intentar Restaurar el expediente.');
            }catch (\Exception $e) {
                  DB::rollback();
                  throw $e;
            }

            DB::commit();
            return redirect()->route('expediente.index')->with('success', 'Expediente Activado satisfactoriamente.');
      }

      /*
            El destroy es el borrado logico es el SoftDelete
       */
      public function destroy(Expediente $expediente)
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
                  DB::rollback();
                  return redirect()->route('expediente.index')->with('error','Ha ocurrido un problema al intentar Archivar el expediente.');
            }catch (\Exception $e) {
                  DB::rollback();
                  throw $e;
            }

            DB::commit();
            return redirect()->route('expediente.index')->with('success', 'Expediente BORRADO satisfactoriamente.');
      }

      private function enviar($expediente, $administradores)
      {
      foreach ($administradores as $admin) {
            $email = $admin->email;
            \Mail::Send('emails.permisos',['nombre'=>'Asignación de Permiso', 'expediente'=>$expediente],function($message) use ($email){
                $message->from('expedientes@desarrollostello.com', 'Expedientes');
                $message->to($email)->subject('Sistema Expedientes - Permisos');
            });
      }
      }

      private function enviar2($expediente, $email)
      {

        \Mail::Send('emails.permisos',['nombre'=>'Asignación de Permiso', 'expediente'=>$expediente],function($message) use ($email){
            $message->from('expedientes@desarrollostello.com', 'Expedientes');
            $message->to($email)->subject('Sistema Expedientes - Nuevo Permiso');
        });
      }
}
