@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Anexos
@endsection


@section('main-content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="rounded panel panel-default" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                <div class="panel-heading">
                      <h3 class="panel-title text-center" style="padding: 20px 0; font-size: 20px">Expediente: <strong>{{ $anexo->expediente->caratula }}</strong></h3>

                </div>

                  <div class="panel-body" style="padding: 15px 30px;">
                        <p class="pull-right">
                              <a class="btn btn-sm btn-primary" href="{{ URL::previous() }}">Volver</a>
                        </p>
                        <h4 style="padding-bottom: 10px" class="">Fecha: <strong>{{ $anexo->created_at->format('d-m-Y') }}</strong></h4>
                        <h4 style="padding-bottom: 10px" class="">Anexo/Providencia: <strong>{{ $anexo->anexo_providencia }}</strong></h4>
                        @if ($anexo->anexo_providencia == 'Anexo')
                              <h4 style="padding-bottom: 10px" class="">Clasificación: <strong>{{ $anexo->clasificacion->nombre }}</strong></h4>
                        @endif
                        <h4 style="padding-bottom: 10px" class="">Username: <strong>{{ $anexo->username }}</strong></h4>
                        @if ($anexo->fecha_vto)
                              <h4 style="padding-bottom: 10px" class="">Fecha Vto: <strong>{{ $anexo->fecha_vto }}</strong></h4>
                        @else
                              <h4 style="padding-bottom: 10px" class="">Fecha Vto: <strong></strong></h4>
                        @endif
                        @if ($anexo->anexo_providencia == 'Anexo')
                              <h4  style="padding-bottom: 10px" class="">Archivo: <a href="{{ asset($anexo->url . '/' . $anexo->file) }}" target="_blank"><strong>{{ $anexo->file }}</strong></a></h4>
                              <hr />
                              <p class="text-center"></p>
                        @endif

                        <h4 style="padding-bottom: 10px" class="">Descripción: <br><p style="margin-top: 10px; line-height: 1.6em; font-weight: 600">{{ $anexo->descripcion }}</p></h4>

                        <div class="row">
                              <div class="col-xs-12">
                                    <div id="app">
                                          <comment anexo="{{ $anexo->id }}"></comment>
                                    </div>
                              </div>
                        </div>

                  </div>

    </div>
@endsection
