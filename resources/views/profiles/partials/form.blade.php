<div class="col-md-4 text-center">

	@if($profile->avatar)
		<img src="{{ asset($profile->avatar) }}" width="100" class="img-user-edit circular" alt="Imagen de Perfil"/>
	@else
	<img src="{{ Gravatar::get($user->email) }}" class="img-circle" alt="User Image"/>
	@endif
	<hr />
      <input type="file" class="form-control" name="files[]" multiple />

  <hr />
</div>

<div class="col-md-8">

		<div class="form-group">
			{{ Form::label('apellido', 'Apellido') }}
			<div class="input-group">
			    <div class="input-group-addon">
			      <span class="glyphicon glyphicon-user"></span>
			    </div>
			    {{ Form::text('apellido', null, ['class' => 'form-control', 'id' => 'apellido']) }}
		  </div>

		</div>
		<div class="form-group">
			{{ Form::label('nombre', 'Nombre') }}
			<div class="input-group">
			    <div class="input-group-addon">
			      <span class="glyphicon glyphicon-user"></span>
			    </div>
			    {{ Form::text('nombre', null, ['class' => 'form-control', 'id' => 'nombre']) }}
		  </div>

		</div>
		<div class="form-group">
			{{ Form::label('telefono', 'Teléfono') }}
			<div class="input-group">
			    <div class="input-group-addon">
			      <span class="glyphicon glyphicon-phone-alt"></span>
			    </div>
			    {{ Form::text('telefono', null, ['class' => 'form-control', 'id'=>'telefono']) }}
		  </div>

		</div>
		<div class="form-group">
			{{ Form::submit('Guardar', ['class' => 'btn btn-sm btn-primary pull-right']) }}
		</div>
</div>
<hr>
