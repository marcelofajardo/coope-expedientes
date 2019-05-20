@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Anexos
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
<div class="container-fluid">
      <div class="row">
            <div class="col-md-12">
                  <div class="panel panel-default">
                        <div class="panel-heading" style="font-size: 16px; font-weight: 600 ">Nuevo Anexo
                              <p class="pull-right">
                                    <a class="btn btn-sm btn-primary" href="{{ URL::previous() }}">Volver</a>
                              </p>
                              <div class="row">
                                    <div class="form-group col-md-11 col-sm-11">
                                          <p style="font-weight: 400">Al ser cargado, enviará un mail a los Administradores del Sistema, y a todos los
                                                USUARIOS que estén habilitados para editar el Expediente al cual va el Anexo</p>
                                    </div>
                              </div>
                        </div>

                        <div class="panel-body" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                              {{ Form::open(['route' => ['anexo.store'], 'enctype' => 'multipart/form-data']) }}
                                    @include('anexos._form')
                              {{ Form::close() }}
                        </div>

                  </div>
            </div>
      </div>
</div>
@endsection

@push('scripts')
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
