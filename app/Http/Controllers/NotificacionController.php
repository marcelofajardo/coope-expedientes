<?php

namespace App\Http\Controllers;

use App\Notificacion;
use App\User;
use App\Http\Requests\NotificacionRequest;
use Illuminate\Http\Request;
use Caffeinated\Shinobi\Traits\ShinobiTrait;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class NotificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //dd(Auth::user()->roles);
      if (Auth::user()->isRole('Administrador')) {
        $notificaciones = Notificacion::all();
      }else{
        $notificaciones = Notificacion::where('user_id','=',Auth::user()->id)->get();
      }

        return view('notificaciones.index', ['notificaciones' => $notificaciones, 'action'=>'index']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $usuarios = User::all()->pluck('username', 'id');
        return view('notificaciones.create',[
            'usuarios' => $usuarios,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NotificacionRequest $notificacionRequest)
    {
        $data = $notificacionRequest->all();
        $creada = Notificacion::create($data);
        if ($creada)
        {
           // $this->enviar($despachoRequest->archivo);
            Session::flash('message-success', 'Notificacion guardada satisfactoriamente.');
            return redirect()->route('notificacion.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Notificacion $notificacion)
    {
        return view('notificaciones.show', compact('notificacion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Notificacion $notificacion)
    {
      if($notificacion->leida == 'NO')
      {
        $notificacion->leida = 'SI';
      }else {
        $notificacion->leida = 'NO';
      }
      $leida = $notificacion->update();
      if ($leida){
        Session::flash('message-success', 'Notificacion actualizada correctamente.');
        return redirect()->route('notificacion.index');
      }else{
        Session::flash('message-danger', 'Ocurrió un error al intentar poner la notificación como leida.');
        return redirect()->route('notificacion.index');
      }
     /*
        $usuarios = User::all()->pluck('username', 'id');
        return view('notificaciones.edit', [
            'notificacion' => $notificacion,
            'usuarios' => $usuarios,
        ]);
        */
      //  return view('roles.edit', compact('rol'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NotificacionRequest $notificacionRequest, Notificacion $notificacion)
    {
        $notificacion->fill($notificacionRequest->all())->update();
        Session::flash('message-success', 'Notificacion actualizada satisfactoriamente.');


        /* ESTO ES PARA ARMAR LA ALERTA QUE APARECERA DESDE LA DERECHA DE LA PANTALLA
        ES UNA MUESTRA*/
        $noti = array(
            'message' => 'Gracias! Su mensaje se a enviado con exito.',
            'alert-type' => 'success'
        );

        /* HAGO EL REDIRECT CON LA NOTIFICACION EN ALERTA DESPUES TENGO QUE SACARLA*/
       return redirect()->route('notificacion.index')->with($noti);


        //return redirect()->route('notificacion.index');
    }

    public function eliminated()
    {
        $notificacionEliminados = Notificacion::onlyTrashed()->get();
        return view('notificaciones.eliminated', ['notificaciones' => $notificacionEliminados, 'action' => 'restore']);
    }

    public function restore($id)
    {
        $notificacion = Notificacion::withTrashed()->where('slug', '=', $id)->first();
        $notificacion->restore();
        Session::flash('message-success', 'Notificacion restaurada satisfactoriamente.');
        return redirect()->route('notificacion.index');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notificacion $notificacion)
    {
        $notificacion->delete();
        Session::flash('message-danger', 'Notificacion eliminada satisfactoriamente.');
        return redirect()->route('notificacion.index');
    }
}
