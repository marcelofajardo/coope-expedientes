@extends('adminlte::layouts.app')
@section('htmlheader_title')
   Usuario
@endsection
@section('main-content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Visualizando Usuario
                  <p class="pull-right">
                    <a href="{{ route('users.index') }}" class="btn btn-sm btn-primary pull-right">
                      Volver
                    </a>
                  </p>
                </div>
                <div class="panel-body">
                    <p><strong>Nombre</strong>     {{ $user->name }}</p>
                    <p><strong>Email</strong>      {{ $user->email }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
