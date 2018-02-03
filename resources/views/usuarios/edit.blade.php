@extends('layouts.app')

@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">
            Editar Usuario
        </div>
        <div class="panel-body">

            @include('includes.form_errors')

            <form action="{{route('usuarios.update',['id' => $user->id] )}}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="put">
                <div class="form-group">
                    <label for="name">Nombre:</label>
                    <input type="text" class="form-control" name="name" value="{{$user->name}}">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" name="email" value="{{$user->email}}">
                </div>
                <div class="form-group">
                    <label for="role_id">Rol:</label>
                    <label for="role_id" id="role_label">{{$user->role->name}}</label>
                    <select name="role_id" class="form-control" id="role_select" onchange="permisos(this);">
                        <option value="{{$user->role_id}}">{{$user->role->name}}</option>
                        @foreach($roles as $key => $role)
                            @if($user->role_id != $key)
                                <option value="{{$key}}">{{$role}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group" id="permisos" style="display:none">
                    <label for="permiso_lectura">Permiso de Lectura: {{$user->permiso_lectura == 1 ? 'SI' : 'NO'}}</label> <br>
                    <label>Elegir opcion: </label> 
                    <input type="radio" name="permiso_lectura" value="1" id="permiso_si"> Si &nbsp;
                    <input type="radio" name="permiso_lectura" value="0" id="permiso_no"> No<br>
                </div>
                <div class="form-group">
                    <label for="is_active">Estado:</label>
                    <label for="role_id" id="active_label" visible>{{$user->is_active == 1 ? 'Activo' : 'Inactivo'}}</label>
                    <select name="is_active" class="form-control" id="active_select">
                        <option value="{{$user->is_active}}">{{$user->is_active == 1 ? 'Activo' : 'Inactivo'}}</option>
                        @if($user->is_active == 1)
                            <option value="0">Inactivo</option>
                        @else
                            <option value="1">Activo</option>
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <label for="phone">Telefono:</label>
                    <input type="text" class="form-control" name="phone" value="{{$user->phone}}">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <div class="form-group pull-left">
                    <input type="submit" class="btn btn-primary" name="submit" value="Actualizar">
                </div>
            </form>

        </div>
    </div>

    <script>

        @if(Auth::user()->role_id == 1)
            document.getElementById('role_label').style.display = 'none';
            document.getElementById('role_select').style.display = 'block';

            document.getElementById('active_label').style.display = 'none';
            document.getElementById('active_select').style.display = 'block';
        @else
            document.getElementById('role_label').style.display = 'block';
            document.getElementById('role_select').style.display = 'none';

            document.getElementById('active_label').style.display = 'block';
            document.getElementById('active_select').style.display = 'none';
        @endif

        function permisos(elemento) {

            if(elemento.value == 2) {

                document.getElementById('permisos').style.display = 'block';
            }
            else {
                document.getElementById('permisos').style.display = 'none';
            }
        }
       
        @if(Auth::user()->role_id == 1 && $user->role_id == 2)
            document.getElementById('permisos').style.display = 'block';
        @endif

    </script>

@stop