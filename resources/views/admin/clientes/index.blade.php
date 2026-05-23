@extends('layouts.admin')

@section('content')

<div class="container mt-4">

    <h3 class="mb-4">Clientes</h3>

    <div class="card p-3">

        <table class="table table-bordered">

            <thead>
                <tr>
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>N° Reservas</th>
                </tr>
            </thead>

            <tbody>

                @foreach($clientes as $c)
                <tr>

                    <td>{{ $c->cedula }}</td>
                 
                    <td>
                        <a href="{{ route('admin.clientes.detalle', $c->id) }}">
                            {{ $c->nombre }}
                        </a>
                    </td>

                    <td>{{ $c->email }}</td>

                    <td>{{ $c->telefono }}</td>

                    <td>
                        <span class="badge bg-primary">
                            {{ $c->reservas_count }}
                        </span>
                    </td>

                </tr>
                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection