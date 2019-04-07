@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Perfil
@endsection


@section('main-content')
<div class="container">
    <div class="row">
        <div class="col-md-9 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Nuevo Perfil
                  <p class="pull-right">
                    <a class="btn btn-sm btn-primary" href="{{ URL::previous() }}">Volver</a>
                  </p>
                </div>

                <div class="panel-body">
                    {!! Form::open(['route' => ['profile.store'], 'enctype' => 'multipart/form-data']) !!}

                        @include('profiles.partials.form')

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
