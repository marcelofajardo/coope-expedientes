@extends('adminlte::layouts.app')

@section('htmlheader_title')
   Roles
@endsection


@section('main-content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                      Rol
                      <p class="pull-right">
                       <a class="btn btn-sm btn-primary" href="{{ URL::previous() }}">Volver</a>
                     </p>
                </div>

                <div class="panel-body">
                    <p><strong>Nombre</strong>     {{ $role->name }}</p>
                    <p><strong>Slug</strong>       {{ $role->slug }}</p>
                    <p><strong>Descripción</strong>  {{ $role->description }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
