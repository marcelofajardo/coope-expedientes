@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Expedientes
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
    <div class="page-title">
        <div class="title_left">
            <h3>Editar Expediente <small> modificar el ítem seleccionado.</small>
            </h3>
            <br/>
        </div>
        <div class="pull-right">
            <a href="{{ route('expediente.index') }}" class="btn btn-default"> Volver</a>
            <br/>
        </div>
    </div>

    <div class="clearfix"></div>
    <div class="divider"></div>
    <div>

        {!! Form::model($expediente, ['method' => 'PATCH', 'route' => ['expediente.update', $expediente]]) !!}

        @include('expedientes._form_edit')

        {!! Form::close() !!}

    </div>

@endsection
