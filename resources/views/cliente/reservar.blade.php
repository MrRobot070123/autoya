@extends('layouts.client')

@section('content')

<style>
    /* CARD */
    h1, h2, h3, h4, h5, h6{
        font-family: verdana;
        font-weight: bold;
        color: #04143A;
    }
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

<div class="container" style="max-width:800px; margin-top: 50px; margin-bottom: 50px;">
    <h2 class="mb-4">Confirmar reserva</h2>

    <div class="card p-4 shadow-lg" style="border-radius: 10px;">

        <div class="row">
            <!-- SLIDER IMÁGENES -->
            <div class="col-md-6">
                <div class="card card-vehiculo h-100 animate-card">
                    <div id="carouselVehiculo" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">

                                @foreach($vehiculo->imagenes as $key => $img)
                                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                        <img src="{{ asset('storage/'.$img->ruta) }}"
                                            class="d-block w-100"
                                            style="height:250px; object-fit:cover;">
                                    </div>
                                @endforeach

                        </div>

                        @if($vehiculo->imagenes->count() > 1)

                                <button class="carousel-control-prev" type="button"
                                    data-bs-target="#carouselVehiculo" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>

                                <button class="carousel-control-next" type="button"
                                    data-bs-target="#carouselVehiculo" data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                </button>

                        @endif

                    </div>
                    <!--  CARACTERÍSTICAS -->
                    <div class="card-body">
                            <p style="font-size: 15px; font-family: verdana; color: #04143A;">
                                <b>Placa:</b> {{ $vehiculo->placa }}<br>
                                <b>Tipo:</b> {{ $vehiculo->tipo->tipo }}<br>
                                <b>Ubicación:</b> {{ $vehiculo->ubicacion }}<br>
                                <b>Tarifa:</b> ${{ number_format($vehiculo->tarifa_diaria) }} / día<br>
                                <b>Condiciones:</b> Vehículo en excelente estado. Incluye seguro, asistencia y mantenimiento al día.<br>
                            </p>
                    </div>
                </div>
            </div>

            <!-- INFO -->
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-8">
                        <h4 style="margin-bottom: 0; margin-top: 5px;">{{ $vehiculo->marca->nombre }} - {{ $vehiculo->modelo->nombre }}</h4>
                    </div>
                    <div class="col-md-4">
                        <img src="/img/logo-trans.png" alt="logo.png" style="width: 110px;">
                    </div>
                </div><hr>
                @php
                    $inicio = \Carbon\Carbon::parse($inicio);
                    $fin = \Carbon\Carbon::parse($fin);
                    $dias = $inicio->diffInDays($fin) + 1;

                    $total = $dias * $vehiculo->tarifa_diaria;
                @endphp

                <!-- DATOS -->
                <ul class="list-group mb-3" style="padding: 20px 0;">

                    <li class="list-group-item d-flex justify-content-between">
                        <span>Inicio</span>
                        <strong>{{ $inicio->format('d/m/Y') }}</strong>
                    </li>

                    <li class="list-group-item d-flex justify-content-between">
                        <span>Fin</span>
                        <strong>{{ $fin->format('d/m/Y') }}</strong>
                    </li>

                    <li class="list-group-item d-flex justify-content-between">
                        <span>Días</span>
                        <strong>{{ $dias }}</strong>
                    </li>

                    <li class="list-group-item d-flex justify-content-between">
                        <span>Tarifa diaria</span>
                        <strong>${{ number_format($vehiculo->tarifa_diaria) }}</strong>
                    </li>

                </ul>

                <!-- PRECIO -->

                <h3 class="text-success" style="text-align: right; font-size:20px;">
                    Total: ${{ number_format($total) }}
                </h3>

                <!-- FORM -->
                <form action="{{ url('/reservar') }}" method="POST">
                    @csrf

                    <input type="hidden" name="vehiculo_id" value="{{ $vehiculo->id }}">
                    <input type="hidden" name="fecha_inicio" value="{{ $inicio->toDateString() }}">
                    <input type="hidden" name="fecha_fin" value="{{ $fin->toDateString() }}">
                    <input type="hidden" name="origen" value="cliente">

                    <button class="btn btn-success w-100 btn-lg">
                        Confirmar reserva
                    </button>
                </form>

            </div>

        </div>

    </div>
</div>

@endsection
