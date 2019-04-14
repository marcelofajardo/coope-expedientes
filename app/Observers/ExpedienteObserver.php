<?php

namespace App\Observers;

use App\Expediente;
use App\Auditoria;
use App\Log;
use Illuminate\Support\Facades\Auth;

class ExpedienteObserver
{
    /**
     * Handle the expediente "created" event.
     *
     * @param  \App\Expediente  $expediente
     * @return void
     */
      public function created(Expediente $expediente)
      {
            $au = new Log();
            $au->user_id = Auth::user()->id;
            $au->username = Auth::user()->name;
            $au->expediente_id = $expediente->id;
            $au->campo = 'Caratulacion';
            $au->descripcion = 'Se acaba de Crear un Expediente. Carátula: ' . $expediente->caratula . ' Bajo el Número '. $expediente->numero;
            $au->save();
      }

    /**
     * Handle the expediente "updated" event.
     *
     * @param  \App\Expediente  $expediente
     * @return void
     */
      public function updated(Expediente $expediente)
      {
            if ($expediente->isDirty(['caratula', 'numero','nombre', 'fecha']))
            {
                  $au = new Log();
                  $au->user_id = Auth::user()->id;
                  $au->username = Auth::user()->name;
                  $au->expediente_id = $expediente->id;
                  $au->campo = 'Modificaciòn';
                  $au->descripcion = 'Se acaba de Modificar un Expediente. Carátula: ' . $expediente->caratula . ' Bajo el Número '. $expediente->numero;
                  $au->save();
            }
      }

    /**
     * Handle the expediente "deleted" event.
     *
     * @param  \App\Expediente  $expediente
     * @return void
     */
      public function delete(Expediente $expediente)
      {
            $au = new Log();
            $au->user_id = Auth::user()->id;
            $au->username = Auth::user()->name;
            $au->expediente_id = $expediente->id;
            $au->campo = 'Archivado';
            $au->descripcion = 'Se acaba de Archivar un Expediente. Carátula: ' . $expediente->caratula . ' Bajo el Número '. $expediente->numero;
            $au->save();
      }

    /**
     * Handle the expediente "restored" event.
     *
     * @param  \App\Expediente  $expediente
     * @return void
     */
      public function restored(Expediente $expediente)
      {
            $au = new Log();
            $au->user_id = Auth::user()->id;
            $au->username = Auth::user()->name;
            $au->expediente_id = $expediente->id;
            $au->campo = 'Activado';
            $au->descripcion = 'Se acaba de Artivar un Expediente. Carátula: ' . $expediente->caratula . ' Bajo el Número '. $expediente->numero;
            $au->save();
      }

    /**
     * Handle the expediente "force deleted" event.
     *
     * @param  \App\Expediente  $expediente
     * @return void
     */
      public function forceDeleted(Expediente $expediente)
      {
            $au = new Log();
            $au->user_id = Auth::user()->id;
            $au->username = Auth::user()->name;
            $au->expediente_id = $expediente->id;
            $au->campo = 'Borrado';
            $au->descripcion = 'Se acaba de Borrar un Expediente. Carátula: ' . $expediente->caratula . ' Bajo el Número '. $expediente->numero;
            $au->save();
      }
}
