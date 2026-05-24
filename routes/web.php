<?php

use Illuminate\Support\Facades\Route;
use App\Models\Modelo;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\ReservaController;

/*
|--------------------------------------------------------------------------
| 🌐 RUTAS PÚBLICAS (CLIENTE)
|--------------------------------------------------------------------------
*/

Route::get('/', [VehiculoController::class, 'home']);

Route::get('/vehiculos', [VehiculoController::class, 'catalogo']);
Route::get('/vehiculo/{id}', [VehiculoController::class, 'showCliente']);

Route::get('/vehiculos/buscar', [ReservaController::class, 'buscar']);

/*
|--------------------------------------------------------------------------
| 🔄 AJAX (DEPENDIENTES)
|--------------------------------------------------------------------------
*/

// Modelos por marca
Route::get('/modelos/{marca_id}', function($marca_id) {
    return \App\Models\Modelo::where('marca_id', $marca_id)->get();
});

// Tipo desde modelo
Route::get('/tipo/{modelo_id}', function($modelo_id) {

    $modelo = \App\Models\Modelo::with('tipo')->find($modelo_id);

    return response()->json([
        'tipo_id' => $modelo->tipo_id,
        'tipo_nombre' => $modelo->tipo->tipo
    ]);

});

/*
|--------------------------------------------------------------------------
| 🔐 AUTENTICACIÓN (BREEZE)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| 👤 RUTAS CLIENTE (PROTEGIDAS)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Reservas
    Route::get('/reservar', [ReservaController::class, 'create']);
    Route::post('/reservar', [ReservaController::class, 'store']);

    Route::get('/cliente/reservas', [ReservaController::class, 'misReservas'])
        ->name('cliente.reservas');

    // Pagos
    Route::post('/reservas/pagar/{id}', [ReservaController::class, 'pagar'])
        ->name('reservas.pagar');

    // Contrato
    Route::get('/contrato/{id}', [ReservaController::class, 'contrato'])
        ->name('reservas.contrato');

});

/*
|--------------------------------------------------------------------------
| 🛠 ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware('auth')->group(function () {

    // Dashboard
    Route::get('/', [AdminController::class, 'index']);
    Route::get('/dashboard', [ReservaController::class, 'dashboard'])
        ->name('dashboard');

    // Vehículos CRUD
    Route::resource('/vehiculos', VehiculoController::class);

    // Eliminar imágenes
    Route::delete('/imagenes/{id}', [VehiculoController::class, 'eliminarImagen'])
        ->name('imagenes.delete');

    // Reservas
    Route::get('/reservas', [ReservaController::class, 'index']);
    Route::get('/reservas/nueva', [ReservaController::class, 'createAdmin']);
    Route::get('/reservar', [ReservaController::class, 'reservarAdmin']);

    // Actualizar estado
    Route::put('/reservas/{id}', [ReservaController::class, 'update'])
        ->name('reservas.update');

    Route::get('/clientes', [AdminController::class, 'clientes'])
        ->name('admin.clientes');
   
    Route::get('/clientes/{id}', [AdminController::class, 'clienteDetalle'])
        ->name('admin.clientes.detalle');

    Route::prefix('admin')->group(function () {
        Route::get('/reportes', [AdminController::class, 'reportes'])
            ->name('admin.reportes');
    });
    
    Route::get('/admin/reportes/excel', [AdminController::class, 'exportExcel'])
        ->name('admin.reportes.excel');

    Route::get('/admin/reportes/pdf', [AdminController::class, 'exportPdf'])
        ->name('admin.reportes.pdf');

});