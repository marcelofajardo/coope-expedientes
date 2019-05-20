@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Tipos de Expedientes
@endsection

@section('main-content')
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">Editando Tipo de Expediente
                  <p class="pull-right">
                    <a class="btn btn-sm btn-primary" href="{{ URL::previous() }}">Volver</a>
                  </p>
                </div>

                <div class="panel-body">
                  {!! Form::model($tipoExpediente, ['method' => 'PATCH', 'route' => ['tipoexpediente.update', $tipoExpediente]]) !!}
                        @include('tiposexpedientes._form')
                  {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
