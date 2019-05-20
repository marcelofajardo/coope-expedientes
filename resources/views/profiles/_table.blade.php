<div class="table-responsive" style="width: 100%;">
<table class="table table-striped table-hover" id="table">
    <thead>
    <tr>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Teléfono</th>
        <th style="width: 17%">Opciones</th>
    </tr>
    </thead>

    <tbody>
    @foreach($profiles as $te)
        <tr>
            <td> {{ $te->nombre }} </td>
            <td> {{ $te->apellido }} </td>
            <td> {{ $te->telefono }} </td>
            <td>
                @if($action == 'index')
                      @can('profile.edit')
                           <a href="{{ route('profile.edit', $te) }}" class="btn btn-warning btn-xs">Editar</a>
                     @endcan
                     @can('profile.delete')
                          <a href="{{ route('profile.delete', $te)}}" class="btn btn-danger btn-xs pull-rigth" onclick="return confirm('Está seguro que desea eliminar este ítem?')"
                    @endcan
    class="btn btn-danger">Eliminar</a>

                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>
