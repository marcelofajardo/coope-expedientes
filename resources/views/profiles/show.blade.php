@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Perfil
@endsection


@section('main-content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Visualizando Perfil
                  <p class="pull-right">
                    <a class="btn btn-sm btn-primary" href="{{ URL::previous() }}">Volver</a>
                  </p>
                </div>


                <div class="panel-body">
                    <p><strong>Nombre</strong>     {{ Auth::user()->name }}</p>
                    <p><strong>Email</strong>     {{ Auth::user()->email}}</p>

                    <p><strong>Slug</strong>       {{ $profile->slug }}</p>
                    <p><strong>Descripción</strong>  {{ $profile->description }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
