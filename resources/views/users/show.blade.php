@extends('adminlte::layouts.app')
@section('htmlheader_title')
   Usuario
@endsection
@section('main-content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)">
                <div class="panel-heading" style="font-size: 16px; font-weight: 600">Visualizando Usuario
                  <p class="pull-right">
                    <a class="btn btn-sm btn-primary" href="{{ URL::previous() }}">Volver</a>
                  </p>
                </div>

                        <div class="panel-body">
                              <div class="row">
                                    <div class="col-md-6" style="font-size: 16px;">
                                          <p><strong>Nombre</strong>     {{ $user->name }}</p>
                                    </div>
                                    <div class="col-md-6"  style="font-size: 16px;">
                                          <p><strong>Email</strong>      {{ $user->email }}</p>
                                    </div>
                              </div>



                        <hr>
                        <p><strong>Roles del Usuario</strong></p>
                        <ul class="list-unstyled">
                        @foreach($user->getRoles() as $roles)
                              <li>
                                   {{ $roles }}
                             </li>
                        @endforeach
                        </ul>
                  </div>
            </div>
        </div>
    </div>
</div>
@endsection
