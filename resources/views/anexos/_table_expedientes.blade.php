<div class="table-responsive" style="width: 100%;">
<table class="table" id="table-anexos-expedientes">
    <thead>
    <tr>
      <th>Fojas</th>
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
             <td>  <strong>Foja {{ $anexo->foja }}</strong>  </td>
            <td>  {{ Carbon\Carbon::parse($anexo->created_at)->format('d-m-Y H:i') }}  </td>
            <td class="text-center"> {{ $anexo->anexo_providencia }} </td>
            @if ($anexo->anexo_providencia == 'Anexo')
                <td style="text-align: center;"> <a href="{{ asset($anexo->url . $anexo->file) }}" class="btn btn-warning btn-sm pull-rigth" target="_blank"><i class="fa fa-eye" title="Ver Anexo"></i></a> </td>
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

<div class="container-fluid" style="margin-top: 100px">
        @foreach($anexos as $anexo)
            @php
                $array = explode('.', $anexo->file);
                $extension = end($array);
            @endphp


            <div class="panel panel-primary">
                  <div class="panel-heading">
                        <h3 class="panel-title"><strong>Foja {{ $anexo->foja }}</strong></h3>
                  </div>
                  <div class="panel-body">
                        @if ($extension === 'pdf')
                              <div class="embed-responsive embed-responsive-16by9">
                                    <object class="embed-responsive-item" data="{{ asset($anexo->url . $anexo->file) }}" type="application/pdf" internalinstanceid="9" title="">
                                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                                Configuración
                                          </button>
                                          <p>Su browser no soporta embeber archivos PDF. Descargue el archivo desde
                                                <a href="{{ asset($anexo->url . $anexo->file) }}"><strong>AQUI</strong></a>.</p>
                                    </object>
                              </div>
                              <!-- <embed src="{{ asset($anexo->url . $anexo->file) }}" type="application/pdf" width="99%" height="400px" />-->
                        @endif
                        @if ($extension === 'png' OR $extension === 'jpg')
                              <embed src="{{ asset($anexo->url . $anexo->file) }}" width="400px" height="400px" />
                        @endif

                  </div>
            </div>

        @endforeach
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Configurar Mozilla Firefox</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <p>Para poder embeber un PDF en Mozilla Firefox hay que seguir los siguientes pasos:<br /></p>

            <p>1) Haz clic en el botón Menú y elige Opciones.</p>
            <p>2) En el panel General, dirígete a la sección Aplicaciones.</p>
            <p>3) Busca (PDF) en la lista y haz clic en esa entrada para seleccionarla.</p>
            <p>4) Haz clic en la flecha desplegable, en la columna Acción. Si estás utilizando el visor PDF incorporado de Firefox, te aparecerá la opción Vista previa en Firefox </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
