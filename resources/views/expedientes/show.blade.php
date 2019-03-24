@extends('adminlte::layouts.app')

@section('htmlheader_title')
   Notificación
@endsection


@section('main-content')
<div class="container">
      <div class="row">
            <div class="page-title">
                  <div class="title_left">
                        <h3>Visualización de Expedientes
                        </h3>
                        <br/>
                  </div>
                  <div class="pull-right">
                        <a href="{{ route('expediente.index') }}" class="btn btn-default"> Volver</a>
                        <br/>
                  </div>
            </div>

            <div class="clearfix"></div>
            <div class="divider"></div>



            <div class="panel panel-success col-sm-12">
                  <div class="panel-heading">
                        <h3 class="panel-title  text-center">Carátula: <strong>{{ $expediente->caratula }}</strong></h3>
                  </div>
                  <div class="panel-body">
                        <div class="row">
                              <div class="col-md-6">
                                   <h4 class="">Tipo de Expediente: <strong>{{ $expediente->tipoExpediente->nombre }}</strong></h4>
                                   <h4 class="">Usuario: <strong>{{ $expediente->username }}</strong></h4>
                              </div>
                              <div class="col-md-6">
                                    <h4 class="">Nro Expediente: <strong>{{ $expediente->numero }}</strong></h4>
                                    <h4 class="">Fecha: <strong>{{ $expediente->fecha->format('d-m-Y') }}</strong></h4>
                              </div>
                        </div>
                        <hr />
                        <div id="tabs">
                              <ul>
                                    <li><a href="#tabs-1">Actuaciones</a></li>
                                    <li><a href="#tabs-2">Anexos</a></li>
                              </ul>
                              <div id="tabs-1">
                                    @if($logs)
                                          @include('logs._table_logs_expedientes')
                                    @endif
                              </div>
                              <div id="tabs-2">
                                    @if($anexos)
                                          @include('anexos._table_expedientes')
                                    @endif
                              </div>
                        </div>
                  </div>
            </div>
      </div>
</div>
@endsection
