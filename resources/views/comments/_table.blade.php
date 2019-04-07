<div class="table-responsive" style="width: 100%;">
<table class="table table-striped table-hover" id="table">
    <thead>
    <tr>
        <th style="width: 10%">Fecha</th>
        <th style="width: 30%">Anexo</th>
        <th style="width: 45%">Descripción</th>

        <th style="width: 15%">Opciones</th>
    </tr>
    </thead>

    <tbody>
    @foreach($comentarios as $c)
        <tr>
            <td style="width: 10%"> {{ $c->created_at->format('d-m-Y') }} </td>
            <td style="width: 30%"> {{ $c->anexo->descripcion }} </td>
            <td style="width: 45%"> {{ $c->description }} </td>

            <td style="width: 15%">
                @if($action == 'index')
                    <a href="{{ route('comment.show', $c) }}" class="btn btn-primary btn-xs pull-rigth">Visualizar</a>
                    <a href="{{ route('comment.delete', $c)}}" class="btn btn-danger btn-xs pull-rigth" onclick="return confirm('Está seguro que desea eliminar este ítem?')"
    class="btn btn-danger">Eliminar</a>
                @endif

            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>
