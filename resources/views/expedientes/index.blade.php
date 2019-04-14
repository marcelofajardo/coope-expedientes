@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Expedientes
@endsection
@section('main-content')
@if(Session::has('flash_message'))
    {{Session::get('flash_message')}}
@endif

<div class="container-fluid">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default" style="padding-bottom: 10px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">

                <div class="panel-heading" style="padding-bottom: 20px;">
                    <div class="row">
                        <div class="col-md-5 pull-left"><h4>Expedientes a la fecha</h4></div>
                        <div class="col-md-5 pull-right">

                              @if($action == 'index')
                                    <a href="{{ route('expediente.eliminated')}}" class="btn btn-warning btn-md pull-rigth">Ver Archivados</a>
                                    <a href="{{ route('expediente.create') }}"    class="btn btn-md btn-primary pull-right">Nuevo</a>
                              @else
                                    <a href="{{ route('expediente.index')}}" class="btn btn-warning btn-md pull-rigth">Ver Activos</a>
                              @endif
                        </div>
                    </div>
                </div>
                @include('expedientes._table')
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/admin.js') }}"></script>
@endpush
