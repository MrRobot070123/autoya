<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Vehiculo;
use App\Models\VehiculoImagen;
use App\Models\Marca;
use App\Models\Tipo;


class VehiculoController extends Controller
{
    // FILTRO POR ESTADO, CARGA RELACIONES ENTRE MARCA Y MODELO Y EVITA CONSULTAS EXTRA
    public function index(Request $request)
    {
        $vehiculos = Vehiculo::with(['marca','modelo'])
            ->when($request->estado, function($query) use ($request) {
                $query->where('estado', $request->estado);
            })
            ->get();

        return view('admin.vehiculos.index', compact('vehiculos'));
    }

    //CREA VEHICULO
    public function create()
    {
        $marcas = Marca::all();

        return view('admin.vehiculos.create', compact('marcas'));
    }

    //ENVIO A LA BASE DE DATOS    
    public function store(Request $request)
    {
        // VALIDACIÓN
        $request->validate([
            'placa' => 'required|unique:vehiculos,placa|max:10',
            'marca_id' => 'required',
            'modelo_id' => 'required',
            'tipo_id' => 'required',
            'anio' => 'required',
            'tarifa_diaria' => 'required|numeric|min:1',
            'ubicacion' => 'required',            
            'imagenes' => 'required|array|max:5',
            'imagenes.*' => 'image|mimes:jpg,jpeg,png|max:2048'

        ],[
            'imagenes.required' => 'Debe subir al menos una imagen',
            'imagenes.max' => 'Máximo 5 imágenes',
            'imagenes.*.image' => 'Cada archivo debe ser una imagen válida',
            'imagenes.*.mimes' => 'Solo se permiten JPG, PNG o JPEG',
        ]);

        // CREAR VEHICULO
        $vehiculo = Vehiculo::create([
            'placa' => $request->placa,
            'marca_id' => $request->marca_id,
            'modelo_id' => $request->modelo_id,
            'tipo_id' => $request->tipo_id,
            'anio' => $request->anio,
            'tarifa_diaria' => $request->tarifa_diaria,
            'ubicacion' => $request->ubicacion,
            'estado' => 'activo'
        ]);

        // VALIDAR MAX 5
        if (count($request->file('imagenes')) > 5) {
            return back()->withErrors(['imagenes' => 'Máximo 5 imágenes']);
        }

        // GUARDAR IMÁGENES
        foreach ($request->file('imagenes') as $imagen) {

            $ruta = $imagen->store('vehiculos', 'public');

            VehiculoImagen::create([
                'vehiculo_id' => $vehiculo->id,
                'ruta' => $ruta
            ]);
        }

        return redirect()->route('vehiculos.index')
            ->with('success', 'Vehículo creado');
    }

    //EDITAR VEHICULO VISTA
    public function edit($id)
    {
        $vehiculo = Vehiculo::findOrFail($id);
        $marcas = Marca::all();

        return view('admin.vehiculos.edit', compact('vehiculo', 'marcas'));
    }

    //ACTUALIZAR VEHICULO    
    public function update(Request $request, $id)
    {
        $vehiculo = Vehiculo::findOrFail($id);

        // VALIDACION DEE BAJA DE VEHÍCULO
        if ($request->estado == 'inactivo' || $request->estado == 'matto' ) {
            $tieneReservas = $vehiculo->reservas()
                ->whereIn('estado', ['pendiente','confirmada'])
                ->exists();

            if ($tieneReservas) {
                if ($request->estado == 'inactivo'){
                    return redirect()->back()
                        ->withErrors([
                            'error' => 'No puedes inactivar este vehículo porque tiene reservas activas'
                        ]);
                }
                return redirect()->back()
                        ->withErrors([
                            'error' => 'No puedes colocar este vehículo en mantinimiento porque tiene reservas activas'
                        ]);
            }
        }

        $vehiculo->update([
            'marca_id' => $request->marca_id,
            'modelo_id' => $request->modelo_id,
            'tipo' => $request->tipo,
            'anio' => $request->anio,
            'tarifa_diaria' => $request->tarifa_diaria,
            'ubicacion' => $request->ubicacion,
            'estado' => $request->estado
        ]);

        // AGREGAR NUEVAS IMÁGENES
        if ($request->hasFile('imagenes')) {

            // validar máximo 5 TOTAL
            $total = $vehiculo->imagenes->count() + count($request->file('imagenes'));

            if ($total > 5) {
                return back()->withErrors([
                    'imagenes' => 'Máximo 5 imágenes en total'
                ]);
            }

            foreach ($request->file('imagenes') as $imagen) {

                $ruta = $imagen->store('vehiculos', 'public');

                \App\Models\VehiculoImagen::create([
                    'vehiculo_id' => $vehiculo->id,
                    'ruta' => $ruta
                ]);
            }
        }

        return redirect()->route('vehiculos.index')->with('success', 'Vehículo actualizado');
    }

    //MOSTRAR DETALLES DEL VEHICULO
    public function show($id)
    {
        $vehiculo = Vehiculo::with(['marca','modelo','imagenes'])->findOrFail($id);

        return view('admin.vehiculos.show', compact('vehiculo'));
    }

    public function showCliente($id)
    {
        $vehiculo = Vehiculo::with(['marca','modelo','imagenes'])->findOrFail($id);

        return view('cliente.detalle', compact('vehiculo'));
    }


    //ELIMINAR IMAGENES DE GALERIA    
    public function eliminarImagen($id)
    {
        $imagen = \App\Models\VehiculoImagen::findOrFail($id);

        // eliminar archivo físico
        \Storage::disk('public')->delete($imagen->ruta);

        // eliminar registro BD
        $imagen->delete();

        return back()->with('success', 'Imagen eliminada');
    }

    //CATALOGO DE VEHICULOS
    public function catalogo(Request $request)
    {
        $query = Vehiculo::with(['marca','modelo','imagenes'])
            ->where('estado','activo');

        if ($request->ubicacion) {
            $query->where('ubicacion', $request->ubicacion);
        }

        if ($request->precio) {
            $query->where('tarifa_diaria', '<=', $request->precio);
        }

        if ($request->marca) {
            $query->where('marca_id', $request->marca);
        }

        if ($request->tipo) {
            $query->where('tipo_id', $request->tipo);
        }

        $vehiculos = $query->get();

        $ciudades = Vehiculo::select('ubicacion')
            ->distinct()
            ->pluck('ubicacion');

        $marcas = Marca::all();
        $tipos = Tipo::all();

        return view('cliente.vehiculos', compact(
            'vehiculos',
            'ciudades',
            'marcas',
            'tipos'
        ));
    }

    //INICIO
    public function home()
    {
        $vehiculos = Vehiculo::with(['marca','modelo','imagenes'])
            ->where('estado','activo')
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('cliente.home', compact('vehiculos'));
    }

}
