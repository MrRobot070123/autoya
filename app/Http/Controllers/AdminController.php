<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vehiculo;
use App\Models\Reserva;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\ReservasExport;
use Maatwebsite\Excel\Facades\Excel;

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

    public function verReserva($id)
    {
        $reserva = Reserva::with([
            'vehiculo.marca',
            'vehiculo.modelo',
            'vehiculo.tipo',
            'vehiculo.imagenes',
            'pago',
            'user'
        ])->findOrFail($id);

        return view('admin.reservas.detalle', compact('reserva'));
    }


    public function reportes(Request $request)
    {
        // Ocupacion
        $totalVehiculos = Vehiculo::count();

        $vehiculosOcupados = Reserva::whereIn('estado', ['confirmada','pagada'])
            ->distinct('vehiculo_id')
            ->count();

        $disponibles = $totalVehiculos - $vehiculosOcupados;

        $ocupacion = $totalVehiculos > 0 
            ? ($vehiculosOcupados / $totalVehiculos) * 100 
            : 0;

        // Financiero con ingresis por peiorodo
        $periodo = $request->periodo ?? 'mes';

        $query = Reserva::where('estado','pagada');

        if ($periodo == 'dia') {
            $query->whereDate('created_at', today());
        }

        if ($periodo == 'mes') {
            $query->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year);
        }

        if ($periodo == 'anio') {
            $query->whereYear('created_at', now()->year);
        }

        $ingresos = $query->sum('precio_total');

        return view('admin.reportes.index', compact(
            'totalVehiculos',
            'vehiculosOcupados',
            'disponibles',
            'ocupacion',
            'ingresos',
            'periodo'
        ));
    }

    public function exportPdf()
    {
        $reservas = Reserva::with('user')->get();

        $pdf = Pdf::loadView('admin.reportes.pdf', compact('reservas'));

        return $pdf->download('reporte.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new ReservasExport, 'reservas.xlsx');
    }


}