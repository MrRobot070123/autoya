@extends('layouts.client')

@section('content')

<div class="container mt-5" style="max-width:900px;">

    <h2 class="mb-4">Mis reservas</h2>

    <div class="card p-3">

        <table class="table">

            <thead>
                <tr>
                    <th>Vehículo</th>
                    <th>Fechas</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>

            <tbody>

                @foreach($reservas as $r)
                <tr>

                    <td>
                        {{ $r->vehiculo->marca->nombre }}
                        {{ $r->vehiculo->modelo->nombre }}
                    </td>

                    <td>
                        {{ $r->fecha_inicio }} → {{ $r->fecha_fin }}
                    </td>

                    <td style="text-align: center;">                        
                        <span class="badge {{ $r->color_estado }}">
                            {{ ucfirst($r->estado) }}
                        </span>
                    </td>

                    <td style="text-align: center;">

                        <!-- SI ESTÁ CONFIRMADA -->
                        @if($r->estado == 'confirmada')

                            <form action="{{ route('reservas.pagar', $r->id) }}" method="POST" style="margin: 0; padding: 0;">
                                @csrf
                                <button class="btn btn-success btn-sm">
                                    Pagar
                                </button>
                            </form>

                        @elseif($r->estado == 'pagada')

                            <a href="{{ route('reservas.contrato',$r->id) }}"
                               class="btn btn-primary btn-sm">
                                Ver contrato
                            </a>

                        @else
                            —
                        @endif

                    </td>

                </tr>
                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection