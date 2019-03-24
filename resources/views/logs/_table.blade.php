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
      <th>Fecha</th>
      <th>Expediente</th>
      <th>Actuación</th>
      <th>Usuario</th>
    </tr>
    </tfoot>
    <tbody>
    @foreach($logs as $log)
        <tr>
            <td> {{ $log->created_at->format('d-m-Y') }} </td>
            @if ($log->expediente)
            <td> {{ $log->expediente->caratula }} </td>
            @else
            <td></td>
            @endif
            <td> {{ $log->campo }} </td>
            <td> {{ $log->username }} </td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>
