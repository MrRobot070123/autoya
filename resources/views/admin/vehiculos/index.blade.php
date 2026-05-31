@extends('layouts.admin')

@section('content')

<style>
    .btn-action {
        width: 35px;
        height: 35px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .select-estado {
        font-weight: 500;
    }

    .select-estado.warning {
        background-color: #fef9c3;
        border-color: #facc15;
    }

    .select-estado.primary {
        background-color: #dbeafe;
        border-color: #3b82f6;
    }

    .select-estado.success {
        background-color: #dcfce7;
        border-color: #22c55e;
    }

    .select-estado.danger {
        background-color: #fee2e2;
        border-color: #ef4444;
    }

</style>

<div class="container"> 
    <div class="container" style="max-width: 950px;">
        <h2>Vehículos</h2><hr>
        <div class="row g-3">
            <!-- Nuevo vehiculo-->
            <div class="col-md-4">
                <div class="row g-3">
                    <div class="col-md-6" style="padding: 8px 8px;">
                        <label>Agregar vehículo</label>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('vehiculos.create') }}" class="btn btn-primary mb-3">
                            <i class="bi bi-car-front-fill"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Filtro -->
            <div class="col-md-8">
                <form method="GET">
                    <div class="row g-3">
                        <div class="col-md-6" style="padding: 8px 8px; text-align: end;">
                            <label>Filtro por estado</label>
                        </div>
                        <div class="col-md-6">
                            <select name="estado" onchange="this.form.submit()" class="form-control w-100">
                                <option value="" {{ request('estado') == '' ? 'selected' : '' }}>
                                    Todos
                                </option>
                                <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>
                                    Activos
                                </option>
                                <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>
                                    Inactivos
                                </option>
                                <option value="matto" {{ request('estado') == 'matto' ? 'selected' : '' }}>
                                    En Mantenimiento
                                </option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Placa</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Tarifa</th>
                    <th>Ubicación</th>
                    <th>Imagen</th>
                    <th>Detalles</th>
                    <th>Estado</th>
                    <th>Editar</th>
                </tr>
            </thead>

            <tbody>
                @foreach($vehiculos as $v)
                <tr>
                    <td>{{ $v->placa }}</td>           
                    <td>{{ $v->marca->nombre ?? '' }}</td>
                    <td>{{ $v->modelo->nombre ?? '' }}</td>
                    <td>${{ number_format($v->tarifa_diaria) }}</td>
                    <td>{{ $v->ubicacion }}</td>                 
                    <td>
                        @if($v->imagenes->count())
                            <img src="{{ asset('storage/' . $v->imagenes->first()->ruta) }}" width="60" height="60">
                        @endif
                    </td>    
                    <!-- Etiqueta estado --> 
                    <td>    
                        @php
                            $color = match($v->estado) {
                                'activo' => 'bg-success',
                                'inactivo' => 'bg-danger',
                                'matto' => 'bg-warning',
                                default => 'bg-secondary',
                            };
                        @endphp
                        <span class="badge {{ $color }}">
                            {{ ucfirst($v->estado) }}
                        </span>
                    </td>   
                    <!-- Boton ver -->      
                    <td class="text-center">
                        <a href="{{ route('vehiculos.show', $v->id) }}" 
                        class="btn btn-sm btn-outline-info rounded-circle btn-action" title="Ver detalle">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                    <!-- Boton editar -->       
                    <td class="text-center">
                        <a href="{{ route('vehiculos.edit', $v->id) }}" 
                        class="btn btn-sm btn-outline-warning rounded-circle btn-action" title="Editar">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection