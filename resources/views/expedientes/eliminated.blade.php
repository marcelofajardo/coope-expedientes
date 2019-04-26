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
                        <div class="col-md-5 pull-left"><h4>Expedientes Archivados</h4></div>
                        <div class="pull-right">
                           <a class="btn btn-sm btn-primary" href="{{ URL::previous() }}">Volver</a>
                           <br/>
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
<script src="{{ asset('public/js/admin.js') }}"></script>

<script>
    $('#table').DataTable({
        "sDom": '<"top"l>rt<"bottom"ip><"clear">',
        processing: true,
        language: {
            "url": '{{ asset('js/Spanish.json') }}'
        },
        initComplete: function () {
            this.api().columns().every(function () {
                var column = this;
                var input = document.createElement("input");
                input.setAttribute("class", "col-md-12");
                $(input).appendTo($(column.footer()).empty())
                        .on('change', function () {
                            column.search($(this).val(), false, false, true).draw();
                        });
            })
        }
    });
</script>

@endpush
