@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Proyectos
@endsection
@section('main-content')
@if(Session::has('message'))
    {{Session::get('message')}}
@endif

<div class="container-fluid">

    <div class="row" style="display: flex; flex-flow: row wrap; justify-content: center;">
        <div class="col-md-8">
            <div class="panel panel-default">

                <div class="panel-heading" style="padding-bottom: 20px;">
                    <div class="row">
                        <div class="col-md-5 pull-left"><h4>Tipos de Expedientes</h4></div>
                        <div class="col-md-5 pull-right">

                            <a href="{{ route('tipoexpediente.create') }}" class="btn btn-sm btn-primary pull-right">
                            Nuevo Tipo de Expediente
                            </a>

                        </div>
                    </div>
                </div>
                @include('tiposexpedientes._table')
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/admin.js') }}"></script>
@endpush
