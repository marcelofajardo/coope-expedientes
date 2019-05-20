<div class="table-responsive" style="width: 100%;">
<table class="table table-striped table-hover" id="table">
    <thead>
    <tr>
        <th style="width: 15%">Fecha</th>
        <th style="width: 15%">Acción</th>
        <th style="width: 15%">Modelo</th>
        <th style="width: 15%">Usuario</th>
        <th style="width: 15%">Componente</th>

    </tr>
    </thead>
    <tfoot>
    <tr>
      <th style="width: 15%">Fecha</th>
      <th style="width: 15%">Acción</th>
      <th style="width: 15%">Modelo</th>
      <th style="width: 15%">Usuario</th>

    </tr>
    </tfoot>
    <tbody>
            @foreach($auditorias as $auditoria)
                  <tr>
                        <td style="width: 15%; text-align:center">  {{ Carbon\Carbon::parse($auditoria->created_at)->format('d-m-Y H:i') }}  </td>
                        <td style="width: 15%; text-align:center"> {{ $auditoria->accion }} </td>
                        <td style="width: 15%; text-align:center"> {{ $auditoria->modelo }} </td>
                        <td style="width: 15%; text-align:center"> {{ $auditoria->user->name }} </td>
                        <td style="width: 15%; text-align:center"> {{ $auditoria->componente_id }} </td>
                  </tr>
            @endforeach
    </tbody>
</table>
</div>
