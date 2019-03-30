<div class="table-responsive" style="width: 100%;">
<table class="table table-striped table-hover" id="table-anexos-expedientes">
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
            <td> {{ $anexo->anexo_providencia }} </td>
            @if ($anexo->anexo_providencia == 'Anexo')
                <td> <a href="{{ asset($anexo->url . '/' . $anexo->file) }}" class="btn btn-primary btn-xs pull-rigth" target="_blank">VER</a> </td>
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
            <td> <a href="{{ asset('anexo.show1', $anexo->id) }}" class="btn btn-primary btn-xs pull-rigth">{{ $anexo->cant_comentarios}}</a> </td>


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
