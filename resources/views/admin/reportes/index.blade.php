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

        <div class="row g-2 mb-3">
            <div class="col-md-6">
                <h3 class="mb-4">Reportes</h3>
            </div>
            <div class="text-end col-md-6">
                <a href="{{ route('admin.reportes.pdf', ['inicio' => request('inicio'),'fin' => request('fin')]) }}" class="btn btn-danger me-2">
                    <i class="bi bi-filetype-pdf"></i>
                    PDF
                </a>
                <a href="{{ route('admin.reportes.excel', ['inicio' => request('inicio'),'fin' => request('fin')]) }}" class="btn btn-success">
                    <i class="bi bi-file-earmark-excel-fill"></i>
                    Excel
                </a>
            </div>
        </div>

        <form method="GET" class="row g-2 mb-3">

            <div class="col-md-5">
                <label>Fecha inicio</label>
                <input type="date" name="inicio" class="form-control"
                    value="{{ request('inicio') }}">
            </div>

            <div class="col-md-5">
                <label>Fecha fin</label>
                <input type="date" name="fin" class="form-control"
                    value="{{ request('fin') }}">
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <button class="btn btn-primary w-100">
                    Filtrar
                </button>
            </div>

        </form>
        
        @if($inicio && $fin)
            <div class="alert alert-light border">
                Mostrando datos desde 
                <b>{{ $inicio->format('d/m/Y') }}</b> 
                hasta 
                <b>{{ $fin->format('d/m/Y') }}</b>
            </div>
        @endif

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

        @if($inicio && $fin)
            <div class="card shadow-sm p-4 mt-4">

                <h5 class="mb-3">Resumen por estados (sin canceladas)</h5>

                <div class="row text-center">

                    @forelse($estados as $estado)

                        <div class="col-md-4 mb-2">
                            <div class="border rounded p-3">

                                <h6 class="text-muted">
                                    {{ ucfirst($estado->estado) }}
                                </h6>

                                <h3 class="
                                    {{ $estado->estado == 'pagada' ? 'text-success' : 
                                    ($estado->estado == 'confirmada' ? 'text-primary' : 'text-warning') }}">
                                    {{ $estado->total }}
                                </h3>

                            </div>
                        </div>

                    @empty

                        <div class="col-12">
                            <p class="text-muted">No hay datos para el rango seleccionado</p>
                        </div>

                    @endforelse

                </div>

            </div>
        @endif

        <div class="card shadow-sm p-4 mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5>Ingresos</h5>
            </div>

            <div class="text-center my-4">
                <h1 class="fw-bold text-success">
                    ${{ number_format($ingresos) }}
                </h1>
            </div>
        </div>

    </div>
</div>

@endsection