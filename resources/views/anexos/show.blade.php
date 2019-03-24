@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Permisos
@endsection


@section('main-content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                      <h3 class="panel-title  text-center">Expediente: <strong>{{ $anexo->expediente->caratula }}</strong></h3>

                </div>

                  <div class="panel-body">
                        <p class="pull-right">
                              <a href="{{ route('anexo.index') }}" class="btn btn-sm btn-primary pull-right">
                                    Volver
                              </a>
                        </p>
                        <h4 class="">Fecha: <strong>{{ $anexo->created_at->format('d-m-Y') }}</strong></h4>
                        <h4 class="">Anexo/Providencia: <strong>{{ $anexo->anexo_providencia }}</strong></h4>
                        @if ($anexo->anexo_providencia == 'Anexo')
                              <h4 class="">Clasificación: <strong>{{ $anexo->clasificacion->nombre }}</strong></h4>
                        @endif
                        <h4 class="">Username: <strong>{{ $anexo->username }}</strong></h4>
                        <h4 class="">Descripción: <strong>{{ $anexo->descripcion }}</strong></h4>
                        @if ($anexo->fecha_vto)
                              <h4 class="">Fecha: <strong>{{ $anexo->fecha_vto->format('d-m-Y') }}</strong></h4>
                        @else
                              <h4 class="">Fecha: <strong></strong></h4>
                        @endif
                        @if ($anexo->anexo_providencia == 'Anexo')
                              <h4 class="">Archivo: <a href="{{ asset($anexo->url . '/' . $anexo->file) }}" target="_blank"><strong>{{ $anexo->file }}</strong></a></h4>
                              <hr />
                              <p class="text-center"></p>
                        @endif

                        <h3>Comments</h3>

                            @include ('comments.index', ['collection' => $comments['root']])

                            @if (Auth::check())
                                <h3>Leave a Reply</h3>

                                @include ('comments.form')
                            @endif
                  </div>

    </div>
@endsection
