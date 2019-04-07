<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ Gravatar::get($user->email) }}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p style="overflow: hidden;text-overflow: ellipsis;max-width: 160px;" data-toggle="tooltip" title="{{ Auth::user()->name }}">{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('adminlte_lang::message.online') }}</a>
                </div>
            </div>
        @endif

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="{{ trans('adminlte_lang::message.search') }}..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">Opciones</li>
            <!-- Optionally, you can add icons to the links -->

            <li class="treeview">
                <a href="#"><i class='fa fa-envelope'></i> <span>Bandeja de Entrada</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('expediente.misexpedientes') }}">Mis Expedientes</a></li>
                    <li><a href="{{ route('expediente.expPermisos') }}">Expedientes con Permiso</a></li>
                    <li><a href="{{ route('comment.miscomentarios') }}">Comentarios</a></li>
                    <li><a href="{{ route('notificacion.misnotificaciones') }}">Notificaciones</a></li>
                </ul>
            </li>


            <li class="active"><a href="{{ url('home') }}"><i class='fa fa-link'></i> <span>Inicio</span></a></li>
            <li><a href="{{ route('expediente.index') }}"><i class='fa fa-link'></i> <span>Expedientes</span></a></li>
            <li class="treeview">
                <a href="#"><i class='fa fa-link'></i> <span>Tablas Anexas</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('tipoexpediente.index') }}">Tipos de Expedientes</a></li>
                    <li><a href="{{ route('clasificacion.index') }}">Clasificación de Anexos</a></li>
                    <li><a href="{{ route('anexo.index') }}">Anexos</a></li>
                    <li><a href="{{ route('notificacion.index') }}">Notificaciones</a></li>
                </ul>
            </li>
            @role('admin')
            <li><a href="{{ route('users.index') }}"><i class='fa fa-link'></i> <span>Usuarios</span></a></li>
            <li><a href="{{ route('permisos.index') }}"><i class='fa fa-link'></i> <span>Permisos</span></a></li>
            <li><a href="{{ route('roles.index') }}"><i class='fa fa-link'></i> <span>Roles</span></a></li>
            <!--<li><a href="{{ route('users.create') }}"><i class='fa fa-link'></i><span>Nuevo Usuario</span></a></li>-->
            @endrole
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
