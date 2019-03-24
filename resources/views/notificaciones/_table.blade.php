<div class="table-responsive" style="width: 100%;">
<table class="table table-striped table-hover" id="table">
    <thead>
    <tr>
        <th>Nombre</th>
        <th>Usuario Origen</th>
        <th>Usuario Destino</th>
        <th>Fecha</th>
        <th>Fecha Vto</th>
        <th>Leida</th>

        <th style="width: 17%">Opciones</th>
    </tr>
    </thead>

    <tbody>
    @foreach($notificaciones as $notificacion)
        <tr>
            <td> {{ $notificacion->nombre }} </td>
            <td> {{ $notificacion->user_generate->username}} </td>
            <td> {{ $notificacion->user->username}} </td>
            <td> {{ $notificacion->created_at->format('d-m-Y') }} </td>
            @if($notificacion->fecha_vto)
                  <td> {{ $notificacion->fecha_vto->format('d-m-Y') }} </td>
            @else
                  <td> </td>
            @endif
            <td> {{ $notificacion->leida }} </td>

            <td>
                @if($action == 'index')
                  @if ($notificacion->leida == 'NO')
                    <a href="{{ route('notificacion.edit', $notificacion) }}" class="btn btn-info btn-xs pull-rigth">Leida</a>
                  @else
                    <a href="{{ route('notificacion.edit', $notificacion) }}" class="btn btn-info btn-xs pull-rigth">No Leida</a>
                  @endif

                    <a href="{{ route('notificacion.show', $notificacion) }}" class="btn btn-primary btn-xs pull-rigth">Visualizar</a>

                    <a href="{{ route('notificacion.delete', $notificacion)}}" class="btn btn-danger btn-xs pull-rigth" onclick="return confirm('Está seguro que desea eliminar este ítem?')"
    class="btn btn-danger">Eliminar</a>
                @endif

            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>
