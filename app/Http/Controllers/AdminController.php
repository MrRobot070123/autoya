<?php

namespace App\Http\Controllers;
use App\Models\User;

class AdminController extends Controller
{
    public function clientes()
    {
        $clientes = User::withCount('reservas')->get();

        return view('admin.clientes.index', compact('clientes'));
    }

    public function clienteDetalle($id)
    {
        $cliente = User::with([
            'reservas.vehiculo.marca',
            'reservas.vehiculo.modelo'
        ])->findOrFail($id);

        return view('admin.clientes.detalle', compact('cliente'));
    }

}