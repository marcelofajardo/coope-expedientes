<?php
use App\TipoExpediente;
?>
<div class="table-responsive" style="width: 100%;">
<table class="table table-striped table-hover" id="table">
    <thead>
    <tr>
        <th>Fecha</th>
        <th>Actuación</th>
        <th>Clasificación</th>
        <th>Usuario</th>
        <th style="width: 10%"></th>
    </tr>
    </thead>

    <tbody>
    @foreach($logs as $log)
        <tr>
            <td style="width: 15%">  {{ Carbon\Carbon::parse($log->created_at)->format('d-m-Y H:i') }}  </td>
            <td style="width: 20%"> {{ $log->anexo_providencia }} </td>
            <td style="width: 20%"> {{ $log->clasificacion }} </td>
            <td style="width: 15%"> {{ $log->username }} </td>
            <td style="width: 10%">
            @if ($log->anexo_providencia == 'Anexo')
              <a href="{{ asset($log->url . '/' . $log->archivo) }}" class="btn btn-warning btn-sm pull-rigth" target="_blank"><i class="fa fa-eye" title="Ver Anexo"></i></a> </td>
            @endif
          </td>

        </tr>
    @endforeach
    </tbody>
</table>
</div>
