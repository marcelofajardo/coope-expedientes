<?php

namespace App\Http\Controllers;

use App\Anexo;
use App\Expediente;
use App\Comment;
use App\ExpedienteUsuarios;
use Illuminate\Support\Facades\DB;
use App\ClasificacionAnexo;
use App\Http\Requests\AnexoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class AnexoController extends Controller
{
      public function admin()
      {
            $user = Auth::user()->id;
            $rol = DB::select("SELECT roles.id FROM role_user ru
                  INNER JOIN roles ON ru.`role_id` = roles.`id`
                  INNER JOIN users ON ru.`user_id` = users.`id`
                  WHERE
                  users.`id` = $user AND roles.name = 'Administrador'");

            return ($rol['0']->id >= 1) ? true : false;
      }

      public function index()
      {
            if($this->admin())
            {
                  $anexos = Anexo::all();
            }else{
                  // esto lo hago para que vea solamente los anexos de los expedientes del usuario o de los que tiene permiso
                  // excepto que sea administrador
                  $use = Auth::user()->id;
                  $anexos = Anexo::with(['expediente', 'user', 'expediente.expUsuarios'])
                              ->whereHas('expediente.expUsuarios', function($q) use ($use){
                                    $q->where('user_id', Auth::user()->id);
                              })
                              ->get();
            }
            return view('anexos.index', ['anexos' => $anexos, 'action'=>'index']);
      }


      public function create()
      {
            $clasificacionAnexo = ClasificacionAnexo::all()->pluck('nombre', 'id');
            $expedientes = Expediente::all()->pluck('caratula', 'id');
            return view('anexos.create', [
            'clasificacionAnexo'=> $clasificacionAnexo,
            'expedientes' => $expedientes,
            ]);
      }

      public function create_exp(Expediente $expediente)
      {
            $clasificacionAnexo = ClasificacionAnexo::all()->pluck('nombre', 'id');
            $expedientes = Expediente::where('id', $expediente->id)->pluck('caratula', 'id');
            return view('anexos.create_exp', [
            'clasificacionAnexo'=> $clasificacionAnexo,
            'expedientes' => $expedientes,
            ]);
      }


     public function store(AnexoRequest $request)
     {
            $proviene = Session::get('proviene');
            $rou = 'expediente.' . $proviene;
            $data = $request->all();
            $creada = false;
            if($data['anexo_providencia'] == 'Anexo')
            {
                  $archivo_no_permitido = 0;
                  $allowedfileExtension=['xls','xlsx','XLS','XLSX','ZIP','zip','jpeg','JPEG', 'pdf','jpg','png', 'doc','docx','JPG','PDF','PNG','DOC', 'DOCX', 'txt', 'TXT', 'gif', 'GIF'];
                  $files = $data['files'];

                  foreach($files as $file)
                  {
                        $filename = $file->getClientOriginalName();
                        $extension = $file->getClientOriginalExtension();
                        $check=in_array($extension,$allowedfileExtension);
                        $text = (string) str_slug( \Carbon\Carbon::parse($data['fecha_vto'])->format('Y-m-d'));
                        $filename = $text . '-' . $filename;
                        if($check)
                        {
                              $destinationPath = 'uploads/';
                              $file->move($destinationPath, $filename);
                              $new_anexo = new Anexo();
                              $new_anexo->user_id = Auth::user()->id;
                              $new_anexo->expediente_id = $data['expediente_id'];
                              $new_anexo->clasificacion_id =$data['clasificacion_id'];
                              $new_anexo->username = Auth::user()->name;
                              $new_anexo->descripcion = $data['descripcion'];
                              if ($data['fecha_vto'])
                                    $new_anexo->fecha_vto = \Carbon\Carbon::parse($data['fecha_vto'])->format('Y-m-d');
                              $new_anexo->file = $filename;
                              $new_anexo->url = 'uploads';
                              $new_anexo->anexo_providencia = $data['anexo_providencia'];
                              $new_anexo->slug = substr(str_slug(Auth::user()->name), 0, 10) . '-'. substr(str_slug($filename), 0, 10) . '-' . rand(50,1000);
                              $creada = $new_anexo->save();
                        }else{
                              $archivo_no_permitido = 1;
                        }
                  }

                  if ($creada)
                  {
                        //$this->enviar($new_anexo);
                        if ($archivo_no_permitido == 1){
                              return redirect()->route($rou)->with('warning','Uno o varios archivos adjuntos no están permitidos');
                        }else{
                              //return Redirect()->back()->with(['success' => 'Anexo guardado satisfactoriamente']);
                              return redirect()->route($rou)->with('success','Anexo guardado satisfactoriamente.');
                        }
                  }else{
                        if ($archivo_no_permitido == 1){
                              return redirect()->route($rou)->with('error','Ocurrio un Error! Además uno o varios archivos adjuntos no están permitidos');
                        }else{
                              return redirect()->route($rou)->with('error','Ocurrió un error al guardar.');
                        }
                  }
            }else{
                  $new_anexo = new Anexo();
                  $new_anexo->user_id = Auth::user()->id;
                  $new_anexo->expediente_id = $data['expediente_id'];
                  $new_anexo->username = Auth::user()->name;
                  $new_anexo->descripcion = $data['descripcion'];
                  $new_anexo->clasificacion_id =$data['clasificacion_id'];
                  $new_anexo->anexo_providencia = $data['anexo_providencia'];
                  if ($data['fecha_vto'])
                        $new_anexo->fecha_vto = \Carbon\Carbon::parse($data['fecha_vto'])->format('Y-m-d');
                  $new_anexo->slug = $new_anexo->slug = substr(str_slug(Auth::user()->name), 0, 10) . '-'. str_slug($data['anexo_providencia']) . '-' . rand(50,1000);
                  $creada = $new_anexo->save();

                  if ($creada)
                  {
                        return redirect()->route($rou)->with('success','Providencia guardada satisfactoriamente.');
                  }else{
                        return redirect()->route($rou)->with('error','Ocurrió un error al guardar.');
                  }
            }
      }

      public function show(Anexo $anexo)
      {
            $comments = Comment::all();
            return view('anexos.show', [
             'anexo'    => $anexo,
             'comment'  => $comments
            ]);
      }
      public function show1($id)
      {
            $anexo = Anexo::find($id);
            $comments = Comment::all();
            return view('anexos.show', [
                  'anexo'    => $anexo,
                  'comment'  => $comments
            ]);
      }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     /*
    public function edit(Anexo $anexo)
    {
        $clasificacionAnexo = ClasificacionAnexo::all()->pluck('nombre', 'id');
        $expedientes = Expediente::all()->pluck('caratula', 'id');
        return view('anexos.edit', [
          'anexo' => $anexo,
          'clasificacionAnexo' => $clasificacionAnexo,
          'expedientes' => $expedientes,

        ]);
      //  return view('roles.edit', compact('rol'));
    }
*/
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AnexoRequest $anexoRequest, Anexo $anexo)
    {
      if($anexo->fill($anexoRequest->all())->update())
      {
            return redirect()->route('anexo.index')->with('success','Anexo actualizado satisfactoriamente.');
      }else{
            return redirect()->route('anexo.index')->with('error','Ocurrió un error al intentar actualizar el Anexo.');
      }
    }

    public function eliminated()
    {
        if ($anexosEliminados = Anexo::onlyTrashed()->get())
        return view('anexos.eliminated', ['anexos' => $anexosEliminados, 'action' => 'restore']);
    }

      public function restore($id)
      {
            $anexo = Anexo::withTrashed()->where('slug', '=', $id)->first();
            if($anexo->restore())
            {
                  return redirect()->route('anexo.index')->with('success','Anexos restaurado satisfactoriamente.');
            }else{
                  return redirect()->route('anexo.index')->with('error','Ocurrió un error al intentar Restaurar el Anexo.');
            }

      }


      public function destroyddddddd(Anexo $anexo)
      {
            $todos = Anexo::all();
            $ultimo_id = $todos->last();
            $id_anexo = $anexo['id'];
            $usuario = $anexo['user_id'];

            if ((Auth::user()->id == $anexo['user_id']) AND ($anexo['id'] == $ultimo_id->id))
            {
                  $anexo->delete();
                  Session::flash('message-danger', 'Anexo eliminado satisfactoriamente.');
            }else{
                  Session::flash('message-danger', 'Este anexo no está habilitado para ser borrado.');
            }
            return redirect()->route('anexo.index');
      }

    public function destroyAjax($id)
    {
            Anexo::destroy($id);
            Session::flash('message-danger', 'Anexo eliminado satisfactoriamente.');
            return redirect()->route('expediente.index');
    }

      public function destroy(Anexo $anexo)
      {


            //$archivo = Anexo::where('slug', $slug)->first();
            if (Auth::user()->id == $anexo['user_id'])
            {
                  if (Anexo::where('slug' , $anexo->slug)->delete())
                  {
                        if($anexo['anexo_providencia'] == 'Anexo')
                        {
                              if(file_exists('uploads/' . $anexo->file))
                              {
                                    unlink('uploads/' . $anexo->file);
                              }else{
                                   Session::flash('message-danger', 'El Archivo no existe en el disco');
                             }
                        }
                       Session::flash('message-success', 'Anexo borrado correctamente !!!');
                  }else{
                        Session::flash('message-danger', 'Error al intentar eliminar el Anexo');
                  }
                  return redirect()->route('anexo.index');
            }else{
                Session::flash('message-danger', 'Este anexo no está habilitado para ser borrado.');
            }
            return redirect()->route('anexo.index');
      }

      public function deletefile($slug)
      {
            $archivo = Anexo::where('slug', $slug)->first();
            if (Anexo::where('slug' , $archivo->slug)->delete())
            {
            if(file_exists($archivo->file))
            {
                unlink($archivo->file);
            }else{
                 return back()->with('message-danger', 'El archivo no Existe en el Disco');
            }
            return back()->withSuccess('Archivo Borrado Correctamente!');
            }else{
            Session::flash('message-danger', 'Error al intentar eliminar el Anexo');
            }
      }
    /*
    public function destroy2()
    {
          $id=Input::get('id');
          dd($id);
          $anexo=Anexo::find($id);
          if($anexo)
          {
              $anexo->delete();
              return Redirect::back();
          }
    }
    */
/*
    private function enviar($new_anexo)
    {
        $permisos = DB::select("SELECT u.id, u.email, eu.expediente_id FROM users u, expediente_usuarios eu WHERE u.`id` = eu.`user_id` AND eu.`expediente_id` = $new_anexo->expediente_id");
        //$permiso = ExpedienteUsuarios::where('expediente_id', $new_anexo->expediente_id)->get();
        //dd($permisos);
        foreach ($permisos as $permiso) {
            $mail =  $permiso->email;
            //echo $mail . "<br />";

            \Mail::Send('emails.notification',['nombre'=>'Aviso de Carga al Sistema', 'new_anexo'=>$new_anexo],function($message){
                $message->from('maurotello73@gmail.com', 'Sistema');
                $message->to("'"$mail"'")->subject('Sistema Expedientes - Movimiento');
            });
        }
    }
    */
}
