@extends('layouts.admin')

@section('content')

<h2>Detalle Vehículo</h2>

<p><b>Placa:</b> {{ $vehiculo->placa }}</p>
<p><b>Marca:</b> {{ $vehiculo->marca->nombre }}</p>
<p><b>Modelo:</b> {{ $vehiculo->modelo->nombre }}</p>

<h4>Imágenes</h4>

<div class="row mb-3">
    @foreach($vehiculo->imagenes as $img)
        <div class="col-md-3 text-center">
            <img src="{{ asset('storage/' . $img->ruta) }}" 
                class="img-fluid rounded mb-1"
                style="height:140px; width:100%; object-fit:cover;"
            >
        </div>
    @endforeach
</div>

@endsection