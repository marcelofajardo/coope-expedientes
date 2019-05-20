<?php

namespace App\Http\Controllers;

use App\Expediente;
use App\Log;
use App\Http\Requests\LogRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{

      public function index()
      {
            $logs = Log::all();
            return view('logs.index', ['logs' => $logs, 'action'=>'index']);
      }


      public function create()
      {
            if (Auth::user()->rol->nombre == 'administrador')
            {
                  $expedientes = Expediente::all()->pluck('caratula', 'id');
                  return view('logs.create', ['expedientes'=> $expedientes]);
            }else{
                  Session::flash('message-warnning', 'El usuario logueado no está habilitado para realizar esta acción.');
                  return redirect()->route('log.index');
            }
      }


      public function store(LogRequest $logRequest)
      {
            $data = $logRequest->all();
            $data['user_id'] = Auth::user()->id;
            $data['username'] = Auth::user()->username;
            $creada = Log::create($data);
            if ($creada)
            {
                  // $this->enviar($despachoRequest->archivo);
                  Session::flash('message-success', 'Log guardado satisfactoriamente.');
                  return redirect()->route('log.index');
            }
      }


      public function show(Log $log)
      {
            return view('logs.show', compact('log'));
      }

      public function destroy(Log $log)
      {
            if (Auth::user()->rol->nombre == 'administrador')
            {
                  $log->delete();
                  Session::flash('message-danger', 'Log eliminado satisfactoriamente.');
                  return redirect()->route('log.index');
            }else{
                  Session::flash('message-warnning', 'El usuario logueado no está habilitado para realizar esta acción.');
                  return redirect()->route('log.index');
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
