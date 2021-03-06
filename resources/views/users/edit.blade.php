@extends('adminlte::layouts.app')
@section('htmlheader_title')
    Usuarios
@endsection

@section('main-content')
<div class="container">
    <div class="row">
        <div class="col-xs-11 col-sm-11 col-md-10 col-lg-10">
            <div class="panel panel-default">
                <div class="panel-heading">Editando Usuario
                  <p class="pull-right">
                    <a class="btn btn-sm btn-primary" href="{{ URL::previous() }}">Volver</a>
                  </p>
                </div>

                <div class="panel-body">
                      {!! Form::model($user, ['route' => ['users.update', $user->id],'method' => 'PUT']) !!}
                        @include('users.partials.form')
                  {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
