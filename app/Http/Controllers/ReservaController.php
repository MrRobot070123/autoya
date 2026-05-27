<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehiculo;
use App\Models\Reserva;
use App\Models\Pago;
use Carbon\Carbon;
use App\Models\User;

class ReservaController extends Controller
{

    private function conflictoReserva($inicio, $fin)
    {
        return function($q) use ($inicio, $fin) {

            $q->whereBetween('fecha_inicio', [$inicio, $fin])
              ->orWhereBetween('fecha_fin', [$inicio, $fin])
              ->orWhere(function($q2) use ($inicio, $fin){
                  $q2->where('fecha_inicio','<=',$inicio)
                     ->where('fecha_fin','>=',$fin);
              });

        };
    }

    private function disponible($vehiculo_id, $inicio, $fin)
    {
        return !Reserva::where('vehiculo_id', $vehiculo_id)
            ->whereIn('estado', ['pendiente','confirmada'])
            ->where($this->conflictoReserva($inicio,$fin))
            ->exists();
    }

    private function vehiculosDisponibles($inicio, $fin)
    {
        return Vehiculo::where('estado','activo')
            ->whereDoesntHave('reservas', function($q) use ($inicio,$fin){

                $q->whereIn('estado',['pendiente','confirmada'])
                  ->where($this->conflictoReserva($inicio,$fin));

            })
            ->with(['marca','modelo'])
            ->get();
    }

    public function buscar(Request $request)
    {
        if (!$request->filled(['inicio','fin'])) {
            return view('cliente.busqueda');
        }

        $vehiculos = $this->vehiculosDisponibles(
            $request->inicio,
            $request->fin
        );

        return view('cliente.busqueda', compact('vehiculos'));
    }

    public function create(Request $request)
    {
        $vehiculo = Vehiculo::with(['marca','modelo'])
            ->findOrFail($request->vehiculo);

        return view('cliente.reservar', [
            'vehiculo' => $vehiculo,
            'inicio' => $request->inicio,
            'fin' => $request->fin
        ]);
    }

    public function createAdmin(Request $request)
    {
        if (!$request->filled(['inicio','fin'])) {
            return view('admin.reservas.buscar');
        }

        $vehiculos = $this->vehiculosDisponibles(
            $request->inicio,
            $request->fin
        );

        return view('admin.reservas.buscar', compact('vehiculos'));
    }

    public function reservarAdmin(Request $request)
    {
        $vehiculo = Vehiculo::with(['marca','modelo','imagenes'])
            ->findOrFail($request->vehiculo);

        $clientes = User::all();

        return view('admin.reservas.reservar', [
            'vehiculo' => $vehiculo,
            'inicio' => $request->inicio,
            'fin' => $request->fin,
            'clientes' => $clientes
        ]);
    }

    public function store(Request $request)
    {

        $rules = [
            'vehiculo_id' => 'required|exists:vehiculos,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio'
        ];

        if ($request->origen == 'admin') {
            $rules['user_id'] = 'required|exists:users,id';
        }

        $request->validate($rules);

        if (!$this->disponible(
            $request->vehiculo_id,
            $request->fecha_inicio,
            $request->fecha_fin
        )) {
            return back()->withErrors([
                'error'=>'Vehículo no disponible'
            ]);
        }

        $vehiculo = Vehiculo::findOrFail($request->vehiculo_id);

        $dias = Carbon::parse($request->fecha_inicio)
            ->diffInDays($request->fecha_fin) + 1;
        
        $total = $dias * $vehiculo->tarifa_diaria;
        
        if ($request->origen == 'admin') {

            $cliente = User::findOrFail($request->user_id);

        } else {

            $cliente = auth()->user();
        }

        Reserva::create([
            'vehiculo_id' => $request->vehiculo_id,
            'user_id' => $cliente->id,
            'cedula' => $cliente->cedula,
            'nombre' => $cliente->nombre,
            'email' => $cliente->email,
            'telefono' => $cliente->telefono,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'precio_total' => $total,
            'estado' => 'pendiente',
        ]);

        return $this->redirectAfterSave($request);
    }

    private function redirectAfterSave($request)
    {
        if ($request->origen == 'admin') {
            return redirect('/admin/reservas')
                ->with('success','Reserva creada correctamente');
        }

        return redirect('/vehiculos/buscar')
            ->with('success','Reserva creada correctamente');
    }

    public function update(Request $request, $id)
    {
        $reserva = Reserva::findOrFail($id);

        if ($reserva->estado == 'pagada') {
            return back()->withErrors(
                ['error' => 'No se puede modificar una reserva pagada']
            );
        }

        $reserva->update([
            'estado' => $request->estado
        ]);

        return back()->with('success', 'Estado actualizado');
    }

    public function index(Request $request)
    {
        $query = Reserva::with(['vehiculo.marca','vehiculo.modelo']);

        if ($request->estado) {
            $query->where('estado', $request->estado);
        }

        if ($request->inicio) {
            $query->whereDate('fecha_inicio', '>=', $request->inicio);
        }

        if ($request->fin) {
            $query->whereDate('fecha_fin', '<=', $request->fin);
        }

        if ($request->inicio && $request->fin) {
            $query->whereDate('fecha_inicio', '>=', $request->inicio)
                ->whereDate('fecha_fin', '<=', $request->fin);
        }
        
        $reservas = $query->orderBy('created_at', 'desc')->get();

        return view('admin.reservas.index', compact('reservas'));
    }

    public function misReservas()
    {
        
        if (!auth()->check()) {
            return redirect('/login')
                ->with('error','Debes iniciar sesión para reservar');
        }

        $reservas = Reserva::with(['vehiculo.marca','vehiculo.modelo'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
          
        $total = $reservas->count();
        $pendientes = $reservas->where('estado','pendiente')->count();
        $confirmadas = $reservas->where('estado','confirmada')->count();
        $pagadas = $reservas->where('estado','pagada')->count();

        return view('cliente.reservas', compact(
                'reservas',
                'total',
                'pendientes',
                'confirmadas',
                'pagadas'
        ));

    }

    public function pagar($id)
    {
        $reserva = Reserva::findOrFail($id);

        $reserva->update([
            'estado' => 'pagada'
        ]);

        $reserva->update([
            'numero_contrato' => 'CTR-'.time()
        ]);

        Pago::create([
            'reserva_id' => $reserva->id,
            'numero_pago' => 'PAY-' . now()->format('Ymd') . '-' . $reserva->id,
            'monto' => $reserva->precio_total,
            'estado' => 'pagado',
        ]);

        return back()->with('success','Pago realizado');
    }
    
    public function contrato($id)
    {
        $reserva = Reserva::with('pago','vehiculo')->findOrFail($id);

        return view('cliente.contrato', compact('reserva'));
    }

    public function dashboard()
    {
        $totalReservas = Reserva::count();

        $ingresos = Reserva::where('estado','pagada')
            ->sum('precio_total');
        
        $reservas_hoy = Reserva::whereDate('created_at', now())->count();
        
        $inicioMes = Carbon::now()->startOfMonth();
        $finMes = Carbon::now()->endOfMonth();
        $ingresos_mes = Reserva::where('estado', 'pagada')
            ->where(function($q) use ($inicioMes, $finMes) {
                $q->where('fecha_inicio', '<=', $finMes)
                ->where('fecha_fin', '>=', $inicioMes);
            })
            ->sum('precio_total');

        $pagadas = Reserva::where('estado','pagada')->count();
        $confirmadas = Reserva::where('estado','confirmada')->count();
        $pendientes = Reserva::where('estado','pendiente')->count();
        $canceladas = Reserva::where('estado','cancelada')->count();

        $activos = Vehiculo::where('estado','activo')->count();
        $inactivos = Vehiculo::where('estado','inactivo')->count();
        $mantenimiento = Vehiculo::where('estado','matto')->count();

        $marcas = Vehiculo::selectRaw('marca_id, count(*) as total')
            ->groupBy('marca_id')
            ->with('marca')
            ->get();

        return view('admin.dashboard', compact(
            'totalReservas',
            'ingresos',     
            'reservas_hoy',
            'ingresos_mes',
            'pagadas',
            'confirmadas',
            'pendientes',
            'canceladas',
            'activos',
            'inactivos',
            'mantenimiento',
            'marcas'
        ));
    }

}