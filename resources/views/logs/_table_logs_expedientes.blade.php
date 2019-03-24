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
            <td>  {{ Carbon\Carbon::parse($log->created_at)->format('d-m-Y H:i') }}  </td>
            <td> {{ $log->anexo_providencia }} </td>
            <td> {{ $log->clasificacion }} </td>
            <td> {{ $log->username }} </td>
            <td>
            @if ($log->anexo_providencia == 'Anexo')
              <a href="{{ asset($log->url . '/' . $log->archivo) }}" class="btn btn-primary btn-xs pull-rigth" target="_blank">ver</a> </td>
            @endif
          </td>

        </tr>
    @endforeach
    </tbody>
</table>
</div>
