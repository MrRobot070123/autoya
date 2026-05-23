@extends('layouts.admin')

@section('content')

<div class="container mt-4">

    <h3>Cliente: {{ $cliente->nombre }}</h3>

    <div class="card p-3 mb-4">

        <p><b>Cédula:</b> {{ $cliente->cedula }}</p>
        <p><b>Email:</b> {{ $cliente->email }}</p>
        <p><b>Teléfono:</b> {{ $cliente->telefono }}</p>
        <p><b>Total reservas:</b> {{ $cliente->reservas->count() }}</p>

    </div>

    <h4>Historial de reservas</h4>

    <div class="card p-3">

        <table class="table">

            <thead>
                <tr>
                    <th>Vehículo</th>
                    <th>Fechas</th>
                    <th>Total</th>
                    <th>Estado</th>
                </tr>
            </thead>

            <tbody>

                @foreach($cliente->reservas as $r)
                <tr>

                    <td>
                        {{ $r->vehiculo->marca->nombre }}
                        {{ $r->vehiculo->modelo->nombre }}
                    </td>

                    <td>
                        {{ $r->fecha_inicio }} → {{ $r->fecha_fin }}
                    </td>

                    <td>
                        ${{ number_format($r->precio_total) }}
                    </td>

                    <td>
                        <span class="badge 
                            {{ $r->estado == 'pendiente' ? 'bg-warning' : 
                               ($r->estado == 'confirmada' ? 'bg-primary' : 
                               ($r->estado == 'pagada' ? 'bg-success' : 'bg-danger')) }}">
                            {{ ucfirst($r->estado) }}
                        </span>
                    </td>

                </tr>
                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection
