<?php

namespace App\Http\Controllers;

use App\ClasificacionAnexo;
use App\Http\Requests\TipoExpedienteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ClasificacionAnexoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clasificacionAnexos = ClasificacionAnexo::all();

        return view('clasificacionAnexos.index', ['clasificacionAnexos' => $clasificacionAnexos, 'action'=>'index']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clasificacionAnexos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
      public function store(Request $request)
      {
            $data = $request->all();
            $creada = ClasificacionAnexo::create($data);
            if ($creada)
            {
                  return redirect()->route('clasificacion.index')->with('success','Clasificación Creada satisfactoriamente.');
            }else{
                  return redirect()->route('clasificacion.index')->with('error','Ocurrió un error al intentar crear la Clasificación');
            }
      }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ClasificacionAnexo $clasificacionAnexo)
    {
        return view('clasificacionAnexos.show', compact('clasificacionAnexo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ClasificacionAnexo $clasificacionAnexo)
    {
        return view('clasificacionAnexos.edit', ['clasificacionAnexo' => $clasificacionAnexo]);
      //  return view('roles.edit', compact('rol'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
      public function update(Request $request, ClasificacionAnexo $clasificacionAnexo)
      {
            if($clasificacionAnexo->fill($request->all())->update())
            {
                  return redirect()->route('clasificacion.index')->with('success','Clasificación Actualizada satisfactoriamente.');
            }else{
                  return redirect()->route('clasificacion.index')->with('error','Ocurrió un error al intentar actualizar la Clasificación');
            }
      }

    public function eliminated()
    {
        $clasificacionAnexosEliminados = ClasificacionAnexo::onlyTrashed()->get();
        return view('clasificacionanexos.eliminated', ['clasificacionAnexos' => $clasificacionAnexosEliminados, 'action' => 'restore']);
    }

    public function restore($id)
    {
        $clasificacionAnexo = ClasificacionAnexo::withTrashed()->where('slug', '=', $id)->first();
        $clasificacionAnexo->restore();
        return redirect()->route('clasificacion.index')->with('success','Clasificación Restaurada satisfactoriamente.');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClasificacionAnexo $clasificacionAnexo)
    {
        if($clasificacionAnexo->delete())
        {
            return redirect()->route('clasificacion.index')->with('success','Clasificación borrada satisfactoriamente.');
      }else{
            return redirect()->route('clasificacion.index')->with('error','Ocurrió un error al intentar borrar el Registro');
      }

    }
}
