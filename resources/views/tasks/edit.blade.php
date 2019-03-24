@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Tareas
@endsection

@section('main-content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Editando Tarea
                  <p class="pull-right">
                    <a href="{{ route('task.index') }}" class="btn btn-sm btn-primary pull-right">
                      Volver
                    </a>
                  </p>
                </div>

                <div class="panel-body">
                  {!! Form::model($task, ['method' => 'PATCH', 'route' => ['task.update', $task]]) !!}
                        @include('tasks._form_edit')
                  {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
