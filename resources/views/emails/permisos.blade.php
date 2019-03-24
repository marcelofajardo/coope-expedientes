<!DOCTYPE html>
<html>
<head>
    <title>Sistema de Expedientes - Notificacion</title>
</head>

<body>
<h2>Sistema de Expedientes - Notificación deAsignación de Permiso</h2>
<br/>
El presente email se ha generado debido a que se le ha asignado permiso para modificar el siguiente Expediente<br />


<p>Número: {{ $expediente->numero }} </p>
<p>Expediente: {{ $expediente->caratula }} </p>
<p>Fecha del Expediente: {{ $expediente->fecha }}</p>

<p></p>

</body>

</html>
