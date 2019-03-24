@extends('adminlte::layouts.app')
@section('htmlheader_title')
    Tareas
@endsection

@section('main-content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading" style="padding-bottom: 20px;">
                    <div class="row">
                        <div class="col-md-5 pull-left"><h4>Tarea</h4></div>
                        <div class="col-md-5 pull-right">

                            <a href="{{ route('task.index') }}" class="btn btn-sm btn-primary pull-right">
                            Volver
                            </a>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                  <div class="row">
                        <div class="form-group col-sm-12">
                              <div class="panel panel-success col-sm-6 col-sm-offset-3">
                                  <div class="panel-heading">
                                      @if ($task->user->username)
                                      <h3 class="panel-title text-center"><strong>Usuario: {{ $task->user->username }}</strong></h3>
                                      @endif
                                      <h3 class="panel-title text-center"> <strong>Fecha: {{ $task->created_at->format('d-m-Y') }}</strong></h3>
                                  </div>
                                  <div class="panel-body">
                                      <h4 class="text-left"><strong>Nombre: </strong>{{ $task->nombre }}</h4>
                                      <h4 class="text-left"><strong>Descripción:</strong> {{ $task->descripcion }}</h4>
                                      <br />
                                      <br />

                                  </div>
                              </div>


                        </div>
                  </div>
                        <br /><br />
                </div><!-- panel-body-->

            </div>
        </div>
    </div>
</div>

@endsection
