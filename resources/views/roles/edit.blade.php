@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Notificaciones
@endsection

@section('main-content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                      Roles

                      <p class="pull-right">
                       <a href="{{ route('roles.index') }}" class="btn btn-sm btn-primary pull-right">
                         Volver
                       </a>
                     </p>
                </div>

                <div class="panel-body">
                    {!! Form::model($role, ['route' => ['roles.update', $role->id],
                    'method' => 'PUT']) !!}

                        @include('roles.partials.form')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
