@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Perfil
@endsection
@section('main-content')

@if(Session::has('message'))
    {{Session::get('message')}}
@endif

<div class="container-fluid">
      <div class="row">
            <div class="col-md-12">
                  <div class="panel panel-default" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
            <div class="panel-heading">
                  Perfil
                  @can('profiles.create')
                        <a href="{{ route('profile.create') }}" class="btn btn-sm btn-primary pull-right">
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
                                    <th>E-mail</th>
                                    <th>&nbsp;</th>
                              </tr>
                        </thead>
                        <tbody>
                        @foreach($profiles as $profile)
                              <tr>
                                    <td>{{ $profile->user->name }}</td>
                                    <td>{{ $profile->apellido }} {{ $profile->nombre }}</td>
                                    <td>{{ $profile->telefono }}</td>
                                    <td>{{ $profile->user->email }}</td>
                                    <td width="10px">
                                          <a href="{{ route('profile.showAdmin', $profile) }}" class="btn btn-sm btn-default"> Ver </a>
                                    </td>

                                    @if($profile->user_id == \Auth::user()->id)
                                          <td width="10px">
                                                <a href="{{ route('profile.edit', $profile) }}" class="btn btn-sm btn-default"> editar </a>
                                          </td>
                                    @else
                                          <td></td>
                                    @endif
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
@push('scripts')
<script src="{{ asset('js/admin.js') }}"></script>
@endpush
