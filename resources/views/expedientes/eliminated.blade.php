@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('backend/css/admin.css') }}"/>
@endpush

@section('content')

    <div class="page-title">
        <div class="title_left">
            <h3>Expedientes Archivados<br/>
                <small> listado de todas los Expedientes Archivados en el sistema hasta la fecha</small>
            </h3>
            <br/>
        </div>
        <div class="pull-right">
            <a class="btn btn-sm btn-primary" href="{{ URL::previous() }}">Volver</a>
            <br/>
        </div>
    </div>

    @include('expedientes._table')

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
