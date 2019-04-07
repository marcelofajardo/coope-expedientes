<div class="table-responsive" style="width: 100%;">
<table class="table" id="table-anexos-expedientes">
    <thead>
    <tr>
      <th>Fecha</th>
      <th>Anexo/Providencia</th>
      <th>Archivo</th>
      <th>Descripción</th>
      <th>Usuario</th>
      <th>Tipo de Anexo</th>
      <th>Vencimiento</th>
      <th>Comentarios</th>

        <th style="width: 0%"></th>
    </tr>
    </thead>

    <tbody>
    @foreach($anexos as $anexo)

        <tr>
            <td>  {{ Carbon\Carbon::parse($anexo->created_at)->format('d-m-Y H:i') }}  </td>
            <td class="text-center"> {{ $anexo->anexo_providencia }} </td>
            @if ($anexo->anexo_providencia == 'Anexo')
                <td style="text-align: center;"> <a href="{{ asset($anexo->url . '/' . $anexo->file) }}" class="btn btn-warning btn-sm pull-rigth" target="_blank"><i class="fa fa-eye" title="Ver Anexo"></i></a> </td>
            @else
                <td></td>
            @endif

            <td> {{ $anexo->descripcion }} </td>
            <td> {{ $anexo->username }} </td>
            <td> {{ $anexo->clasificacion }} </td>
            @if ($anexo->fecha_vto)
              <td>  {{ Carbon\Carbon::parse($anexo->fecha_vto)->format('d-m-Y') }}  </td>
            @else
              <td></td>
            @endif
            <td class="text-center"> <a href="{{ route('anexo.show1', $anexo->id) }}" class="btn btn-warning btn-sm btn-xs"><i class="fa fa-comment-o fa-lg" title="Comentarios"></i>{{ $anexo->cant_comentarios}}</a></td>


            {{--
            <a href="{{ route('anexo.deleteAjax', $anexo->id) }}" class="btn btn-danger btn-xs pull-rigth" onclick="return confirm('Está seguro que desea eliminar este ítem?')"
class="btn btn-danger">Eliminar</a>
--}}
          </td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>
