@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"> 
                Usuarios
                </div>

                <div class="panel-body">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="10px">ID</th>
                                <th>Nombre</th>
                                <th colspan="3">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td>{{$user->name}}</td>
                                <td width="10 px">
                                    @can('users.show')
                                    <a href="{{route('users.show', $user->id)}}"
                                    class="btn btn-sm btn-default">
                                        Ver
                                    </a>
                                    @endcan
                                </td>

                                <td width="10 px">
                                    @can('users.edit')
                                    <a href="{{route('users.edit', $user->id)}}"
                                    class="btn btn-sm btn-default">
                                        Editar
                                    </a>
                                    @endcan
                                </td>

                                <td width="10 px">
                                    @can('users.destroy')
                                    {!!Form::open(['route'=>['users.destroy', $user->id],
                                    'method'=>'DELETE'])!!}
                                        <button class="btn btn-sm btn-danger">
                                            Eliminar
                                        </button>
                                    {!!Form::close()!!}
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$users->render()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
