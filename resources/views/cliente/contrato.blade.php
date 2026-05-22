@extends('layouts.client')

@section('content')

<div class="container mt-5">

    <h2>Contrato de arrendamiento</h2>

    <p><b>N°:</b> {{ $reserva->numero_contrato }}</p>
    <p><b>Vehículo:</b> {{ $reserva->vehiculo->marca->nombre }}</p>
    <p><b>Cliente:</b> Usuario demo</p>
    <p><b>Fechas:</b> {{ $reserva->fecha_inicio }} - {{ $reserva->fecha_fin }}</p>

</div>

@endsection