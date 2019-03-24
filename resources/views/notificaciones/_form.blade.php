<div class="row">
      <div class="form-group col-md-4 col-sm-12">
            {!! Form::label('nombre', 'Nombre') !!}
            {!! Form::text('nombre', null, ['class' => 'form-control', 'required', 'minlength' =>'4', 'maxlength' =>'100']) !!}
      </div>

      <div class="form-group col-md-4 col-sm-12">
            {!! Form::label('user_id', 'Usuario Destino') !!}
            {!! Form::select('user_id', $usuarios, null, ['placeholder'=>'Seleccione', 'class' => 'form-control', 'id' => 'select_usuarios']) !!}
      </div>
      <div class="form-group col-md-2 col-sm-12">
            {!! Form::label('fecha_vto', 'Fecha Vto') !!}
            {!! Form::text('fecha_vto', null, ['class' => 'form-control fecha']) !!}
      </div>

</div>
<div class="row">
      <div class="form-group col-md-11 col-sm-12">
          {!! Form::label('descripcion', 'Descripción') !!}
          {!! Form::textarea('descripcion', null, ['class' => 'form-control', 'rows' => 3]) !!}
      </div>
</div>
<div class="row">
    <div class="form-group col-md-6 col-sm-12">
        {!! Form::submit('Enviar', ['class' => 'btn btn-success']) !!}
    </div>
</div>
