@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('backend/css/admin.css') }}"/>
@endpush

@section('content')

    <div class="page-title">
        <div class="title_left">
            <h3>Anexos<br/> <small> listado de todas los Anexos eliminados en el sistema hasta la fecha</small>
            </h3>
            <br/>
        </div>
        <div class="pull-right">
            <a class="btn btn-sm btn-primary" href="{{ URL::previous() }}">Volver</a>
            <br/>
        </div>
    </div>

    @include('anexos._table')

@endsection

@push('scripts')

@endpush
