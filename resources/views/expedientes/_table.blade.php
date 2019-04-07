<div class="table-responsive" style="width: 100%; padding-left: 15px">
<table class="table table-striped table-hover" id="table">
    <thead>
    <tr>
        <th>Fecha</th>
        <th>Nro Exp.</th>
        <th>Carátula</th>
        <th>Tipo Expediente</th>

        <th style="width: 17%">Opciones</th>
    </tr>
    </thead>

    <tbody>
    @foreach($expedientes as $ex)
      @if ($ex->archivado == 1)
        <tr class="danger">
      @else
        <tr>
      @endif

            <td> {{ $ex->fecha }} </td>
            <td> {{ $ex->numero }} </td>
            <td> {{ $ex->caratula }} </td>
            @if ($ex->tipoexpediente)
            <td> {{ $ex->tipoexpediente->nombre }} </td>
            @else
            <td></td>
            @endif
            <td>

                @if($action == 'index')
                        @if ($ex->archivado == 1)
                              <a href="{{ route('expediente.show', $ex) }}" class="btn btn-primary btn-xs pull-rigth">Ver</a>
                              <a href="{{ route('expediente.delete', $ex)}}" class="btn btn-danger btn-xs pull-rigth" onclick="return confirm('Está seguro que desea Activar este ítem?')" class="btn btn-danger">Activar</a>
                        @else
                              <a href="{{ route('expediente.show', $ex) }}" class="btn btn-primary btn-xs pull-rigth">Ver</a>
                              <a href="{{ route('expediente.edit', $ex) }}" class="btn btn-primary btn-xs pull-rigth">Editar</a>
                              <a href="{{ route('expediente.agregarAnexo', $ex) }}" class="btn btn-primary btn-xs pull-rigth">Agregar</a>
                              <a href="{{ route('expediente.delete', $ex)}}" class="btn btn-danger btn-xs pull-rigth" onclick="return confirm('Está seguro que desea Archivar este ítem?')" class="btn btn-danger">Archivar</a>
                        @endif
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>
