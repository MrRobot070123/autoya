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
        $totalVehiculos = Vehiculo::count();

        if (!empty($request->inicio) && !empty($request->fin)) {


            $inicio = Carbon::parse($request->inicio);
            $fin = Carbon::parse($request->fin);

            $vehiculosOcupados = Reserva::whereIn('estado', ['confirmada','pagada'])
                ->whereDate('fecha_inicio', '>=', $inicio)
                ->whereDate('fecha_fin', '<=', $fin)
                ->distinct('vehiculo_id')
                ->count();

            $estados = Reserva::whereIn('estado', ['confirmada','pagada','pendiente'])
                ->whereDate('fecha_inicio', '>=', $inicio)
                ->whereDate('fecha_fin', '<=', $fin)
                ->select('estado', \DB::raw('count(*) as total'))
                ->groupBy('estado')
                ->get();

            $ingresos = Reserva::where('estado', 'pagada')
                ->whereDate('fecha_inicio', '>=', $inicio)
                ->whereDate('fecha_fin', '<=', $fin)
                ->sum('precio_total');

        } else {

            $vehiculosOcupados = 0;
            $ingresos = 0;
            $estados = collect();

            $inicio = null;
            $fin = null;
        }

        $disponibles = $totalVehiculos - $vehiculosOcupados;

        $ocupacion = $totalVehiculos > 0 
            ? ($vehiculosOcupados / $totalVehiculos) * 100 
            : 0;

        return view('admin.reportes.index', compact(
            'totalVehiculos',
            'vehiculosOcupados',
            'disponibles',
            'ocupacion',
            'ingresos',
            'inicio',
            'fin',
            'estados'
        ));
    }
    
    public function exportPdf(Request $request)
    {
        if (!empty($request->inicio) && !empty($request->fin)) {

            $inicio = Carbon::parse($request->inicio);
            $fin = Carbon::parse($request->fin);

            $reservas = Reserva::with('user','vehiculo')
                ->whereDate('fecha_inicio', '>=', $inicio)
                ->whereDate('fecha_fin', '<=', $fin)
                ->get();

            $totales = Reserva::whereDate('fecha_inicio', '>=', $inicio)
                ->whereDate('fecha_fin', '<=', $fin)
                ->select('estado', \DB::raw('SUM(precio_total) as total'))
                ->groupBy('estado')
                ->get();

        } else {

            $reservas = collect();
            $totales = collect();
            $inicio = null;
            $fin = null;
        }

        $pdf = Pdf::loadView('admin.reportes.pdf', compact(
            'reservas',
            'totales',
            'inicio',
            'fin'
        ));

        return $pdf->download('reporte.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new ReservasExport($request->inicio, $request->fin),
            'reservas.xlsx'
        );
    }

}