<div class="form-group">
    {{Form::label('name', 'Nombre del producto')}}
    {{Form::text('name', null, ['class' => 'form-control'])}}
</div>

<div class="form-group">
    {{Form::label('description', 'Descripcion del producto')}}
    {{Form::text('description', null, ['class' => 'form-control'])}}
</div>

<div class="form-group">
    {{Form::submit('Guardar', ['class' => 'btn btn-sm btn-primary'])}}
</div>