@extends('layouts.app')

@section('content')

    @if(Session::has('deleted_user'))

        <p class="bg-danger">{{session('deleted_user')}}</p>

    @endif

    <div class="panel panel-default">
        <div class="panel-heading">
            Usuarios
        </div>
        <div class="panel-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Telefono</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Creado</th>
                        <th>Editado</th>
                        @if(Auth::user()->role_id == 1)
                            <th>Editar</th>
                            <th>Borrar</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if($users)

                        @foreach($users as $user)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->phone == "" ? "-" : $user->phone}}</td>
                                <td>{{$user->role->name}}</td>
                                <td>{{$user->is_active == 1 ? 'Activo' : 'Inactivo'}}</td>
                                <td>{{$user->created_at->diffForHumans()}}</td>
                                <td>{{$user->updated_at->diffForHumans()}}</td>
                                @if(Auth::user()->role_id == 1)
                                    <td><a href="{{route('usuarios.edit',['id' => $user->id])}}" class="btn btn-info btn-xs">Editar</a></td>
                                    <td>
                                        <form action="{{route('usuarios.destroy',['id' => $user->id])}}" method="post">
                                            {{ csrf_field() }}
                                            <div class="form-group">
                                                <input type="hidden" name="_method" value="delete">
                                                <input type="submit" class="btn btn-danger btn-xs" value="Borrar" onclick="javascript: return confirm('Esta seguro que desea eliminar al usuario?');">
                                            </div>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

@stop