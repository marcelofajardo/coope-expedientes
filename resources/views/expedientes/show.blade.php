@extends('adminlte::layouts.app')

@section('htmlheader_title')
   Notificación
@endsection


@section('main-content')
<div class="container-fluid" style="width: 95%; padding: 0px;">
      <div class="row">
            <div class="page-title">
                  <div class="title_left">
                        <h3>Visualización de Expedientes
                        </h3>
                        <br/>
                  </div>
                  <div class="pull-right">
                        <a style="padding-left: 10px; padding-right: 10px; margin-bottom: 15px; color: #ffffff" class="btn btn-default btn-primary" href="{{ URL::previous() }}">Volver</a>
                        <br/>
                  </div>
            </div>

            <div class="clearfix"></div>
            <div class="divider"></div>



            <div class="panel panel-success col-12" style="padding-left: 0px; padding-right: 0px; padding-top: 0px; padding-bottom: 0px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                  <div class="panel-heading" style="padding-top: 20px; padding-bottom: 20px">
                        <h2 style="font-size: 22px;" class="panel-title text-center">Carátula: <strong>{{ $expediente->caratula }}</strong></h2>
                  </div>
                  <div class="panel-body">
                        <div class="row">
                              <div class="col-md-6">
                                   <h4 class="">Tipo de Expediente: <strong>{{ $expediente->tipoExpediente->nombre }}</strong></h4>
                                   <h4 class="">Usuario: <strong>{{ $expediente->user->nombre }}</strong></h4>
                              </div>
                              <div class="col-md-6">
                                    <h4 class="">Nro Expediente: <strong>{{ $expediente->numero }}</strong></h4>
                                    <h4 class="">Fecha: <strong>{{ $expediente->fecha }}</strong></h4>
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
                                          @include('auditorias._table_auditorias_expedientes')
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
