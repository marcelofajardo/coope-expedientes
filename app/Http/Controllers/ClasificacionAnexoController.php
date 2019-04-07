<?php

namespace App\Http\Controllers;

use App\ClasificacionAnexo;
use App\Http\Requests\TipoExpedienteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ClasificacionAnexoController extends Controller
{

      public function index()
      {
            $clasificacionAnexos = ClasificacionAnexo::all();
            return view('clasificacionAnexos.index', ['clasificacionAnexos' => $clasificacionAnexos, 'action'=>'index']);
      }

      public function create()
      {
            return view('clasificacionAnexos.create');
      }

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


      public function show(ClasificacionAnexo $clasificacionAnexo)
      {
            return view('clasificacionAnexos.show', compact('clasificacionAnexo'));
      }


      public function edit(ClasificacionAnexo $clasificacionAnexo)
      {
            return view('clasificacionAnexos.edit', ['clasificacionAnexo' => $clasificacionAnexo]);
      }

      public function update(Request $request, ClasificacionAnexo $clasificacionAnexo)
      {
            if($clasificacionAnexo->fill($request->all())->update())
            {
                  return redirect()->route('clasificacion.index')->with('success','Clasificación Actualizada satisfactoriamente.');
            }else{
                  return redirect()->route('clasificacion.index')->with('error','Ocurrió un error al intentar actualizar la Clasificación');
            }
      }

      /* Esta acción lo borra pero en realidad como declaramos que trabaje con soft-delete
      en realidad lo que hace le pone fecha de deleted_at - tengo que asegurarme de que exista esa columna */
      public function destroy(ClasificacionAnexo $clasificacionAnexo)
      {
            if($clasificacionAnexo->delete())
            {
                 return redirect()->route('clasificacion.index')->with('success','Clasificación borrada satisfactoriamente.');
           }else{
                 return redirect()->route('clasificacion.index')->with('error','Ocurrió un error al intentar borrar el Registro');
           }
      }

      public function delete(ClasificacionAnexo $clasificacionAnexo)
      {
            if($clasificacionAnexo->forceDelete())
           {
                 return redirect()->route('clasificacion.index')->with('success','Clasificación borrada satisfactoriamente.');
           }else{
                 return redirect()->route('clasificacion.index')->with('error','Ocurrió un error al intentar borrar el Registro');
           }
      }

      /* Esto sirve para ver los que están eliminados.. se pueden restaurar.. tengo que ver el tema de permisos */
      public function eliminated()
      {
            $clasificacionAnexosEliminados = ClasificacionAnexo::onlyTrashed()->get();
            return view('clasificacionanexos.eliminated', ['clasificacionAnexos' => $clasificacionAnexosEliminados, 'action' => 'restore']);
      }

      public function restore($slug)
      {
          $clasificacionAnexo = ClasificacionAnexo::withTrashed()->where('slug', '=', $id)->first();
          if($clasificacionAnexo->restore())
          {
                return redirect()->route('clasificacion.index')->with('success','Clasificación Restaurada satisfactoriamente.');
          }else{
                return redirect()->route('clasificacion.index')->with('error','Ocurrió un error al intentar restaurar la Clasifiación.');
          }
      }
}
