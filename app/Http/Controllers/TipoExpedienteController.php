<?php

namespace App\Http\Controllers;

use App\TipoExpediente;
use App\Http\Requests\TipoExpedienteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TipoExpedienteController extends Controller
{

    public function index()
    {
        $tiposExpedientes = TipoExpediente::all();

        return view('tiposexpedientes.index', ['tiposExpedientes' => $tiposExpedientes, 'action'=>'index']);
    }

    public function create()
    {
        return view('tiposexpedientes.create');
    }


    public function store(TipoExpedienteRequest $tipoExpedienteRequest)
    {
        $data = $tipoExpedienteRequest->all();
        $creada = TipoExpediente::create($data);
        if ($creada)
        {
           // $this->enviar($despachoRequest->archivo);
            Session::flash('message-success', 'Tipo de Expediente guardado satisfactoriamente.');
            return redirect()->route('tipoexpediente.index');
        }
    }

    public function show(TipoExpediente $tipoExpediente)
    {
        return view('tiposexpedientes.show', compact('tipoExpediente'));
    }


    public function edit(TipoExpediente $tipoExpediente)
    {
        return view('tiposexpedientes.edit', ['tipoExpediente' => $tipoExpediente]);
      //  return view('roles.edit', compact('rol'));
    }

    public function update(TipoExpedienteRequest $tipoExpedienteRequest, TipoExpediente $tipoExpediente)
    {
        $tipoExpediente->fill($tipoExpedienteRequest->all())->update();
        Session::flash('message-success', 'Tipo de Expediente actualizado satisfactoriamente.');
        return redirect()->route('tipoexpediente.index');
    }

      public function destroy(TipoExpediente $tipoExpediente)
      {
            $tipoExpediente->delete();
            Session::flash('message-danger', 'Tipo de Expediente eliminado satisfactoriamente.');
            return redirect()->route('tipoexpediente.index');
      }
}
