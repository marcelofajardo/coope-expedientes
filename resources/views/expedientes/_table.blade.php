<div class="table-responsive" style="width: 100%; padding-left: 15px">
<table class="table table-responsive mdl-data-table" id="table">
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
            <td> <a style="font-weight: 600;" href="{{ route('expediente.show', $ex) }}">{{ $ex->caratula }}</a> </td>
            @if ($ex->tipoexpediente)
            <td> {{ $ex->tipoexpediente->nombre }} </td>
            @else
            <td></td>
            @endif
            <td>

                  @if($action == 'index')
                        @can('expediente.edit')
                              <a href="{{ route('expediente.edit', $ex) }}" class="btn btn-primary btn-xs pull-rigth">Editar</a>
                        @endcan
                        <a href="{{ route('expediente.agregarAnexo', $ex) }}" class="btn btn-primary btn-xs pull-rigth">Agregar</a>
                        @can('expediente.delete')
                              <a href="{{ route('expediente.delete', $ex)}}" class="btn btn-danger btn-xs pull-rigth" onclick="return confirm('Está seguro que desea Archivar este Expediente?')" class="btn btn-danger">Archivar</a>
                        @endcan
                  @else
                        @can('expediente.restore')
                              <a href="{{ route('expediente.restore', $ex->id)}}" class="btn btn-danger btn-xs pull-rigth" class="btn btn-danger">Activar</a>
                        @endcan
                  @endif
            </td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
     <td></td>
     <td></td>
     <td></td>
     <td></td>

    </tfoot>
</table>
</div>
