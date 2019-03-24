<?php

namespace App\Http\Controllers;

use App\TipoExpediente;
use App\Http\Requests\TipoExpedienteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TipoExpedienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tiposExpedientes = TipoExpediente::all();

        return view('tiposexpedientes.index', ['tiposExpedientes' => $tiposExpedientes, 'action'=>'index']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tiposexpedientes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(TipoExpediente $tipoExpediente)
    {
        return view('tiposexpedientes.show', compact('tipoExpediente'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(TipoExpediente $tipoExpediente)
    {
        return view('tiposexpedientes.edit', ['tipoExpediente' => $tipoExpediente]);
      //  return view('roles.edit', compact('rol'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TipoExpedienteRequest $tipoExpedienteRequest, TipoExpediente $tipoExpediente)
    {
        $tipoExpediente->fill($tipoExpedienteRequest->all())->update();
        Session::flash('message-success', 'Tipo de Expediente actualizado satisfactoriamente.');
        return redirect()->route('tipoexpediente.index');
    }

    public function eliminated()
    {
        $tiposExpedientesEliminados = TipoExpediente::onlyTrashed()->get();
        return view('tiposexpedientes.eliminated', ['tiposExpedientes' => $tiposExpedientesEliminados, 'action' => 'restore']);
    }

    public function restore($id)
    {
        $tipoExpediente = TipoExpediente::withTrashed()->where('slug', '=', $id)->first();
        $tipoExpediente->restore();
        Session::flash('message-success', 'Tipo de Expediente restaurado satisfactoriamente.');
        return redirect()->route('tipoexpediente.index');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoExpediente $tipoExpediente)
    {
        $tipoExpediente->delete();
        Session::flash('message-danger', 'Tipo de Expediente eliminado satisfactoriamente.');
        return redirect()->route('tipoexpediente.index');
    }
}
