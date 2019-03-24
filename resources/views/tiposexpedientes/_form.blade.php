<div class="row">
    <div class="form-group col-md-6 col-sm-12">
        {!! Form::label('nombre', 'Nombre') !!}
        {!! Form::text('nombre', null, ['class' => 'form-control', 'required', 'minlength' =>'4', 'maxlength' =>'100']) !!}
    </div>
    <div class="form-group col-md-2 col-sm-12">
        {!! Form::label('letra', 'Letra') !!}
        {!! Form::text('letra', null, ['class' => 'form-control', 'required', 'minlength' =>'1', 'maxlength' =>'10']) !!}
    </div>

</div>
<div class="row">
    <div class="form-group col-md-6 col-sm-12">
        {!! Form::submit('Enviar', ['class' => 'btn btn-success']) !!}
    </div>
</div>
