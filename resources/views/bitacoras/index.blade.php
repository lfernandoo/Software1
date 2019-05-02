@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"> 
                Bitacora
                </div>

                <div class="panel-body">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="10px">ID</th>
                                <th>Fecha y Hora</th>
                                <th>Usuario</th>
                                <th>Accion</th>
                                <th colspan="3">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bitacoras as $bitacora)
                            <tr>
                                <td>{{$bitacora->id}}</td>
                                <td>{{$bitacora->fecha}}</td>
                                <td>{{$bitacora->usuario}}</td>
                                <td>{{$bitacora->accion}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$bitacoras->render()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
