<?php
use App\TipoExpediente;
?>
<div class="table-responsive" style="width: 100%;">
<table class="table table-striped table-hover" id="table">
    <thead>
    <tr>
        <th>Fecha</th>
        <th>Actuación</th>
        <th>Usuario</th>
        <th>Descripcion</th>

    </tr>
    </thead>

    <tbody>
    @foreach($logs as $log)
        <tr>
            <td style="width: 10%">  {{ Carbon\Carbon::parse($log->created_at)->format('d-m-Y H:i') }}  </td>
            <td style="width: 10%"> {{ $log->campo }} </td>
            <td style="width: 10%"> {{ $log->username }} </td>
            <td style="width: 69%"> {{ $log->descripcion }} </td>

        </tr>
    @endforeach
    </tbody>
</table>
</div>
