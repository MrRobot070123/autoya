@extends('layouts.admin')

@section('content')

<style>
    .btn-action {
        width: 35px;
        height: 35px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .select-estado {
        font-weight: 500;
    }

    .select-estado.warning {
        background-color: #fef9c3;
        border-color: #facc15;
    }

    .select-estado.primary {
        background-color: #dbeafe;
        border-color: #3b82f6;
    }

    .select-estado.success {
        background-color: #dcfce7;
        border-color: #22c55e;
    }

    .select-estado.danger {
        background-color: #fee2e2;
        border-color: #ef4444;
    }

</style>

<div class="container"> 
    <div class="container" style="max-width: 950px;">
        <h2>Reservas</h2><hr>

        <!-- Filtro -->
        <form method="GET" class="mb-3">
            <div class="row">
                <!-- Estado -->
                <div class="col-md-4">
                    <label>Estado</label>
                    <select name="estado" class="form-control">
                        <option value="">Todos</option>
                        <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>
                            Pendiente
                        </option>
                        <option value="pagada" {{ request('estado') == 'pagada' ? 'selected' : '' }}>
                            Pagada
                        </option>
                        <option value="confirmada" {{ request('estado') == 'confirmada' ? 'selected' : '' }}>
                            Confirmada
                        </option>
                        <option value="cancelada" {{ request('estado') == 'cancelada' ? 'selected' : '' }}>
                            Cancelada
                        </option>
                    </select>
                </div>

                <!-- Fecha inciio -->
                <div class="col-md-3">
                    <label>Desde</label>
                    <input type="date" 
                        name="inicio" 
                        class="form-control"
                        value="{{ request('inicio') }}">
                </div>

                <!-- Fecha fin -->
                <div class="col-md-3">
                    <label>Hasta</label>
                    <input type="date" 
                        name="fin" 
                        class="form-control"
                        value="{{ request('fin') }}">
                </div>

                <!-- Boton fil -->
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary w-100">
                        Filtrar
                    </button>
                </div>
            </div>
        </form><hr>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabla de reservas -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Vehículo</th>
                    <th>Fechas</th>
                    <th>Días</th>
                    <th>Ubicación</th>
                    <th>Total</th>
                    <th>Estado - Actualizar</th>
                    <th>Detalles</th>
                </tr>
            </thead>

            <tbody>
                @foreach($reservas as $r)

                <tr>
                    <!-- Vehiculo -->
                    <td>
                        {{ $r->vehiculo->marca->nombre }} - 
                        {{ $r->vehiculo->modelo->nombre }}
                    </td>
                    <!-- Fechas -->
                    <td style="text-align: center;">
                        {{ $r->fecha_inicio }} <br> 
                        {{ $r->fecha_fin }}
                    </td>
                    @php
                        $inicio = \Carbon\Carbon::parse($r->fecha_inicio);
                        $fin = \Carbon\Carbon::parse($r->fecha_fin);
                        $dias = $inicio->diffInDays($fin) + 1;
                    @endphp
                    <!-- Dias -->
                    <td style="text-align: center;">{{ $dias }}</td>
                    <!-- Ubicacion -->
                    <td>
                        {{ $r->vehiculo->ubicacion }}
                    </td>
                    <!-- Total -->
                    @php
                        $inicio = \Carbon\Carbon::parse($r->fecha_inicio);
                        $fin = \Carbon\Carbon::parse($r->fecha_fin);
                        $dias = $inicio->diffInDays($fin) + 1;

                        $tarifa = $r->vehiculo->tarifa_diaria;
                        $total = $dias * $tarifa;
                    @endphp
                    <td>
                        <small>
                            {{ $dias }} días x ${{ number_format($tarifa) }}
                        </small>
                        <br>
                        <span class="fw-bold text-success">
                            = ${{ number_format($total) }}
                        </span>
                    </td>
                    <!-- Estado - actualizat -->
                    <td>
                        <form method="POST" action="{{ route('reservas.update', $r->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="d-flex gap-2">
                                
                                <select name="estado" 
                                    class="form-select form-select-sm select-estado 
                                    {{ 
                                        $r->estado == 'pendiente' ? 'warning' : 
                                        ($r->estado == 'confirmada' ? 'primary' : 
                                        ($r->estado == 'pagada' ? 'success' : 'danger')) 
                                    }}">
                                    <option {{ $r->estado=='pendiente'?'selected':'' }}>Pendiente</option>
                                    <option {{ $r->estado=='confirmada'?'selected':'' }}>Confirmada</option>
                                    <option {{ $r->estado=='pagada'?'selected':'' }}>Pagada</option>
                                    <option {{ $r->estado=='cancelada'?'selected':'' }}>Cancelada</option>
                                </select>                   
                                <button type="button" class="btn btn-update btn-primary">
                                    <i class="bi bi-check-square"></i>
                                </button>
                            </div>
                        </form>
                    </td>
                    <!-- Detalles -->
                    <td class="text-center">
                        <a href="{{ route('admin.reservas.ver', $r->id) }}" 
                            class="btn btn-sm btn-outline-info rounded-circle btn-action"
                            title="Ver detalle">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td> 
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Mensajes de alerta-->
<script>
    document.querySelectorAll('.btn-update').forEach((btn) => {
        btn.addEventListener('click', function () {
            let form = this.closest('form');
            Swal.fire({
                title: '¿Actualizar estado?',
                text: "Se cambiará el estado de la reserva",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0d6efd',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, actualizar',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>

@endsection