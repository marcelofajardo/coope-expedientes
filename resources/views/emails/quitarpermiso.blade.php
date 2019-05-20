<!DOCTYPE html>
<html>
<head>
    <title>Sistema de Expedientes - Notificacion</title>
</head>
<body>
<h2>Sistema de Expedientes - Notificación</h2>
<br/>
El presente email se ha generado debido a que ya <strong>NO TIENE PERMISO</strong> para modificar el siguiente Expediente<br />
<br>
<br>
<strong>
<p>Número: <a href="{{ route('expediente.show', $expediente)  }}">{{ $expediente->numero }} </a></p>
<p>Expediente: {{ $expediente->caratula }} </p>
<p>Fecha del Expediente: {{ $expediente->fecha }}</p>
</strong>
<p></p>
</body>
</html>
