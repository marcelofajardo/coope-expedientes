@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Anexos
@endsection

@section('main-content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Editando Anexos
                  <p class="pull-right">
                    <a class="btn btn-sm btn-primary" href="{{ URL::previous() }}">Volver</a>
                  </p>
                </div>

                <div class="panel-body">
                  {!! Form::model($anexo, ['method' => 'PATCH', 'route' => ['anexo.update', $anexo]]) !!}
                        @include('anexos._form')
                  {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
