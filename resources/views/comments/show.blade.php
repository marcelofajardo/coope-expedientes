@extends('adminlte::layouts.app')

@section('htmlheader_title')
   Comentario
@endsection


@section('main-content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Visualizando Comentario
                  <p class="pull-right">
                    <a class="btn btn-sm btn-primary" href="{{ URL::previous() }}">Volver</a>
                  </p>
                </div>


                  <div class="panel-body">

                        <p><strong>Fecha Creación: </strong>     {{ $comment->created_at->format('d-m-Y') }}</p>
                        <p><strong>Anexo: </strong>     <a href="{{ route('anexo.show1', $comment->anexo->id) }}">{{ $comment->anexo->descripcion }}</a></p>
                        <p><strong>Creado por: </strong>  {{ $comment->user->name }}</p>
                        <p><strong>Descripción: </strong>   {{ $comment->description }} </p>
                  </div>
            </div>
        </div>
    </div>
</div>
@endsection
