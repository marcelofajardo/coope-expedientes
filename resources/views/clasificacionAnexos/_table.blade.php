<div class="table-responsive" style="width: 100%; padding-left: 15px; margin-bottom: 15px;">
<table class="table table-striped table-hover" id="table">
    <thead>
    <tr>
        <th>Nombre</th>
        <th style="width: 30%">Opciones</th>
    </tr>
    </thead>

    <tbody>
    @foreach($clasificacionAnexos as $ca)
        <tr>
            <td> {{ $ca->nombre }} </td>

            <td>
                @if($action == 'index')
                    <a href="{{ route('clasificacion.edit', $ca) }}" class="btn btn-primary btn-sm">Editar</a>
                    <a href="{{ route('clasificacion.destroy', $ca)}}" class="btn btn-danger btn-sm pull-rigth" onclick="return confirm('Está seguro que desea borrar este ítem?')"
    class="btn btn-danger">Eliminar</a>
                @else
                    <a href="{{ route('clasificacion.restore', $ca) }}" class="btn btn-primary btn-sm">Restaurar</a>
                    <a href="{{ route('clasificacion.delete', $ca) }}" class="btn btn-danger btn-sm"  onclick="return confirm('Está seguro que desea Borrar definitivamente este ítem?')">Borrado Definitivo</a>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<!--
¿Qué pasa si quiero borrar algo de forma permanente?
Para eso tenemos forceDelete
User::find(1)->forceDelete();
-->
</div>
