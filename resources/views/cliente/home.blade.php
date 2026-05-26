@extends('layouts.client')
@section('content')

    <!-- HERO -->
    <section class="hero">
        <div class="hero-text">

            <h2>Alquila tu vehículo fácil y rápido</h2>

            <p>
                Encuentra el carro perfecto para tu viaje. 
                Disponible en Barranquilla, Bogotá, Medellín y más ciudades.
            </p>

            <div class="hero-buttons">
                <a href="/vehiculos/buscar" class="btn-primary">
                    Reservar ahora
                </a>

                <a href="/vehiculos" class="btn-secondary">
                    Ver vehículos
                </a>
            </div>

        </div>
    </section>

    <div class="content" style="max-width: 1100px; margin: auto;">
        <section class="services-section">
            <h2>Nuestros vehículos</h2>
            <div class="services-grid">
                @foreach($vehiculos as $v)
                    <div class="service-card">
                        @if($v->imagenes->count())
                            <img src="{{ asset('storage/'.$v->imagenes->first()->ruta) }}">
                        @else
                            https://via.placeholder.com/300x200?text=Sin+Imagen
                        @endif
                        <h3 style="margin:0;">
                            {{ $v->marca->nombre }} - {{ $v->modelo->nombre }}
                        </h3>

                        <p style="margin:0;">
                            ${{ number_format($v->tarifa_diaria) }} / día
                        </p>

                        <p style="font-size:14px; color:#777;" style="margin:0;">
                            {{ $v->ubicacion }}
                        </p>

                        <a href="{{ url('/vehiculos/buscar') }}" class="btn-card">
                            Ver disponibilidad
                        </a>
                    </div>
                @endforeach
            </div>
        </section>
    </div>

    <!-- ABOUT -->
    <section class="about">

        <div class="about-content">

            <div style="text-align: justify;">
                <h2>Sobre AutoYa</h2><br>
                <p>
                    En AutoYa transformamos la manera de alquilar vehículos en Colombia, ofreciendo un 
                    servicio diseñado para personas y empresas que buscan movilidad rápida, segura y sin
                    complicaciones. 
                </p><br>
                <p>
                    Nuestra misión es brindarte la libertad de moverte cuando lo necesites, con procesos
                    ágiles, atención confiable y una experiencia moderna de principio a fin.
                </p><br>
                <p>
                    Nos enfocamos en ofrecer una experiencia simple y segura, con reservas rápidas, atención
                    personalizada y acompañamiento durante todo el proceso de alquiler. Cada vehículo pasa 
                    por controles de calidad y mantenimiento preventivo para garantizar comodidad, 
                    rendimiento y tranquilidad en cada trayecto.
                </p>
            </div>

            <img src="/img/alquiler.png" class="about-img">

        </div>

    </section>

    <section class="cta">

        <h3>¿Listo para tu próximo viaje?</h3>

        <a href="/vehiculos/buscar" class="btn-primary">
            Reservar ahora
        </a>

        <a href="/vehiculos" class="btn-secondary">
            Ver catálogo
        </a>

    </section>

@endsection
