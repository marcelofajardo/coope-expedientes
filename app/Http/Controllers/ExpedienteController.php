<?php

namespace App\Http\Controllers;

use App\Expediente;
use App\Anexo;
use App\Comment;
use App\ExpedienteUsuarios;
use App\User;
use App\Log;
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

             return $permiso;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          //dd(Auth::user()->roles[0]->name);
        $expedientes = Expediente::all();
        //$rol = Auth::user()->rol->nombre;
        return view('expedientes.index', [
          'expedientes' => $expedientes,
          'action'=>'index'
        ]);
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
        //$usuarios = User::all()->pluck('username','id');
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
      try {
            $errorCreacionLog = 0;
            $data = $expedienteRequest->all();

            $letra = TipoExpediente::where('id', $data['tipo_expediente_id'])->first();
            //dd($letra->letra);
            $numero = DB::table('nroExpediente')->max('id');

            $numero2 = str_pad($numero, 4, "0", STR_PAD_LEFT);
            $anio = date('Y');
            $data['numero'] = "$letra->letra-$numero2-$anio";

            $data['slug'] = str_slug($data['caratula']) . "-" . rand(5,1000);
            $creado = Expediente::create($data);
            $administradores = DB::select('SELECT * FROM role_user ru, users u, roles r WHERE ru.role_id = r.id AND ru.`user_id` = u.`id` AND  r.name = :admin', ['admin' => 'Administrador']);

            if ($creado)
            {
                  $email_administradores = DB::select("
                                              SELECT u.email FROM users u, roles r, role_user ru WHERE ru.role_id = r.id AND ru.`user_id` = u.`id` AND  r.name = 'Administrador'
                                        ");
                  //DB::table('nroExpediente')->max('id');
                  DB::table('nroExpediente')->increment('id');

                  if (isset($data['usuarios']))
                  {
                        foreach ($data['usuarios'] as $key => $value) {
                            $permisos = new ExpedienteUsuarios();
                            $permisos->expediente_id = $creado['id'];
                            $permisos->user_id = (int)$value;
                            $permisos->slug = str_slug($creado['id'] . '-' . $value . '-' . rand(5,10000));
                            $permisos->save();

                            $email_usuario = DB::select("SELECT u.email FROM users u WHERE u.id =" . $permisos->user_id);
                            $this->enviar($creado, $email_usuario);
                        }

                  }
                  /*
                  foreach ($administradores[0] as $key => $value) {
                        $permisos = new ExpedienteUsuarios();
                        $permisos->expediente_id = $creado['id'];
                        $permisos->user_id = (int) $value->id;
                        $permisos->slug = str_slug($creado['id'] . '-' . $value . '-' . rand(5,10000));
                        $permisos->save();
                        $this->enviar($creado, $email_administradores);

                  }
                  */
                  $permisos = new ExpedienteUsuarios();
                  $permisos->expediente_id = $creado['id'];
                  $permisos->user_id = Auth::user()->id;
                  $permisos->slug = str_slug($creado['id'] . '-' . $value . '-' . rand(5,10000));
                  $permisos->save();

                  $email_usuario_actual = DB::select("SELECT u.email FROM users u WHERE u.id =" . Auth::user()->id);

                  $this->enviar($creado, $email_usuario_actual);

                  $control = new Log();
                  $control->user_id = Auth::user()->id;
                  $control->username = Auth::user()->name;
                  $control->expediente_id = $creado['id'];
                  $control->campo = 'Caratulacion';
                  if (!($control->save()))
                  {
                    $errorCreacionLog = 1;
                  }
                  if ($errorCreacionLog == 1)
                  {
                        return redirect()->route('expediente.index')->with('warning','Expediente Creado satisfactoriamente. Pero hubo un error en la creación del Log');
                  }else{
                        return redirect()->route('expediente.index')->with('success','Expediente Creado satisfactoriamente.');
                  }

            }else{
              return redirect()->route('expediente.index')->with('error','Ha ocurrido un problema al intentar crear el expediente.');
            }
      }catch (\Illuminate\Database\QueryException $e) {
        dd($e->getMessage());
      } catch (\Exception $e) {
        dd($e->getMessage());
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Expediente $expediente)
    {
      if (!($this->loadPermiso($expediente))){
        return redirect()->route('expediente.index')->with('warning', 'Ud no tiene permisos para ver ni editar este expediente.');
      }
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

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

                  $anexos = DB::select("SELECT
                    a.created_at,
                    a.file,
                    a.descripcion,
                    a.username,
                    a.url,
                    a.fecha_vto,
                    c.nombre AS clasificacion
                    FROM anexo a, clasificacion_anexo c
                    WHERE
                    a.clasificacion_id = c.id
                    AND a.expediente_id = $expediente->id
                    ORDER BY a.created_at desc");

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

      if ($expediente->archivado == 0)
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
          return redirect()->route('expediente.index')->with('success', 'Expediente actualizado satisfactoriamente');
      }
    }



    public function eliminated()
    {
      if (!($this->loadPermiso($expediente))){
        Session::flash('message-danger', 'Ud no tiene permisos para ver ni editar este expediente.');
        return redirect()->route('expediente.index');
      }
        $expedientesArchivados = Expediente::where('archivado', '1')->get();
        return view('expedientes.eliminated', ['expedientes' => $expedientesArchivados, 'action' => 'restore']);
    }

    public function restore($id)
    {
        $expediente = Expediente::withTrashed()->where('slug', '=', $id)->first();
        $expediente->restore();
        return redirect()->route('expediente.index')->with('success', 'Expediente restaurado satisfactoriamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
      public function destroy(Expediente $expediente)
      {
            if (!($this->loadPermiso($expediente))){
                  return redirect()->route('expediente.index')->with('warning', 'Ud no tiene permisos para ver ni editar este expediente.');
            }
            if ($expediente->archivado == 0)
            {
                $expediente['archivado'] = 1;
                $ok = $expediente->save();
                  if ($ok)
                  {
                        $control = new Log();
                        $control->user_id = Auth::user()->id;
                        $control->username = Auth::user()->name;
                        $control->expediente_id = $expediente['id'];
                        $control->campo = 'Archivado';
                        if($control->save())
                        {
                              return redirect()->route('expediente.index')->with('success', 'Expediente Archivado satisfactoriamente.');
                        }

                  }else{
                        return redirect()->route('expediente.index')->with('warning', 'Ocurrió un error al intentar Archivar el Expediente.');
                  }
            }else {
                  $expediente['archivado'] = 0;
                  $ok = $expediente->save();

                  if ($ok)
                  {
                        $control = new Log();
                        $control->user_id = Auth::user()->id;
                        $control->username = Auth::user()->name;
                        $control->expediente_id = $expediente['id'];
                        $control->campo = 'Archivado';
                        if($control->save())
                        {
                              return redirect()->route('expediente.index')->with('success', 'Expediente Archivado satisfactoriamente.');
                        }

                  }else{
                        return redirect()->route('expediente.index')->with('warning', 'Ocurrió un error al intentar Archivar el Expediente.');
                  }
            }
      }


    private function enviar($expediente, $administradores)
    {
      foreach ($administradores as $admin) {
            $email = $admin->email;

            \Mail::Send('emails.permisos',['nombre'=>'Asignación de Permiso', 'expediente'=>$expediente],function($message) use ($email){
                $message->from('maurotello73@gmail.com', 'Expedientes');
                $message->to($email)->subject('Sistema Expedientes - Permiso');
            });
      }
    }

}
