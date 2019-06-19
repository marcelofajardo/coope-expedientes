<!DOCTYPE html>
<html>
<head>
    <title>Sistema de Expedientes - Notificacion</title>
</head>

<body>
<h2>Sistema de Expedientes - Notificación de Carga de Anexo/Providencia</h2>
<br/>
El presente email se ha generado debido a que se ha cargado un anexo o Providencia a un Expediente<br />
<p>Número: {{ $new_anexo->expediente->numero }} </p>
<p>Expediente: {{ $new_anexo->expediente->caratula }} </p>
<p>Fecha del Expediente: {{ $new_anexo->expediente->fecha }}</p>

<p></p>


<p>Anexo ó Providencia: {{ $new_anexo->anexo_providencia }} </p>
<p>Descripción: {{ $new_anexo->descripcion }} </p>
<p>Fecha Vto: {{ $new_anexo->fecha_vto }} </p>


</body>

</html>
