@extends('layouts.admin')
@section('content')

<style>
    /* CARD */
    .card-vehiculo {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    /* HOVER CARD */
    .card-vehiculo:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }

    /* IMAGEN */
    .card-vehiculo img {
        transition: transform 0.4s ease;
    }

    /* ZOOM IMAGEN */
    .card-vehiculo:hover img {
        transform: scale(1.05);
    }

    /* BOTÓN */
    .card-vehiculo .btn {
        transition: all 0.3s ease;
    }

    /* HOVER BOTÓN */
    .card-vehiculo .btn:hover {
        transform: scale(1.05);
        background-color: #198754;
    }

    /* TEXTO */
    .card-vehiculo h5 {
        font-weight: 600;
    }

    .animate-card {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeUp 0.5s ease forwards;
    }

    @keyframes fadeUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="container">
    <div class="container" style="max-width: 750px;">
        <h2 class="mb-4">Nueva reserva (admin)</h2><hr>

        <form method="GET">
            <div class="card mt-4 p-4 shadow-sm">
                <h4 class="mb-4">Rango de fechas</h4>
                <div class="row g-3">
                    <div class="col-md-5">
                        <label>Fecha inicio</label>
                        <input type="date" name="inicio"
                            value="{{ request('inicio') }}"
                            class="form-control" required
                        >
                    </div>
                    <div class="col-md-5">
                        <label>Fecha fin</label>
                        <input type="date" name="fin"
                            value="{{ request('fin') }}"
                            class="form-control" required>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-primary w-100">Buscar</button>
                    </div>
                </div>
            </div>
        </form><hr>
        
        <!--Muestra vehiculos-->
        <div class="card mt-4 p-4 shadow-sm">            

            @if(!request('inicio') || !request('fin'))
                <div class="alert alert-info text-center mt-4">
                    Elige las fechas para buscar tu vehículo
                </div>

            @elseif(isset($vehiculos) && $vehiculos->isEmpty())
                <div class="alert alert-warning text-center mt-4">
                    No hay vehículos disponibles para estas fechas
                </div>

            @elseif(isset($vehiculos))                
                
                <h5 class="mt-4 mb-3 text-muted">
                    {{ $vehiculos->count() == 1 ? 'vehículo disponible' : 'Vehículos disponibles:' }}
                    {{ $vehiculos->count() }}
                </h5>

                <div class="row">
                    @foreach($vehiculos as $v)
                        <div class="col-md-6 mb-4">
                            <div class="card card-vehiculo h-100 animate-card">

                                <!-- IMAGEN -->
                                @if($v->imagenes->count())
                                    <img src="{{ asset('storage/'.$v->imagenes->first()->ruta) }}"
                                        class="card-img-top"
                                        style="height:200px; object-fit:cover;">
                                @else
                                    <img src="https://via.placeholder.com/400x200?text=Sin+Imagen"
                                        class="card-img-top">
                                @endif

                                <!-- CONTENIDO -->
                                <div class="card-body">
                                    <h5 class="card-title">
                                        {{ $v->marca->nombre }} - {{ $v->modelo->nombre }}
                                    </h5>
                                    <p class="text-muted mb-2">
                                        ${{ number_format($v->tarifa_diaria) }} / día
                                    </p>                              

                                    <p class="mb-2">
                                        <small>
                                            Modelo: {{ $v->anio }} | {{ $v->ubicacion }}
                                        </small>
                                    </p>
                                    <!-- BOTÓN -->                               
                                    <a href="{{ url('/admin/reservar') }}?vehiculo={{ $v->id }}&inicio={{ request('inicio') }}&fin={{ request('fin') }}"
                                    class="btn btn-success w-100">
                                        Reservar
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

@endsection