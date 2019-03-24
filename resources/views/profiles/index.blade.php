@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Perfil
@endsection
@section('main-content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Perfil
                    @can('profiles.create')
                    <a href="{{ route('profile.create') }}"
                    class="btn btn-sm btn-primary pull-right">
                        Crear
                    </a>
                    @endcan
                </div>

                <div class="panel-body">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Apellido y Nombre</th>
                                <th>Teléfono</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($profiles as $profile)
                            <tr>
                                <td>{{ $profile->user->name }}</td>
                                <td>{{ $profile->apellido }} {{ $profile->nombre }}</td>
                                <td>{{ $profile->telefono }}</td>
                                @can('profiles.show')
                                <td width="10px">
                                  <a href="{{ route('profile.show', $profile) }}"
                                  class="btn btn-sm btn-default">
                                      Ver
                                  </a>
                                </td>
                                @endcan
                                @can('profiles.edit')
                                <td width="10px">
                                    <a href="{{ route('profile.edit', $profile) }}"
                                    class="btn btn-sm btn-default">
                                        editar
                                    </a>
                                </td>
                                @endcan
                                @can('profiles.destroy')
                                <td width="10px">
                                    {!! Form::open(['route' => ['profile.delete', $profile],
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
                    {{ $profiles->render() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
