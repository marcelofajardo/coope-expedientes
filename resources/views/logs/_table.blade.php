<div class="table-responsive" style="width: 100%;">
<table class="table table-striped table-hover" id="table">
    <thead>
    <tr>
        <th>Fecha</th>
        <th>Expediente</th>
        <th>Actuación</th>
        <th>Usuario</th>

    </tr>
    </thead>
    <tfoot>
    <tr>
      <th style="width: 15%">Fecha</th>
      <th style="width: 40%">Expediente</th>
      <th style="width: 15%">Actuación</th>
      <th style="width: 15%">Usuario</th>
      
    </tr>
    </tfoot>
    <tbody>
            @foreach($logs as $log)
                  <tr>
                        <td style="width: 15%">  {{ Carbon\Carbon::parse($log->created_at)->format('d-m-Y H:i') }}  </td>
                        @if ($log->expediente)
                              <td style="width: 40%"> {{ $log->expediente->caratula }} </td>
                        @else
                              <td></td>
                        @endif
                        <td style="width: 15%"> {{ $log->campo }} </td>
                        <td style="width: 15%"> {{ $log->username }} </td>
                  </tr>
            @endforeach
    </tbody>
</table>
</div>
