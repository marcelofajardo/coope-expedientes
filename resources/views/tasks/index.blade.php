@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Tareas
@endsection
@section('main-content')
@if(Session::has('message'))
    {{Session::get('message')}}
@endif

<div class="container-fluid">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">

                <div class="panel-heading" style="padding-bottom: 20px;">
                    <div class="row">
                        <div class="col-md-5 pull-left"><h4>Tareas</h4></div>
                        <div class="col-md-5 pull-right">

                            <a href="{{ route('task.create') }}" class="btn btn-sm btn-primary pull-right">
                            Nueva Tarea
                            </a>

                        </div>
                    </div>
                </div>
                @include('tasks._table')
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/admin.js') }}"></script>
@endpush
