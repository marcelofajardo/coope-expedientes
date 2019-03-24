@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Permisos
@endsection


@section('main-content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Editando Permiso
                  <p class="pull-right">
                    <a href="{{ route('permisos.index') }}" class="btn btn-sm btn-primary pull-right">
                      Volver
                    </a>
                  </p>
                </div>

                <div class="panel-body">
                    {!! Form::model($permiso, ['route' => ['permisos.update', $permiso],
                    'method' => 'PUT']) !!}

                        @include('permisos.partials.form')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
