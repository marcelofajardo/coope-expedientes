<!DOCTYPE html>
<html>
<head>
    <title>Sistema de Expedientes - Notificacion</title>
</head>
<body>
<h2>Sistema de Expedientes - Notificación de Carga de Comentario</h2>
<br/>
El presente email se ha generado debido a que se ha cargado un comentario a un Expediente<br />
<p><strong>Comentario Ingresado:</strong> {!! $comentario['description'] !!}</p>
<p><strong>Perteneciente al Anexo:</strong> {{ $anexo->descripcion }}</p>
<p><strong>Anexo / Providencia:</strong> {{ $anexo->anexo_providencia }}</p>

<p><strong>Expediente: </strong><a href="{{ route('expediente.show', $anexo->expediente)  }}">{{ $anexo->expediente->caratula }}</a></p>
</body>
</html>
