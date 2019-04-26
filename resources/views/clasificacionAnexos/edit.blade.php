@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Clasificación de Anexos
@endsection

@if(Session::has('message'))
    {{Session::get('message')}}
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@section('main-content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading" style="height: 55px;">Editando Clasificación de Anexos
                  <p class="pull-right">
                    <a class="btn btn-primary" href="{{ URL::previous() }}">Volver</a>
                  </p>
                </div>

                <div class="panel-body"  style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                  {!! Form::model($clasificacionAnexo, ['method' => 'PATCH', 'route' => ['clasificacion.update', $clasificacionAnexo]]) !!}
                        @include('clasificacionAnexos._form')
                  {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
