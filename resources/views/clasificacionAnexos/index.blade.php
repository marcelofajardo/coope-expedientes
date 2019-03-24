@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Clasificación de Anexos
@endsection
@section('main-content')



<div class="container-fluid">

      <div class="row" style="display: flex; flex-flow: row wrap; justify-content: center;">
          <div class="col-md-8">
            <div class="panel panel-default">

                <div class="panel-heading" style="padding-bottom: 20px;">
                    <div class="row">
                        <div class="col-md-5 pull-left"><h4>Clasificación de Anexos</h4></div>
                        <div class="col-md-5 pull-right">

                            <a href="{{ route('clasificacion.create') }}" class="btn btn-sm btn-primary pull-right">
                            Nueva Clasificación
                            </a>

                        </div>
                    </div>
                </div>
                @include('clasificacionAnexos._table')
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/admin.js') }}"></script>
@endpush
