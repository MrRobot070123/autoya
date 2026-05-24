@extends('layouts.admin')

@section('content')

<style>
    .card {
        border-radius: 10px;
    }

    h1 {
        font-size: 2.5rem;
    }   
</style>

<div class="container mt-4">
    <div class="container" style="max-width: 950px;">

        <h3 class="mb-4">Reportes</h3>

        <div class="row g-3">

            <div class="col-md-3">
                <div class="card shadow-sm p-3 text-center">
                    <h6 class="text-muted">Ocupación</h6>
                    <h2 class="text-success">{{ number_format($ocupacion,1) }}%</h2>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm p-3 text-center">
                    <h6 class="text-muted">Total vehículos</h6>
                    <h2>{{ $totalVehiculos }}</h2>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm p-3 text-center">
                    <h6 class="text-muted">Ocupados</h6>
                    <h2>{{ $vehiculosOcupados }}</h2>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm p-3 text-center">
                    <h6 class="text-muted">Disponibles</h6>
                    <h2>{{ $disponibles }}</h2>
                </div>
            </div>

        </div>

        <div class="card shadow-sm p-3 mt-3">
            <h6 class="mb-2">Ocupación de flota</h6>

            <div class="progress" style="height: 25px;">
                <div class="progress-bar bg-success"
                    style="width: {{ $ocupacion }}%">
                    {{ number_format($ocupacion,1) }}%
                </div>
            </div>
        </div>

        <div class="card shadow-sm p-4 mt-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5>Ingresos</h5>

                <form method="GET">
                    <select name="periodo" onchange="this.form.submit()" class="form-select">
                        <option value="dia" {{ $periodo=='dia'?'selected':'' }}>Día</option>
                        <option value="mes" {{ $periodo=='mes'?'selected':'' }}>Mes</option>
                        <option value="anio" {{ $periodo=='anio'?'selected':'' }}>Año</option>
                    </select>
                </form>
            </div>

            <div class="text-center my-4">
                <h1 class="fw-bold text-success">
                    ${{ number_format($ingresos) }}
                </h1>
            </div>

            <div class="text-center">

                <a href="{{ route('admin.reportes.pdf') }}" class="btn btn-danger me-2">
                    📄 PDF
                </a>

                <a href="{{ route('admin.reportes.excel') }}" class="btn btn-success">
                    📊 Excel
                </a>

            </div>

        </div>

    </div>
</div>

@endsection