<!DOCTYPE html>
<html>
<head>
    <title>Sistema de Expedientes - Notificacion</title>
</head>

<body>
<h2>Sistema de Expedientes - Notificación de Asignación de Permiso</h2>
<br/>
El presente email se ha generado debido a que se le ha asignado permiso a un Usuario <br />
para modificar el siguiente Expediente
<br>
<br>

<strong>
<p>Datos del Usuario</p>
<p>Nombre del Usuario: {{ $usuario->name }}</p>
<p>E-mail: {{ $usuario->email }} </p>

<p></p>
<p></p>
<p>Datos del Expediente</p>
<p>Número: <a href="{{ route('expediente.show', $expediente)  }}">{{ $expediente->numero }} </a></p>
<p>Expediente: {{ $expediente->caratula }} </p>
<p>Fecha del Expediente: {{ $expediente->fecha }}</p>
</strong>
<p></p>

</body>

</html>
