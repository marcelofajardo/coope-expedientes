@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Permisos
@endsection
@section('main-content')

<div class="container-fluid">

    <div class="row center" style="margin-left: auto; margin-right: auto; align: center">
        <div class="col-md-10">
            <div class="panel panel-default" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                <div class="panel-heading">
                    Permisos
                    @can('permission.create')
                    <a href="{{ route('permisos.create') }}"
                    class="btn btn-sm btn-primary pull-right">
                        Crear
                    </a>
                    @endcan
                </div>

                <div class="panel-body">
                    <table id="table-permisos" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Slug</th>
                                <th>Descripción</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permisos as $permiso)
                            <tr>
                                <td>{{ $permiso->name }}</td>
                                <td>{{ $permiso->slug }}</td>
                                <td>{{ $permiso->description }}</td>
                                @can('permisos.show')
                                <td width="10px">

                                </td>
                                @endcan
                                @can('permission.edit')
                                <td width="10px">
                                    <a href="{{ route('permisos.edit', $permiso) }}"
                                    class="btn btn-sm btn-default">
                                        editar
                                    </a>
                                </td>
                                @endcan
                                @can('permission.destroy')
                                <td width="10px">
                                    {!! Form::open(['route' => ['permisos.destroy', $permiso],
                                    'method' => 'DELETE']) !!}
                                        <button class="btn btn-sm btn-danger">
                                            Eliminar
                                        </button>
                                    {!! Form::close() !!}
                                </td>
                                @endcan
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $permisos->render() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
