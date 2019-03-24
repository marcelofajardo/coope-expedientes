@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Notificaciones
@endsection

@section('main-content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Editando Notificación
                  <p class="pull-right">
                    <a href="{{ route('notificacion.index') }}" class="btn btn-sm btn-primary pull-right">
                      Volver
                    </a>
                  </p>
                </div>

                <div class="panel-body">
                  {!! Form::model($notificacion, ['method' => 'PATCH', 'route' => ['notificacion.update', $notificacion]]) !!}
                        @include('notificaciones._form')
                  {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
