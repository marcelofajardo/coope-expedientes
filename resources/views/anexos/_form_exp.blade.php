<div class="row">
  <div class="form-group col-md-6 col-sm-12">
    {!! Form::label('anexo_providencia', 'Anexo / Providencia') !!}
    {!! Form::select('anexo_providencia', [''=>'Seleccione', 'Anexo'=>'Anexo', 'Providencia'=>'Providencia'], null, ['class' => 'form-control', 'id' => 'select_tiene_anexo_providencia', 'data-live-search' => 'true', 'data-max-options' => '1', 'required']  )  !!}
  </div>

  <div class="form-group col-md-6 col-sm-12">
      {!! Form::label('expediente_id', 'Expediente') !!}
      {!! Form::hidden('expediente_id', $expediente->id, ['class' => 'form-control', 'readonly']) !!}
      {!! Form::text('ex', $expediente->caratula, ['class' => 'form-control', 'readonly']) !!}

  </div>
</div>
<div class="row">
      <div class="form-group col-md-6 col-sm-12">
            {!! Form::label('clasificacion_id', 'Clasificación') !!}
            {!! Form::select('clasificacion_id', $clasificacionAnexo, null, ['placeholder'=>'Seleccione', 'class' => 'form-control', 'id' => 'select_clasificacion_anexo']) !!}
      </div>
      <div class="form-group col-md-6 col-sm-12">
            {!! Form::label('fecha_vto', 'Fecha Vencimiento') !!}
            {!! Form::text('fecha_vto', null, ['class' => 'form-control fecha']) !!}
      </div>

</div>
<div class="row">
      <div class="form-group col-md-12 col-sm-12">
          {!! Form::label('descripcion', 'Descripcion') !!}
          {!! Form::textarea('descripcion', null, ['class' => 'form-control', 'required']) !!}
      </div>
</div>

<div class="row">
      <div class="form-group col-md-4 col-sm-12">
            <hr />
            <input type="file" class="form-control" name="files[]" multiple />
            <hr />
      </div>
</div>
<div class="row">
      <div class="form-group col-md-6 col-sm-12">
            {!! Form::submit('Enviar', ['class' => 'btn btn-success']) !!}
      </div>
</div>
