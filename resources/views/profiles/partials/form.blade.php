<div class="col-md-4 text-center">

	@if ($profile)
		@if ($profile->avatar)
			<img src="{{ asset($profile->avatar)  }}" style="height:150px;width:150px;border-radius:75px; border: 5px solid #cccccc" class="nuevaImagen img-circle" alt="User Image" />
		@else
			<img src="{{ asset('img/profile/avatar.png') }}" style="height:150px;width:150px;border-radius:75px; border: 5px solid #cccccc" class="nuevaImagen img-circle" alt="User Image" />
		@endif
	@else
	     <img src="{{ asset('img/profile/avatar.png') }}" style="height:150px;width:150px;border-radius:75px; border: 5px solid #cccccc" class="nuevaImagen img-circle" alt="User Image" />
	@endif
	<hr />
      <input type="file" class="form-control" name="files[]" id="avatar" multiple/>

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
			    <input type="hidden" id="user_id" name="user_id" value={{ $profile->user_id }}  />
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
			{{ Form::label('email', 'E-mail') }}
			<div class="input-group">
			    <div class="input-group-addon">
			      <span class="glyphicon glyphicon-envelope"></span>
			    </div>
			    {{ Form::text('email', $profile->user->email, ['class' => 'form-control', 'id'=>'email']) }}
		  </div>
		</div>

		<div class="form-group">
			{{ Form::submit('Guardar', ['class' => 'btn btn-sm btn-primary pull-right']) }}
		</div>
</div>
<hr>
