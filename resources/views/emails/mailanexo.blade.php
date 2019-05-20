<!DOCTYPE html>
<html>
<head>
    <title>Sistema de Expedientes - Notificacion</title>
</head>

<body>
<h2>Sistema de Expedientes - Notificación de Anexo / Providencia</h2>
<br/>
El presente email se ha generado debido a que se ha agregado un anexo a un determinado Expediente:<br />
<br>
<br>
<strong>
<p>Número del Expediente: <a href="{{ route('expediente.show', $anexo->expediente)  }}">{{ $anexo->expediente->numero }} </a></p>
<p>Expediente: {{ $anexo->expediente->caratula }} </p>
<p>Fecha del Expediente: {{ $anexo->expediente->fecha }}</p>
</strong>
<p></p>
<br>
<br>
<strong>
<p> Anexo / Providencia: {{ $anexo->anexo_providencia }}</p>
<p> Fecha: {{ $anexo->created_at->format('d-m-Y') }}</p>
<p> Usuario: {{ $anexo->user->name }}</p>
<p> Clasificación: {{ $anexo->clasificacion->nombre }}</p>
<p> Descripción: {{ $anexo->descripcion }}</p>

@if ($anexo->anexo_providencia == 'Anexo')
      <p> Archivo: <a href="{{ asset($anexo->url . '/' . $anexo->file) }}" target="_blank">{{ $anexo->file }}</a></p>
@endif
</strong>
</body>

</html>
