<div class="row">
    <div class="form-group col-md-2 col-sm-12">
        {!! Form::label('fecha', 'Fecha') !!}
        {!! Form::text('fecha', null, ['class' => 'form-control fechas', 'required']) !!}
    </div>
    <div class="form-group col-md-8 col-sm-12">
       {!! Form::label('nombre', 'Nombre del Expediente') !!}
        {!! Form::text('nombre', null, ['class' => 'form-control', 'required']) !!}
   </div>
   <!--
   <div class="form-group col-md-4 col-sm-12">
      {!! Form::label('numero', 'Número') !!}
       {!! Form::text('numero', null, ['class' => 'form-control']) !!}
  </div>
-->

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
<!--
  <div class="form-group col-md-6 col-sm-12">
<hr />
      <input type="file" class="form-control" name="files[]" multiple />
<hr />
  </div>
-->
</div>
<hr />
<h3>Lista de Usuarios que tendrán Permiso de editar el Expediente</h3>
<div class="form-group">
	<ul class="list-unstyled">
		@foreach($usuarios as $usuario)
	    <li>
	        <label>
	        {{ Form::checkbox('usuarios[]', $usuario->id, null) }}
	        {{ $usuario->name }}
	        <em>({{ $usuario->email }})</em>
	        </label>
	    </li>
	    @endforeach
    </ul>
</div>

<div class="row">
  <hr />
    <div class="form-group col-md-6 col-sm-12">
        {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
    </div>
</div>
