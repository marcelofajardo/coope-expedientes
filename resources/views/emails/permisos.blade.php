<!DOCTYPE html>
<html>
<head>
    <title>Sistema de Expedientes - Notificacion</title>
</head>

<body>
<h2>Sistema de Expedientes - Notificación de Asignación de Permiso</h2>
<br/>
El presente email se ha generado debido a que se le ha asignado permiso para modificar el siguiente Expediente.

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
