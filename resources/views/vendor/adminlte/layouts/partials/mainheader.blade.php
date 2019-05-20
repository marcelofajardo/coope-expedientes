<!-- Main Header -->
<header class="main-header">
    <!-- Logo -->
    <a href="{{ url('/home') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>Exp</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Expedientes</b></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">{{ trans('adminlte_lang::message.togglenav') }}</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                <!-- Notifications Menu -->

                <!-- Tasks Menu -->

                @if (Auth::guest())

                    <li><a href="{{ url('/login') }}">{{ trans('adminlte_lang::message.login') }}</a></li>
                @else
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu" id="user_menu" style="max-width: 280px;white-space: nowrap;">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="max-width: 280px;white-space: nowrap;overflow: hidden;overflow-text: ellipsis">
                            <!-- The user image in the navbar-->
                              @if (Auth::user()->profile)
                                    @if (Auth::user()->profile->avatar)
                                          <img src="{{ asset(Auth::user()->profile->avatar)  }}" style="height:30px;width:30px;border-radius:10px; border: 1px solid #cccccc"  class="img-circle" alt="User Image" />
                                    @else
                                          <img src="{{ asset('img/profile/avatar.png')  }}" style="height:30px;width:30px;border-radius:20px; border: 1px solid #cccccc" class="img-circle" alt="User Image" />
                                    @endif
                              @else
                                 <img src="{{ asset('img/profile/avatar.png')  }}" style="height:30px;width:30px;border-radius:20px; border: 1px solid #cccccc" class="img-circle" alt="User Image" />
                              @endif
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs" data-toggle="tooltip" title="{{ Auth::user()->name }}">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                    @if (Auth::user()->profile)
                                          @if (Auth::user()->profile->avatar)
                                                <img src="{{ asset(Auth::user()->profile->avatar)  }}" class="img-circle" alt="User Image" />
                                          @else
                                                <img src="{{ asset('img/profile/avatar.png')  }}" class="img-circle" alt="User Image" />
                                          @endif
                                    @else
                                          <img src="{{ asset('img/profile/avatar.png')  }}" class="img-circle" alt="User Image" />
                                    @endif
                                <p>
                                      <span data-toggle="tooltip" title="{{ Auth::user()->name }}">{{ Auth::user()->name }}</span><br>
                                     <span>{{ Auth::user()->email }}</span>
                                     <small>{{ Auth::user()->last_login_at }}</small>
                                    <!-- <small> Nov. 2012</small> -->
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <!--
                            <li class="user-body">
                                <div class="col-xs-4 text-center">
                                    <a href="#">{{ trans('adminlte_lang::message.followers') }}</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">{{ trans('adminlte_lang::message.sales') }}</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">{{ trans('adminlte_lang::message.friends') }}</a>
                                </div>
                            </li>
                      -->
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{ route('profile.show', Auth::user()->profile->id ) }}" class="btn btn-default btn-flat">Perfil</a>
                                    <a href="{{ route('profile.changepassword') }}" class="btn btn-default btn-flat">Cambiar Clave</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ url('/logout') }}" class="btn btn-default btn-flat" id="logout"
                                       onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        {{ trans('adminlte_lang::message.signout') }}
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                        <input type="submit" value="logout" style="display: none;">
                                    </form>

                                </div>
                            </li>
                        </ul>
                    </li>
                @endif

                <!-- Control Sidebar Toggle Button -->
                <!--
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li>-->
            </ul>
        </div>
    </nav>
</header>
