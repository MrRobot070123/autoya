@extends('layouts.admin')

@section('content')

<div class="container mt-4">

    <div class="row justify-content-center">

        <div class="col-md-8 col-lg-6">

            <div class="card shadow-sm p-4">

                <div class="text-center mb-3">
                    <img src="/img/logo-trans.png" width="120">
                    <h4 class="mt-2">Crear usuario</h4>
                </div>

                <form method="POST" action="{{ route('admin.clientes.store') }}">
                    @csrf

                    <div class="row">

                        <div class="col-md-6 mb-2">
                            <label>Cédula</label>
                            <input type="text" name="cedula" class="form-control">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Nombre</label>
                            <input type="text" name="nombre" class="form-control">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Teléfono</label>
                            <input type="text" name="telefono" class="form-control">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Contraseña</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Confirmar contraseña</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Rol</label>
                            <select name="rol" class="form-control">
                                <option value="cliente">Cliente</option>
                                <option value="admin">Administrador</option>
                            </select>
                        </div>

                    </div>

                    <div class="d-grid">
                        <button class="btn btn-primary">
                            <i class="bi bi-person-plus"></i> Crear usuario
                        </button>
                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection