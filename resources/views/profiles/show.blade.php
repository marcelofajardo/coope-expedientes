@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Perfil
@endsection


@section('main-content')
      <div class="container">
          <div class="row">
              <div class="col-md-3 col-md-3">
                  <div class="panel panel-default">
                      <div class="panel-heading center" style="text-align:center">AVATAR</div>
                      <div class="panel-body" style="text-align: center;">
                        @if (Auth::user()->profile)
                              @if (Auth::user()->profile->avatar)
                                    <img src="{{ asset(Auth::user()->profile->avatar)  }}" style="height:150px;width:150px;;border-radius:75px; border: 5px solid #cccccc" class="img-circle" alt="Avatar del Usuario" />
                              @else
                                    <img src="{{ asset('img/profile/avatar.png') }}" style="height:150px;width:150px;;border-radius:75px; border: 5px solid #cccccc" class="img-circle" alt="Avatar del Usuario" />
                              @endif
                        @else
                              <img src="{{ asset('img/profile/avatar.png') }}" style="height:150px;width:150px;;border-radius:75px; border: 5px solid #cccccc" class="img-circle" alt="Avatar del Usuario" />
                        @endif


                      </div>
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="panel panel-default">

                      <div class="panel-heading" style="text-align:center">
                           <a href="{{ route('profile.changepassword') }}" class="btn btn-sm btn-primary pull-left">
                             Cambiar Contraseña
                           </a>
                           @if (Auth::user()->profile)
                                 <a style="margin-left: 15px;" href="{{ route('profile.edit', Auth::user()->profile) }}" class="pull-left btn btn-warning btn-sm">Editar Perfil</a>
                           @endif
                           DATOS DEL PERFIL
                           <a href="{{ route('profile.index') }}" class="btn btn-sm btn-primary pull-right">
                             Volver
                           </a>
                      </div>


                      <div class="panel-body">
                              @if (Auth::user()->profile)
                                    @if (Auth::user()->profile->apellido)
                                          <p><strong>Apellido:</strong>  {{ Auth::user()->profile->apellido }}</p>
                                    @else
                                          <p><strong>Apellido:</strong>  </p>
                                    @endif
                                    @if (Auth::user()->profile->nombre)
                                          <p><strong>Nombre:</strong>  {{ Auth::user()->profile->nombre }}</p>
                                    @else
                                          <p><strong>Nombre:</strong>  </p>
                                    @endif
                                    @if (Auth::user()->name)
                                          <p><strong>Usuario:</strong>       {{ Auth::user()->name }}</p>
                                    @else
                                          <p><strong>Usuario:</strong>  </p>
                                    @endif
                                    <p><strong>Email</strong>        {{ Auth::user()->email}}</p>
                                    @if (Auth::user()->profile->telefono)
                                          <p><strong>Teléfono: </strong>         {{ Auth::user()->profile->telefono }}</p>
                                    @else
                                          <p><strong>Teléfono:</strong>  </p>
                                    @endif
                              @else
                                    <p><strong>Apellido:</strong>  </p>
                                    <p><strong>Nombre:</strong>  </p>
                                    <p><strong>Usuario:</strong>  {{ Auth::user()->name }} </p>
                                    <p><strong>Teléfono:</strong>  </p>

                              @endif
                      </div>
                  </div>
              </div>

          </div>
      </div>
@endsection
