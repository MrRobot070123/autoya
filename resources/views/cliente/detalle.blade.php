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

<div class="container" style="max-width:1000px; margin-top: 50px; margin-bottom: 50px;">
    <h2 class="mb-4">Ficha vehículo</h2>

    <div class="card p-4 shadow-lg" style="border-radius: 10px;">
        
        <div class="row">
            <div class="row">
                <div class="col-md-10">
                    <h4>{{ $vehiculo->marca->nombre }} - {{ $vehiculo->modelo->nombre }}</h4>
                </div>
                <div class="col-md-2">
                    <img src="/img/logo-trans.png" alt="logo.png" style="width: 110px;">
                </div>
            </div><hr>
            <!--  SLIDER IMÁGENES -->
            <div class="col-md-7">
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
                                <b>Descripción:</b> {{ $vehiculo->tipo->descripcion }}<br>
                                <b>Condiciones:</b> Vehículo en excelente estado. Incluye seguro, asistencia y mantenimiento al día.
                            </p>
                    </div>
                </div>
            </div>

            <!--  INFO -->
            <div class="col-md-5">
                <h6 class="mb-3" style="text-align: center; margin-top: 30px;">
                        Busca su disponiblidad por fechas
                </h6>

                <!--  FORM -->
                <form method="GET">

                        <div class="mb-2">
                            <label>Inicio</label>                 
                            <input type="date" name="inicio"
                                value="{{ request('inicio') }}"
                                class="form-control"
                                min="{{ date('Y-m-d') }}"
                                required
                            >
                        </div>

                        <div class="mb-2">
                            <label>Fin</label>
                            <input type="date" name="fin"
                                value="{{ request('fin') }}"
                                class="form-control"
                                min="{{ request('inicio') ?? date('Y-m-d') }}"
                                required
                            >
                        </div>

                        <button class="btn btn-primary w-100 mt-2">
                            Ver disponibilidad
                        </button>

                </form>

                <!--  RESULTADO -->
                @if(request('inicio') && request('fin'))

                        @php
                            $ocupado = \App\Models\Reserva::where('vehiculo_id',$vehiculo->id)
                                ->whereIn('estado',['pendiente','confirmada'])
                                ->where(function($q){
                                    $q->whereBetween('fecha_inicio',[request('inicio'),request('fin')])
                                    ->orWhereBetween('fecha_fin',[request('inicio'),request('fin')])
                                    ->orWhere(function($q2){
                                        $q2->where('fecha_inicio','<=',request('inicio'))
                                            ->where('fecha_fin','>=',request('fin'));
                                    });
                                })
                                ->exists();
                        @endphp

                        @if(!$ocupado)

                            <div class="alert alert-success mt-3" style="text-align: center">
                                Vehículo disponible en esas fechas
                            </div>

                            <a href="{{ url('/reservar') }}?vehiculo={{ $vehiculo->id }}&inicio={{ request('inicio') }}&fin={{ request('fin') }}"
                            class="btn btn-success w-100">
                                Reservar ahora
                            </a>

                        @else

                            <div class="alert alert-danger mt-3" style="text-align: center">
                                Vehículo no disponible en esas fechas
                            </div>

                        @endif

                @endif
            </div>

        </div>

    </div>

</div>

@endsection