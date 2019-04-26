@extends('adminlte::layouts.app')

@section('htmlheader_title')
	Sistema de Expedientes
@endsection


@section('main-content')
	<div class="container-fluid spark-screen">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">

				<!-- Default box -->
				<div class="box" style="background: none; border: none;">
					<!--
					<div class="box-header">
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
								<i class="fa fa-minus"></i></button>
							<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
								<i class="fa fa-times"></i></button>
						</div>
					</div>
				-->
					<div class="box-body">
						<div class="col-md-12 text-center">
	                                    <img class="img-responsive center-block" src="{{ asset('img/logo_cem.png')  }}" />
	                              </div>
						<div class="col-md-12 text-center" style="margin-top: 30px">
			                        <h1 style="color: #ffffff; font-weight: 600; text-shadow: 2px 2px 4px #000000;">Módulo de Gestión de Información</h1>
			                        <h1 style="color: #ffffff; font-weight: 600;  text-shadow: 2px 2px 4px #000000;">y Expediente Electrónico</h1>
			                  </div>
						<div class="col-md-12 text-center" style="margin-top: 30px">
			                       <a style="margin-right: 20px;" href="{{ route('expediente.create') }}" class="btn btn-primary btn-lg">Nuevo Expediente</a>
						     <a href="{{ route('expediente.misexpedientes') }}" class="btn btn-primary btn-lg">Mis Expedientes</a>
			                  </div>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->

			</div>
		</div>
	</div>
@endsection
