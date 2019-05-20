<div class="table-responsive" style="width: 100%; padding-left: 15px; margin-bottom: 15px;">
<table class="table table-striped table-hover" id="table">
    <thead>
    <tr>
        <th>Nombre</th>
        <th style="width: 20%">Opciones</th>
    </tr>
    </thead>

    <tbody>
    @foreach($clasificacionAnexos as $ca)
        <tr>
            <td style="padding-left: 25px; font-weight: 600"> {{ $ca->nombre }} </td>

            <th style="width: 20%">
                @if($action == 'index')
                      @can('clasificacion.edit')
                           <a href="{{ route('clasificacion.edit', $ca) }}" class="btn btn-primary btn-sm">Editar</a>
                     @endcan
                     @can('clasificacion.destroy')
                          <a href="{{ route('clasificacion.destroy', $ca)}}" class="btn btn-danger btn-sm pull-rigth" onclick="return confirm('Está seguro que desea borrar este ítem?')"
                    @endcan
    class="btn btn-danger">Eliminar</a>
                @else
                      @can('clasificacion.restore')
                           <a href="{{ route('clasificacion.restore', $ca) }}" class="btn btn-primary btn-sm">Restaurar</a>
                     @endcan
                     @can('clasificacion.delete')
                    <a href="{{ route('clasificacion.delete', $ca) }}" class="btn btn-danger btn-sm"  onclick="return confirm('Está seguro que desea Borrar definitivamente este ítem?')">Borrado Definitivo</a>
                        @endcan
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
