@extends('adminlte::layouts.app')
@section('htmlheader_title')
    Usuarios
@endsection

@section('main-content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Editando Usuario
                  <p class="pull-right">
                    <a href="{{ route('users.index') }}" class="btn btn-sm btn-primary pull-right">
                      Volver
                    </a>
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
