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

                            <a href="{{ route('expediente.create') }}" class="btn btn-sm btn-primary pull-right">
                            Nuevo
                            </a>

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
