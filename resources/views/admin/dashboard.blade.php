@extends('layouts.admin')

@section('content')

<h2>Dashboard</h2><hr>

<div class="card mt-4 p-4 shadow-sm">
    <h4>Estadisticas reservas</h4>
    <div class="row g-3">

        <div class="col-md-3">
            <div class="card text-center p-3 h-100">
                <h6>Total</h6>
                <h3>{{ $totalReservas }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center p-3 h-100">
                <h6>Ingresos</h6>
                <h3>${{ number_format($ingresos) }}</h3>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card text-center p-3 h-100 bg-warning">
                <h6>Pendientes</h6>
                <h3>{{ $pendientes }}</h3>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card text-center p-3 h-100 bg-success text-white">
                <h6>Confirmadas</h6>
                <h3>{{ $confirmadas }}</h3>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card text-center p-3 h-100 bg-danger text-white">
                <h6>Canceladas</h6>
                <h3>{{ $canceladas }}</h3>
            </div>
        </div>

    </div>
</div><hr>

<div class="card mt-4 p-4 shadow-sm">
    <h4>Inventario de vehículos</h4>
    <div class="row g-3">
        <div class="col-md-4">
            <div class="card text-center p-3 bg-success text-white">
                <h6>Activos</h6>
                <h3>{{ $activos }}</h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center p-3 bg-warning">
                <h6>Mantenimiento</h6>
                <h3>{{ $mantenimiento }}</h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center p-3 bg-danger text-white">
                <h6>Inactivos</h6>
                <h3>{{ $inactivos }}</h3>
            </div>
        </div>
    </div>
</div><hr>

<div class="row mt-4">
    <!-- GRÁFICO RESERVAS -->
    <div class="col-md-6">
        <div class="card p-4 h-100">
            <h5>Reservas por estado</h5>

            <div style="height:300px;">
                <canvas id="reservasChart"></canvas>
            </div>
        </div>
    </div>

    <!-- GRÁFICO VEHÍCULOS POR MARCA -->
    <div class="col-md-6">
        <div class="card p-4 h-100">
            <h5>Vehículos por marca</h5>

            <div style="height:300px;">
                <canvas id="marcasChart"></canvas>
            </div>
        </div>
    </div>
</div>

@php
    $labels = [];
    $data = [];

    foreach($marcas as $m){
        $labels[] = $m->marca->nombre;
        $data[] = $m->total;
    }
@endphp

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

// Graifco reservas
new Chart(document.getElementById('reservasChart'), {
    type: 'pie',
    data: {
        labels: ['Pendientes', 'Confirmadas', 'Canceladas'],
        datasets: [{
            data: [
                {{ $pendientes }},
                {{ $confirmadas }},
                {{ $canceladas }}
            ],
            backgroundColor: ['#ffc107','#28a745','#dc3545']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

// Instancia de marcas
const marcasLabels = {!! json_encode($marcas->pluck('marca.nombre')) !!};
const marcasData = {!! json_encode($marcas->pluck('total')) !!};

// Grafico por marcas
new Chart(document.getElementById('marcasChart'), {
    type: 'bar',
    data: {
        labels: marcasLabels,
        datasets: [{
            label: 'Vehículos',
            data: marcasData,
            backgroundColor: '#0d6efd'
        }]
    },
    
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            }
        },
        plugins: {
            legend: {
                display: false
            }
        }
    }

});

</script>

<script>
    const ctx = document.getElementById('reservasChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [{
                label: 'Vehículos por marca',
                data: {!! json_encode($data) !!},
                backgroundColor: '#0d6efd'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            }
    }
});

</script>

@endsection