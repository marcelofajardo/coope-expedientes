<!DOCTYPE html>
<html>
<head>
    <title>Sistema de Expedientes - Notificacion</title>
</head>

<body>
<h2>Sistema de Expedientes - Notificación de Restauración de Expediente</h2>
<br/>
El presente email se ha generado debido a que se ha Restaurado un expediente que Ud tiene Permisos<br />
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
