@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Permisos
@endsection


@section('main-content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Visualizando Permiso
                  <p class="pull-right">
                    <a href="{{ route('permisos.index') }}" class="btn btn-sm btn-primary pull-right">
                      Volver
                    </a>
                  </p>
                </div>

                <div class="panel-body">

                    <p><strong>Nombre</strong>     {{ $permiso->name }}</p>
                    <p><strong>Slug</strong>       {{ $permiso->slug }}</p>
                    <p><strong>Descripción</strong>  {{ $permiso->description }}</p>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection
