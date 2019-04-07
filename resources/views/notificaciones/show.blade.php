@extends('adminlte::layouts.app')

@section('htmlheader_title')
   Notificación
@endsection


@section('main-content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Visualizando Notificación
                  <p class="pull-right">
                    <a class="btn btn-sm btn-primary" href="{{ URL::previous() }}">Volver</a>
                  </p>
                </div>


                  <div class="panel-body">
                        <p><strong>Título: </strong>     {{ $notificacion->nombre }}</p>
                        <p><strong>Fecha Creación: </strong>     {{ $notificacion->created_at->format('d-m-Y') }}</p>
                        @if ($notificacion->fecha_vto)
                              <p><strong>Fecha Vencimiento: </strong>     {{ $notificacion->fecha_vto->format('d-m-Y') }}</p>
                        @else
                              <p><strong>Fecha Vencimiento: </strong>  </p>
                        @endif


                        <p><strong>Creada por: </strong>       {{ $notificacion->user_generate->username }}</p>
                        <p><strong>Creada para: </strong>  {{ $notificacion->user->username }}</p>
                        <p><strong>Descripción: </strong>   {{ $notificacion->descripcion }} </p>
                  </div>
            </div>
        </div>
    </div>
</div>
@endsection
