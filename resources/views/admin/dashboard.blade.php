@extends('layouts.admin')

@section('content')

<h2>Dashboard</h2><hr>

<div class="card mt-4 p-4 shadow-sm"> 
    <h4>Estadisticas reservas</h4>
    <div class="row g-3">
        <div class="col-md-3">
            <div class="card text-center p-3 h-100">
                <h6>Ingresos totales</h6>
                <h3>${{ number_format($ingresos) }}</h3>
            </div>
        </div>
        <div class="col-3">
            <div class="card p-3 text-center">
                <h6>Ingresos mensuales</h6>
                <h3>${{number_format($ingresos_mes)}}</h3>
            </div>
        </div>        
        <div class="col-3">
            <div class="card p-3 text-center">
                <h6>Reservas del día</h6>
                <h3>{{ $reservas_hoy }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3 h-100">
                <h6>Total de reservas</h6>
                <h3>{{ $totalReservas }}</h3>
            </div>
        </div>
    </div>
    <div class="row g-3" style="padding-top:20px;">
        <div class="col-md-3">
            <div class="card text-center p-3 h-100 bg-success text-white">
                <h6>Pagadas</h6>
                <h3>{{ $pagadas }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center p-3 h-100 bg-primary text-white">
                <h6>Confirmadas</h6>
                <h3>{{ $confirmadas }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center p-3 h-100 bg-warning">
                <h6>Pendientes</h6>
                <h3>{{ $pendientes }}</h3>
            </div>
        </div>

        <div class="col-md-3">
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
            <h5 class="mb-3">Reservas por estado</h5>

            <div style="position: relative; height:250px;">
                <canvas id="reservasChart"></canvas>
            </div>
        </div>
    </div>

    <!-- GRÁFICO VEHÍCULOS POR MARCA -->
    <div class="col-md-6">
        <div class="card p-4 h-100">
            <h5 class="mb-3">Vehículos por marca</h5>

            <div style="position: relative; height:250px;">
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
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<!-- Grafico por reservas -->
<script> 
    document.addEventListener("DOMContentLoaded", function() {
        const data = [
            {{ $pagadas }},
            {{ $confirmadas }},
            {{ $pendientes }},
            {{ $canceladas }}
        ];

        const total = data.reduce((a, b) => a + b, 0);

        const existingChart = Chart.getChart("reservasChart");
        if (existingChart) {
            existingChart.destroy();
        }

        new Chart(document.getElementById('reservasChart'), {
            type: 'pie',
            data: {
                labels: ['Pagadas', 'Confirmadas', 'Pendientes','Canceladas'],
                datasets: [{
                    data: data,
                    backgroundColor: ['#28a745','#0d6efd','#ffc107','#dc3545']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '60%',
                plugins: {               
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 15
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let value = context.raw;               
                                let percentage = total > 0 
                                    ? ((value / total) * 100).toFixed(1)
                                    : 0;
                                return context.label + ": " + value + " (" + percentage + "%)";
                            }
                        }
                    },
                    datalabels: {
                        color: '#000',
                        font: {
                            weight: 'bold',
                            size: 14
                        },
                        formatter: (value) => {
                            let percentage = total > 0 
                                ? ((value / total) * 100).toFixed(1)
                                : 0;
                            return percentage + "%";
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    });
</script>

<!-- Grafico por marcas -->
<script>
    // Instancia de marcas
    const marcasLabels = {!! json_encode($marcas->pluck('marca.nombre')) !!};
    const marcasData = {!! json_encode($marcas->pluck('total')) !!};
    
    new Chart(document.getElementById('marcasChart'), {
        type: 'bar',
        data: {
            labels: marcasLabels,
            datasets: [{
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
                },
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    color: '#000',
                    font: {
                        weight: 'bold'
                    }
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