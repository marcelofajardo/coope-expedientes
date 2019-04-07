@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Roles
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
                <div class="panel-heading">
                      Roles
                      <p class="pull-right">
                       <a class="btn btn-sm btn-primary" href="{{ URL::previous() }}">Volver</a>
                     </p>

                </div>

                <div class="panel-body">
                    {{ Form::open(['route' => 'roles.store']) }}

                        @include('roles.partials.form')

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
