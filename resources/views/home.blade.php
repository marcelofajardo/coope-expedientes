@extends('layouts.app')

@section('content')
<div class="container">
      <div class="row justify-content-center">
            <div class="col-md-8">
                  <div class="card">
                        <div class="card-header">Bienvenidos</div>

                        <div class="card-body">
                              @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                          {{ session('status') }}
                                    </div>
                              @endif
                              <div class="col-md-12 text-center">
                                    <img class="img-responsive" href="" />
                              </div>
                              <div class="col-md-12 text-center">
                                    <h1>Módulo de Gestión de Información</h1>
                                    <h1>y Expediente Electrónico</h1>
                              </div>
                        </div>
                  </div>
            </div>
      </div>
</div>
@endsection
