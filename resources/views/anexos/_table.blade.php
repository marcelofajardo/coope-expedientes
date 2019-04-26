<div class="table-responsive" style="width: 100%; padding: 10px 15px">
<table class="table table-striped table-hover" id="table">
    <thead>
    <tr>
        <th>Fecha</th>
        <th>Anexo/Providencia</th>
        <th>Archivo</th>
        <th>Descripción</th>
        <th>Usuario</th>
        <th>Tipo de Anexo</th>

        <th style="width: 17%">Opciones</th>
    </tr>
    </thead>

    <tbody>
    @foreach($anexos as $anexo)
        <tr>
            <td> {{ $anexo->created_at->format('d-m-Y') }} </td>
            <td> {{ $anexo->anexo_providencia }} </td>
            <td> <a href="{{ asset($anexo->url . '/' . $anexo->file) }}" target="_blank">{{ $anexo->file }}</a></td>
            <td> {{ substr($anexo->descripcion, 0, 85) }} </td>
            <td> {{ $anexo->username }} </td>
            @if ($anexo->clasificacion)
              <td> {{ $anexo->clasificacion->nombre }} </td>
            @else
              <td> </td>
            @endif

            <td>
                @if($action == 'index')
                    <a href="{{ route('anexo.show', $anexo) }}" class="btn btn-primary btn-xs pull-rigth">Visualizar</a>

                    <a href="{{ route('anexo.delete', $anexo)}}" class="btn btn-danger btn-xs pull-rigth" onclick="return confirm('Está seguro que desea eliminar este ítem?')"
    class="btn btn-danger">Eliminar</a>
                @else
                    <a href="{{ route('anexo.restore', $anexo) }}" class="btn btn-danger btn-xs">Restaurar</a>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>
