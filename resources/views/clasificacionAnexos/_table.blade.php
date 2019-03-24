<div class="table-responsive" style="width: 100%;">
<table class="table table-striped table-hover" id="table">
    <thead>
    <tr>
        <th>Nombre</th>

        <th style="width: 17%">Opciones</th>
    </tr>
    </thead>
    
    <tbody>
    @foreach($clasificacionAnexos as $ca)
        <tr>
            <td> {{ $ca->nombre }} </td>

            <td>
                @if($action == 'index')
                    <a href="{{ route('clasificacion.edit', $ca) }}" class="btn btn-warning btn-xs">Editar</a>
                    <a href="{{ route('clasificacion.delete', $ca)}}" class="btn btn-danger btn-xs pull-rigth" onclick="return confirm('Está seguro que desea eliminar este ítem?')"
    class="btn btn-danger">Eliminar</a>
                @else
                    <a href="{{ route('clasificacion.restore', $ca) }}" class="btn btn-danger btn-xs">Restaurar</a>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>
