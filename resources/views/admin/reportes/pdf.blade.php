<div style="text-align:center; margin-bottom:20px;">
    <img src="{{ public_path('img/logo.png') }}" width="120">
</div>


<h2 style="text-align:center; margin-bottom:5px;">
    Reporte de Reservas
</h2>

<p style="text-align:center; font-size:12px;">
    Fecha: {{ date('d/m/Y') }}
</p>

<table width="100%" cellspacing="0" cellpadding="6" style="border-collapse: collapse;">

    <thead style="background:#04143A; color:white;">
        <tr>
            <th>Cédula</th>
            <th>Cliente</th>
            <th>Email</th>
            <th>Vehículo</th>
            <th>Fechas</th>
            <th>Total</th>
            <th>Estado</th>
        </tr>
    </thead>

    <tbody>

        @php $totalGeneral = 0; @endphp

        @foreach($reservas as $r)

            @php $totalGeneral += $r->precio_total; @endphp

            <tr style="border-bottom:1px solid #ddd;">

                <td>{{ $r->user->cedula ?? '' }}</td>

                <td>{{ $r->user->nombre ?? '' }}</td>

                <td>{{ $r->user->email ?? '' }}</td>

                <td>{{ $r->vehiculo_id }}</td>

                <td>
                    {{ $r->fecha_inicio }}<br>
                    {{ $r->fecha_fin }}
                </td>

                <td>
                    ${{ number_format($r->precio_total) }}
                </td>

                <td>
                    {{ ucfirst($r->estado) }}
                </td>

            </tr>

        @endforeach

    </tbody>

</table>

<h3 style="margin-top:20px;">Totales por estado</h3>

<table width="70%" border="1" cellspacing="0" cellpadding="5">
    <thead style="background:#04143A; color:white;">
        <tr>
            <th>Estado</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($totales as $t)
        <tr>
            <td>{{ ucfirst($t->estado) }}</td>
            <td>${{ number_format($t->total) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<p style="text-align:center; margin-top:30px; font-size:12px;">
    © {{ date('Y') }} AutoYa
</p>
