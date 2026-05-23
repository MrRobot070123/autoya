@extends('layouts.admin')

@section('content')

<div class="container"> 
    <div class="container" style="max-width: 950px;">
        <h2>Reservas</h2><hr>

        <form method="GET" class="mb-3">
            <div class="row">
                <!-- ESTADO -->
                <div class="col-md-4">
                    <label>Estado</label>
                    <select name="estado" class="form-control">
                        <option value="">Todos</option>
                        <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>
                            Pendiente
                        </option>
                        <option value="confirmada" {{ request('estado') == 'confirmada' ? 'selected' : '' }}>
                            Confirmada
                        </option>
                        <option value="cancelada" {{ request('estado') == 'cancelada' ? 'selected' : '' }}>
                            Cancelada
                        </option>
                    </select>
                </div>

                <!-- FECHA INICIO -->
                <div class="col-md-3">
                    <label>Desde</label>
                    <input type="date" 
                        name="inicio" 
                        class="form-control"
                        value="{{ request('inicio') }}">
                </div>

                <!-- FECHA FIN -->
                <div class="col-md-3">
                    <label>Hasta</label>
                    <input type="date" 
                        name="fin" 
                        class="form-control"
                        value="{{ request('fin') }}">
                </div>

                <!-- BOTÓN -->
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

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Vehículo</th>
                    <th>Fechas</th>
                    <th>Días</th>
                    <th>Ubicación</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Cambiar estado</th>
                </tr>
            </thead>

            <tbody>
                @foreach($reservas as $r)

                <tr>
                    <td>
                        {{ $r->vehiculo->marca->nombre }} - 
                        {{ $r->vehiculo->modelo->nombre }}
                    </td>

                    <td style="text-align: center;">
                        {{ $r->fecha_inicio }} <br> 
                        {{ $r->fecha_fin }}
                    </td>

                    @php
                        $inicio = \Carbon\Carbon::parse($r->fecha_inicio);
                        $fin = \Carbon\Carbon::parse($r->fecha_fin);
                        $dias = $inicio->diffInDays($fin) + 1;
                    @endphp

                    <td style="text-align: center;">{{ $dias }}</td>

                    <td>
                        {{ $r->vehiculo->ubicacion }}
                    </td>
                    
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

                    <td style="text-align: center;">                        
                        <span class="badge {{ $r->color_estado }}">
                            {{ ucfirst($r->estado) }}
                        </span>
                    </td>

                    <!-- FORM CAMBIO DE ESTADO -->
                    <td>

                        @if($r->estado == 'pagada'|| $r->estado == 'cancelada')

                            <select class="form-control" disabled>
                                <option>{{ ucfirst($r->estado) }}</option>
                            </select>

                            <button class="btn btn-secondary mt-1 w-100" disabled>
                                Bloqueado
                            </button>

                        @else

                            <form method="POST" action="{{ route('reservas.update', $r->id) }}">
                                @csrf
                                @method('PUT')

                                <select name="estado" class="form-control">
                                    <option>{{ ucfirst($r->estado) }}</option>
                                    @if($r->estado == 'pendiente')
                                        <option value="confirmada">Confirmada</option>
                                        <option value="cancelada">Cancelada</option>
                                    @elseif($r->estado == 'confirmada')
                                        <option value="pendiente">Pendiente</option>
                                        <option value="cancelada">Cancelada</option>
                                    @endif
                                </select>

                                <button class="btn btn-primary mt-1 w-100">
                                    Actualizar
                                </button>
                            </form>

                        @endif
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