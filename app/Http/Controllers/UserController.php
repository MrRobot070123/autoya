<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function createAdmin()
    {
        return view('admin.clientes.crear');
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'cedula' => 'required|unique:users',
            'nombre' => 'required',
            'email' => 'required|email|unique:users',
            'telefono' => 'required',
            'password' => 'required|min:6|confirmed',
            'rol' => 'required|in:cliente,admin'
        ]);

        User::create([
            'cedula' => $request->cedula,
            'nombre' => $request->nombre,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'password' => Hash::make($request->password),
            'rol' => $request->rol
        ]);

        return redirect()
            ->route('admin.clientes')
            ->with('success', 'Usuario creado correctamente');
    }
}
