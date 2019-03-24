@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('backend/css/admin.css') }}"/>
@endpush

@if(Session::has('flash_message'))
{{Session::get('flash_message')}}
@endif

@section('content')

    <div class="page-title">
        <div class="title_left">
            <h3>Actuaciones<small> Listado de todos las Actuaciones generadas hasta la fecha</small>
            </h3>
            <br/>
        </div>
        <div class="pull-right">
          <!--
          @if (Auth::user()->rol->nombre == 'administrador')
            <a href="{{ route('log.create') }}" class="btn btn-primary"> Nueva Actuación</a>
          @endif
        -->
          <!--  <a href="{{ route('log.eliminated') }}" class="btn btn-warning">Actuaciones Eliminadas</a>-->
            <br/>
        </div>
    </div>

    @include('logs._table')

@endsection
