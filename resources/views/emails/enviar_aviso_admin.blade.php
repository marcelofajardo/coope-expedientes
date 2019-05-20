<!DOCTYPE html>
<html>
<head>
    <title>Sistema de Expedientes - Notificacion</title>
</head>

<body>
<h2>Sistema de Expedientes - Notificación de Nuevo Expediente cargado</h2>
<br>
Por ser Administrador del Sistema de Expediente, se da aviso que se ha cargado un nuevo Expediente

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
