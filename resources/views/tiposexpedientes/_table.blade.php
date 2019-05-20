<div class="table-responsive" style="width: 100%;  padding-left: 15px; padding-bottom: 15px;">
<table class="table table-striped table-hover" id="table">
    <thead>
    <tr>
        <th style="width: 60%">Nombre</th>
        <th style="width: 10%; text-align: center">Letra</th>
        <th style="width: 20%; text-align: center">Opciones</th>
    </tr>
    </thead>

    <tbody>
    @foreach($tiposExpedientes as $te)
        <tr>
            <th style="width: 60%; padding-left: 25px;"> {{ $te->nombre }} </td>
            <th style="width: 10%; text-align: center"> {{ $te->letra }} </td>
            <th style="width: 20%">
                @if($action == 'index')
                      @can('tipoexpediente.edit')
                           <a href="{{ route('tipoexpediente.edit', $te) }}" class="btn btn-primary btn-sm pull-rigth">Editar</a>
                     @endcan
                     @can('tipoexpediente.delete')
                           <a href="{{ route('tipoexpediente.delete', $te)}}" class="btn btn-danger btn-sm pull-rigth" onclick="return confirm('Está seguro que desea eliminar este ítem?')"
                        @endcan
    class="btn btn-danger">Eliminar</a>
                @else
                      @can('tipoexpediente.restore')
                           <a href="{{ route('tipoexpediente.restore', $te) }}" class="btn btn-danger btn-sm pull-rigth">Restaurar</a>
                     @endcan
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>
