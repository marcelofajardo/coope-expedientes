<div class="row">
      <div class="form-group col-md-2 col-sm-12">
          {!! Form::label('fecha', 'Fecha') !!}
          {!! Form::text('fecha', null, ['class' => 'form-control fecha', 'required']) !!}
      </div>
    <div class="form-group col-md-4 col-sm-12">
       {!! Form::label('nombre', 'Nombre del Expediente') !!}
        {!! Form::text('nombre', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group col-md-4 col-sm-12">
      {!! Form::label('numero', 'Número') !!}
       {!! Form::text('numero', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="row">

    <div class="form-group col-md-6 col-sm-12">
      {!! Form::label('caratula', 'Caratula') !!}
      {!! Form::text('caratula', null, ['class' => 'form-control', 'required']) !!}
    </div>

    <div class="form-group col-md-4 col-sm-12">
     {!! Form::label('tipo_expediente_id', 'Tipo de Expediente') !!}
      {!! Form::select('tipo_expediente_id', $tipoExpedientes, null, ['placeholder'=>'Seleccione', 'class' => 'form-control',
      'id' => 'select_tipo_expediente', 'required']) !!}
    </div>
</div>
    <!--
<div class="form-group col-md-6 col-sm-12">
<hr />
      <input type="file" class="form-control" name="files[]" multiple />
<hr />

  </div>
-->

<div class="row">
    <hr />
    <div class="form-group col-md-6 col-sm-12">
        {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
    </div>
</div>

<!--
<div id="tabs">
    <ul>
      <li><a href="#tabs-1">Listado de Logs</a></li>
      <li><a href="#tabs-2">Anexos</a></li>
    </ul>
    <div id="tabs-1">
      @if($logs)
        @include('logs._table_logs_expedientes')
      @endif
    </div>
    <div id="tabs-2">
      @if($anexos)
        @include('anexos._table_expedientes')
      @endif
    </div>
</div>
-->
<hr />
<h3>Lista de Usuarios que tendrán Permiso de editar el Expediente</h3>
<em>de este listado se excluyen los usuarios Administradores que siempre tendrán acceso</em>

<div class="form-group" style="margin-top: 15px;">
	<ul class="list-unstyled">

		@foreach($habilitados as $usuario)
	    <li>
	        <label>
	        {{ Form::checkbox('usuarios[]', $usuario->id, 1) }}
	        {{ $usuario->usuario }}
	        <em>({{ $usuario->email }})</em>
	        </label>
	    </li>
	    @endforeach
    </ul>
    <ul class="list-unstyled">
		@foreach($no_habilitados as $usuario)
	    <li>
	        <label>
	        {{ Form::checkbox('usuarios[]', $usuario->id, null) }}
	        {{ $usuario->usuario }}
	        <em>({{ $usuario->email }})</em>
	        </label>
	    </li>
	    @endforeach
    </ul>
</div>
