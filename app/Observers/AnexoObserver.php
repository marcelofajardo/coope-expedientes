<?php

namespace App\Observers;

use App\Anexo;
use App\Expediente;
use App\Auditoria;
use App\Log;
use Illuminate\Support\Facades\Auth;

class AnexoObserver
{
    /**
     * Handle the anexo "created" event.
     *
     * @param  \App\Anexo  $anexo
     * @return void
     */
      public function created(Anexo $anexo)
      {

            $au = new Auditoria();
            $au->user_id = Auth::user()->id;
            $au->username = Auth::user()->name;
            $au->componente_id = $anexo->id;
            $au->modelo = 'anexo';
            $au->accion = 'Nuevo Anexo';
            $au->descripcion = 'Se acaba de CREAR un Anexo al Expediente:  ' . $anexo->expediente->numero  . ' | Fecha: ' . $anexo->created_at->format('d-m-Y') . ' | Descripción del Anexo: ' . $anexo->descripcion;
            $au->save();
      }

    /**
     * Handle the anexo "updated" event.
     *
     * @param  \App\Anexo  $anexo
     * @return void
     */
      public function updated(Anexo $anexo)
      {
            $au = new Auditoria();
            $au->user_id = Auth::user()->id;
            $au->username = Auth::user()->name;
            $au->componente_id = $anexo->id;
            $au->modelo = 'anexo';
            $au->accion = 'Actualizaciòn Anexo';
            $au->descripcion = 'Se acaba de ACTUALIZAR un Anexo al Expediente ' . $anexo->expediente->numero . ' | Fecha: ' . $anexo->created_at->format('d-m-Y') . ' | Descripción del Anexo: '. $anexo->descripcion;
            $au->save();
      }

    /**
     * Handle the anexo "deleted" event.
     *
     * @param  \App\Anexo  $anexo
     * @return void
     */
      public function deleted(Anexo $anexo)
      {
            $au = new Auditoria();
            $au->user_id = Auth::user()->id;
            $au->username = Auth::user()->name;
            $au->componente_id = $anexo->id;
            $au->modelo = 'anexo';
            $au->accion = 'Borrar Anexo';
            $au->descripcion = 'Se acaba de BORRAR un Anexo del Expediente ' . $anexo->expediente->numero . ' | Fecha: ' . $anexo->created_at->format('d-m-Y') . ' | Descripción del Anexo: '. $anexo->descripcion;
            $au->save();
      }

    /**
     * Handle the anexo "restored" event.
     *
     * @param  \App\Anexo  $anexo
     * @return void
     */
      public function restored(Anexo $anexo)
      {
            $au = new Auditoria();
            $au->user_id = Auth::user()->id;
            $au->username = Auth::user()->name;
            $au->componente_id = $anexo->id;
            $au->modelo = 'anexo';
            $au->accion = 'Restaurar Anexo';
            $au->descripcion = 'Se acaba de RESTAURAR un Anexo del Expediente ' . $anexo->expediente->numero . ' | Fecha: ' . $anexo->created_at->format('d-m-Y') . ' | Descripción del Anexo: '. $anexo->descripcion;
            $au->save();
      }

    /**
     * Handle the anexo "force deleted" event.
     *
     * @param  \App\Anexo  $anexo
     * @return void
     */
      public function forceDeleted(Anexo $anexo)
      {
            $au = new Auditoria();
            $au->user_id = Auth::user()->id;
            $au->username = Auth::user()->name;
            $au->componente_id = $anexo->id;
            $au->modelo = 'anexo';
            $au->accion = 'Borrado Definitivo de Anexo';
            $au->descripcion = 'Se acaba de Borrar Definitivamente un Anexo del Expediente ' . $anexo->expediente->numero;
            $au->save();
      }
}
