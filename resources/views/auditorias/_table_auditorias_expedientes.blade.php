<?php
use App\TipoExpediente;
?>
<div class="table-responsive" style="width: 100%;">
<table class="table table-striped table-hover" id="table">
    <thead>
    <tr>
        <th style="width: 15%; text-align: center">Fecha</th>
        <th style="width: 15%; text-align: center">Usuario</th>
        <th style="width: 20%">Acción</th>
        <th style="width: 50%">Descripcion</th>

    </tr>
    </thead>

    <tbody>
    @foreach($logs as $log)
        <tr>
            <td style="width: 15%; text-align: center">  {{ Carbon\Carbon::parse($log->created_at)->format('d-m-Y H:i') }}  </td>
            <td style="width: 15%; text-align: center"> {{ $log->username }} </td>
            <td style="width: 20%"> {{ $log->accion }} </td>
            <td style="width: 50%"> {{ $log->descripcion }} </td>

        </tr>
    @endforeach
    </tbody>
</table>
</div>
