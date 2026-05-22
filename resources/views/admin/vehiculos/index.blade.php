@extends('layouts.admin')

@section('content')

<h2>Vehículos</h2>

<a href="{{ route('vehiculos.create') }}" class="btn btn-primary mb-3">
    Nuevo Vehículo
</a>

<!-- FILTRO -->
<form method="GET">
    <select name="estado" onchange="this.form.submit()" class="form-control w-25 mb-3">
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
</form>

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
            <td>${{ $v->tarifa_diaria }}</td>
            <td>{{ $v->ubicacion }}</td>                 
            <td>
                @if($v->imagenes->count())
                    <img src="{{ asset('storage/' . $v->imagenes->first()->ruta) }}" width="60" height="60">
                @endif
            </td>           
            <td>
                <a href="{{ route('vehiculos.show', $v->id) }}" 
                class="btn btn-info btn-sm">
                    Ver
                </a>
            </td> 
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
            <td>
                <!-- BOTÓN EDITAR -->
                <a href="{{ route('vehiculos.edit', $v->id) }}" 
                class="btn btn-warning btn-sm">
                    Editar
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection