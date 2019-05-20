<div class="table-responsive" style="width: 100%; padding: 10px 15px">
<table class="table table-striped table-hover" id="table">
    <thead>
    <tr>
        <th style="width: 15%; text-align:center;">Fecha</th>
        <th style="width: 15%; text-align:center;">Anexo/Providencia</th>
        <th style="width: 25%; text-align:center;">Archivo</th>
        <th style="width: 10%; text-align:center;">Usuario</th>
        <th style="width: 15%; text-align:center;">Tipo de Anexo</th>
        <th style="width: 10%;  text-align:center;">Opciones</th>
    </tr>
    </thead>

      <tbody>
            @foreach($anexos as $anexo)
                  <tr>
                        <th style="width: 15%; text-align:center; font-weight: 600"> <a title="Visualizar Anexo" href="{{ route('anexo.show', $anexo) }}">{{ $anexo->created_at->format('d-m-Y') }} </a></td>
                        <th style="width: 15%; text-align:center;"> {{ $anexo->anexo_providencia }} </td>
                        <th style="width: 25%; text-align:center;"> <a href="{{ asset($anexo->url . '/' . $anexo->file) }}" title="Ver Anexo" target="_blank">{{ $anexo->file }}</a></td>

                        <th style="width: 10%; text-align:center;"> {{ $anexo->username }} </td>
                        @if ($anexo->clasificacion)
                              <th style="width: 15%; text-align:center;"> {{ $anexo->clasificacion->nombre }} </td>
                        @else
                              <th style="width: 15%; text-align:center;"> </td>
                        @endif

                        <th style="width: 10%;  text-align:center;">
                        @if($action == 'index')
                              @can('anexo.delete')
                                    <a href="{{ route('anexo.delete', $anexo)}}" class="btn btn-danger btn-xs pull-rigth" onclick="return confirm('Está seguro que desea eliminar este ítem?')" class="btn btn-danger">Eliminar</a>
                              @endcan
                        @else
                              @can('anexo.restore')
                                    <a href="{{ route('anexo.restore', $anexo) }}" class="btn btn-danger btn-xs">Restaurar</a>
                              @endcan
                        @endif
                  </td>
            </tr>
      @endforeach
      </tbody>
</table>
</div>
