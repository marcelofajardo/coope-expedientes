@extends('adminlte::layouts.app')

@section('htmlheader_title')
   Usuarios
@endsection
@section('main-content')
      @if(Session::has('flash_message'))
          {{Session::get('flash_message')}}
      @endif

<div class="container-fluid">

    <div class="row">
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">
            <div class="panel panel-default" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                <div class="panel-heading" style="font-size: 16px; font-weight: 600;">Usuarios
                      <a href="{{ route('users.create') }}"
                     class="btn btn-sm btn-primary pull-right">
                         Nuevo Usuario
                     </a>
                </div>

                <div class="panel-body">
                        <div class="table-responsive" style="width: 100%; padding-left: 15px">
                              <table class="table table-striped table-hover" id="table">
                                    <thead>
                                        <tr>
                                            <th width="10px">ID</th>
                                            <th>Nombre</th>
                                            <th>Correo</th>
                                            <th>Rol</th>
                                            <!--<th>Activo?</th>-->
                                            <th colspan="3">&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                  @foreach($users as $user)
                                  <tr>
                                          <td>{{ $user->id }}</td>
                                          <td class="mailbox-messages mailbox-name"><a href="javascript:void(0);"  style="display:block"><i class="fa fa-user"></i>&nbsp;&nbsp;{{ $user->name }}</a></td>
                                          <td>{{ $user->email }}</td>
                                          <td>
                                                <h4>
                                                      @foreach($user->getRoles() as $roles)
                                                            <span class="label label-warning">{{  $roles  }}</span>
                                                      @endforeach
                                                </h4>
                                          </td>
                                          <!--
                                          @if ($user->estado == 'Activo')
                                                <td><h4><a href="{{ route('users.activo', $user)}}" class="btn btn-success btn-xs pull-rigth" onclick="return confirm('Está seguro que desea bloquear este usuario?')" class="btn btn-success">{{ $user->estado }}</a></h4></td>
                                          @else
                                                <td><h4><a href="{{ route('users.activo', $user)}}" class="btn btn-warning btn-xs pull-rigth" onclick="return confirm('Está seguro que desea Activar este usuario?')" class="btn btn-warning">{{ $user->estado }}</a></h4></td>
                                          @endif
                                          -->

                                      @can('users.edit')
                                      <td width="10px">
                                          <a href="{{ route('users.edit', $user->id) }}"
                                          class="btn btn-sm btn-default">
                                              editar
                                          </a>
                                      </td>
                                      @endcan
                                      @can('users.destroy')
                                      <td width="10px">
                                          {!! Form::open(['route' => ['users.destroy', $user->id],
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
                        </div>
                    {{ $users->render() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
