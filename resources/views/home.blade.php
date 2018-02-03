@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">Home</div>

                <div class="panel-body">
                    @if(Auth::user()->is_active == 0)
                        El usuario se encuentra desactivado, por favor comuniquese con el administrador
                    @else
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        Hola {{Auth::user()->name}}! Bienvenido al Sistema de Administracion de Usuarios
                    @endif
                    <br>
                    @if(Auth::user()->role_id == 2)
                        @if(Auth::user()->permiso_lectura == 0)
                            Tus permisos de lectura se encuentran RESTRINGIDOS
                        @else
                            Tus permisos de lectura se encuentran HABILITADOS
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
