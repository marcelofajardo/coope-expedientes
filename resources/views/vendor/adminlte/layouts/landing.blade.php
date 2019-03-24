<!DOCTYPE html>
<!--
Landing page based on Pratt: http://blacktie.co/demo/pratt/
-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistema de Expedientes">
    <meta name="author" content="Desarrollos Tello">

    <meta property="og:title" content="Sistema de Expedientes" />
    <meta property="og:type" content="website" />
    <meta property="og:description" content="Sistema de Expedientes" />
    <meta property="og:url" content="http://expedientes.desarrollostello.com/" />

    <meta property="og:sitename" content="Sistema de Expedientes" />
    <meta property="og:url" content="http://expedientes.desarrollostello.com" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@acachawiki" />
    <meta name="twitter:creator" content="@acacha1" />

    <title>Sistema de Expedientes</title>

    <!-- Custom styles for this template -->
    <link href="{{ asset('/css/all-landing.css') }}" rel="stylesheet">

    <link href='https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>

</head>

<body data-spy="scroll" data-target="#navigation" data-offset="50">

<div id="app" v-cloak>
    <!-- Fixed navbar -->
    <div id="navigation" class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><b>Expediente Electrónico</b></a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">

                </ul>
                <ul class="nav navbar-nav navbar-right">
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Ingresar</a></li>

                    @else
                        <li><a href="/home">{{ Auth::user()->name }}</a></li>
                    @endif
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>


    <section id="home" name="home" style="padding-bottom: 10%">
        <div id="headerwrap1" style="padding-top: 10%">
            <div class="container">
                <div class="row centered">
                    <div class="col-lg-12">
                          <div class="col-md-12 text-center">
                                <h1>Módulo de Gestión de Información</h1>
                                <h1>y Expediente Electrónico</h1>
                          </div>
                </div>
            </div> <!--/ .container -->
        </div><!--/ #headerwrap -->
    </section>


    <footer>
        <div id="c">
            <div class="container">
                <p>
                    <strong>Copyright &copy; 2019 <a href="https://www.desarrollostello.com" target="_blank">Desarrollos Tello</a>.</strong>
                    <br/>
                    Todos los Derechos Reservados.
                </p>

            </div>
        </div>
    </footer>

</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="{{ url (mix('/js/app-landing.js')) }}"></script>

</body>
</html>
