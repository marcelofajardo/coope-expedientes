@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Clasificación de Anexos
@endsection

@section('main-content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Editando Clasificación de Anexos
                  <p class="pull-right">
                    <a href="{{ route('tipoexpediente.index') }}" class="btn btn-sm btn-primary pull-right">
                      Volver
                    </a>
                  </p>
                </div>

                <div class="panel-body">
                  {!! Form::model($clasificacionAnexo, ['method' => 'PATCH', 'route' => ['clasificacion.update', $clasificacionAnexo]]) !!}
                        @include('clasificacionAnexos._form')
                  {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
