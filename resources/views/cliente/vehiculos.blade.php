@extends('layouts.client')
@section('content')
    <body>     
        <form method="GET" class="filtros-horizontal">
            <select name="ubicacion">
                <option value="">Ciudad</option>
                @foreach($ciudades as $c)
                    <option value="{{ $c }}" {{ request('ubicacion') == $c ? 'selected' : '' }}>
                        {{ $c }}
                    </option>
                @endforeach
            </select>

            <select name="marca">
                <option value="">Marca</option>
                @foreach($marcas as $m)
                    <option value="{{ $m->id }}" {{ request('marca') == $m->id ? 'selected' : '' }}>
                        {{ $m->nombre }}
                    </option>
                @endforeach
            </select>

            <select name="tipo">
                <option value="">Tipo</option>
                @foreach($tipos as $t)
                    <option value="{{ $t->id }}" {{ request('tipo') == $t->id ? 'selected' : '' }}>
                        {{ $t->tipo }}
                    </option>
                @endforeach
            </select>

            <select name="precio">
                <option value="">Precio máx</option>
                <option value="150000">$150k</option>
                <option value="250000">$250k</option>
                <option value="400000">$400k</option>
            </select>

            <button type="submit">
                Filtrar
            </button>

        </form>

        <!-- SERVICIOS -->
        <section class="services-section">

            <h2>Nuestros vehículos</h2>

            <div class="contenedor-principal">
                <div class="services-grid">
                    @foreach($vehiculos as $v)
                        <div class="service-card">
                            @if($v->imagenes->count())
                                <img src="{{ asset('storage/'.$v->imagenes->first()->ruta) }}">
                            @else
                                https://via.placeholder.com/300x200?text=Sin+Imagen
                            @endif
                            <h3 style="margin: 0;">
                                {{ $v->marca->nombre }} - {{ $v->modelo->nombre }}
                            </h3>

                            <p style="font-size:14px; color:#777; margin: 0;">
                                ${{ number_format($v->tarifa_diaria) }} / día <br>
                                {{ $v->ubicacion }}
                            </p>
                            
                            <a href="{{ url('/vehiculo/'.$v->id) }}" class="btn-card">
                                Ver auto
                            </a>

                        </div>
                    @endforeach
                </div>    
            </div>
        </section>
    </body>
@endsection