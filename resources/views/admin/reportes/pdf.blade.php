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

<div style="margin-top:20px; text-align:right;">
    <strong>Total generado:</strong>
    ${{ number_format($totalGeneral) }}
</div>

<p style="text-align:center; margin-top:30px; font-size:12px;">
    © {{ date('Y') }} AutoYa - Sistema de Alquiler
</p>
