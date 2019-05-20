<?php

namespace App\Http\Controllers;

use App\Expediente;
use App\Auditoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class AuditoriaController extends Controller
{

      public function index()
      {
            $auditorias = Auditoria::all();
            return view('auditorias.index', ['auditorias' => $auditorias, 'action'=>'index']);
      }


      public function create()
      {
            if (Auth::user()->rol->nombre == 'administrador')
            {
                  $expedientes = Expediente::all()->pluck('caratula', 'id');
                  return view('auditorias.create', ['expedientes'=> $expedientes]);
            }else{
                  Session::flash('message-warnning', 'El usuario  no está habilitado para realizar esta acción.');
                  return redirect()->route('auditoria.index');
            }
      }


      public function store(AuditoriaRequest $auditoriaRequest)
      {
            $data = $auditoriaRequest->all();
            $data['user_id'] = Auth::user()->id;
            $data['username'] = Auth::user()->username;
            $creada = Auditoria::create($data);
            if ($creada)
            {
                  // $this->enviar($despachoRequest->archivo);
                  Session::flash('message-success', 'Auditoria guardado satisfactoriamente.');
                  return redirect()->route('auditoria.index');
            }
      }


      public function show(Auditoria $auditoria)
      {
            return view('auditorias.show', compact('auditoria'));
      }

      public function destroy(Auditoria $auditoria)
      {
            if (Auth::user()->rol->nombre == 'administrador')
            {
                  $auditoria->delete();
                  Session::flash('message-danger', 'Auditoria eliminado satisfactoriamente.');
                  return redirect()->route('auditoria.index');
            }else{
                  Session::flash('message-warnning', 'El usuario Auditoriaueado no está habilitado para realizar esta acción.');
                  return redirect()->route('auditoria.index');
            }
      }

    /*
    private function enviar($dato)
    {
        \Mail::Send('emails.notification',['nombre'=>'Aviso de Carga al Sistema', 'dato'=>$dato],function($message){
            $message->from('maurotello73@gmail.com', 'Sistema');
            $message->to('maurotello73@gmail.com')->subject('Sistema - Mails');
        });
    }
    */
}
