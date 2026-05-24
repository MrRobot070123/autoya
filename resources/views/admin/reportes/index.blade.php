@extends('layouts.admin')

@section('content')

<div class="container mt-4">

    <h3>Reportes</h3>

    {{-- Ocupación --}}
    <div class="card p-3 mb-4">
        <h5>Ocupación de flota</h5>

        <p>Total vehículos: {{ $totalVehiculos }}</p>
        <p>Ocupados: {{ $vehiculosOcupados }}</p>
        <p>Disponibles: {{ $disponibles }}</p>

        <div class="progress">
            <div class="progress-bar bg-success"
                style="width: {{ $ocupacion }}%">
                {{ number_format($ocupacion,1) }}%
            </div>
        </div>
    </div>

    {{-- Financiero --}}
    <div class="card p-3">

        <h5>Ingresos por periodo</h5>

        <form method="GET" class="mb-3">
            <select name="periodo" onchange="this.form.submit()">
                <option value="dia" {{ $periodo=='dia'?'selected':'' }}>Día</option>
                <option value="mes" {{ $periodo=='mes'?'selected':'' }}>Mes</option>
                <option value="anio" {{ $periodo=='anio'?'selected':'' }}>Año</option>
            </select>
        </form>

        <h4>${{ number_format($ingresos) }}</h4>

    </div>

    <button class="btn btn-danger"><a href="{{ route('admin.reportes.pdf') }}">Descargar PDF</a></button>
    <button class="btn btn-success"><a href="{{ route('admin.reportes.excel') }}">Exportar Excel</a></button>

</div>

@endsection