<div class="row">

    <div class="form-group col-md-6 col-sm-12">
       {!! Form::label('expediente_id', 'Expediente') !!}
        {!! Form::select('expediente_id', $expedientes, null, ['placeholder'=>'Seleccione', 'class' => 'form-control',
        'id' => 'select_expediente']) !!}
   </div>

   <div class="form-group col-md-6 col-sm-12">
      {!! Form::label('clasificacion_id', 'Clasificación') !!}
       {!! Form::select('clasificacion_id', $clasificacionAnexo, null, ['placeholder'=>'Seleccione', 'class' => 'form-control',
       'id' => 'select_clasificacion_anexo']) !!}
  </div>
  <div class="form-group col-md-6 col-sm-12">
      {!! Form::label('descripcion', 'Descripcion') !!}
      {!! Form::textarea('descripcion', null, ['class' => 'form-control', 'required']) !!}
  </div>

  <div class="form-group col-md-6 col-sm-12">
      {!! Form::label('fecha_vto', 'Fecha Vencimiento') !!}
      {!! Form::text('fecha_vto', null, ['class' => 'form-control fecha']) !!}
  </div>

  <div class="form-group col-sm-6">
    {!! Form::label('anexo_providencia', 'Anexo / Providencia') !!}
    {!! Form::select('anexo_providencia', [''=>'Seleccione', 'Anexo'=>'Anexo', 'Providencia'=>'Providencia'], null, ['class' => 'form-control', 'id' => 'select_tiene_anexo_providencia', 'data-live-search' => 'true', 'data-max-options' => '1', 'required']  )  !!}
  </div>


  <div class="form-group col-md-4 col-sm-12">
      <hr />
      <input type="file" class="form-control" name="files[]" multiple />
      <hr />
  </div>
</div>
<div class="row">
    <div class="form-group col-md-6 col-sm-12">
        {!! Form::submit('Guardar', ['class' => 'btn btn-lg btn-success']) !!}
    </div>
</div>
