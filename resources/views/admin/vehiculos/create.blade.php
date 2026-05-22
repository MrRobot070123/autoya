@extends('layouts.admin')

@section('content')

<!--Mensaje de envio exitoso-->
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<!--Mensaje de error de envio-->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<h2>Crear Vehículo</h2>

<form action="{{ route('vehiculos.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <!-- PLACA -->
    <label>Placa</label> 
    <input name="placa" class="form-control mb-2" required>

    <!-- MARCA -->
    <label>Marca</label>
    <select id="marca" name="marca_id" class="form-control mb-2">
        <option value="">Seleccione marca</option>

        @foreach($marcas as $marca)
            <option value="{{ $marca->id }}">
                {{ $marca->nombre }}
            </option>
        @endforeach
    </select>

    <!-- MODELO -->
    <label>Modelo</label>
    <select id="modelo" name="modelo_id" class="form-control mb-2">
    </select>

    <!-- TIPO -->
    <label>Tipo</label>
    <input id="tipo" class="form-control mb-2" readonly>
    <input type="hidden" id="tipo_id" name="tipo_id">


    <!-- AÑO -->
    <label>Año</label>
    <select name="anio" class="form-control mb-2">
        @for($i = 2006; $i <= 2027; $i++)
            <option value="{{ $i }}">{{ $i }}</option>
        @endfor
    </select>

    <!-- TARIFA -->
    <label>Tarifa diaria</label>
    <input name="tarifa_diaria" class="form-control mb-2" required>

    <!-- UBICACIÓN -->
    <label>Ubicación</label>
    <select name="ubicacion" class="form-control mb-2">
        <option>Barranquilla</option>
        <option>Bogotá</option>
        <option>Medellín</option>
        <option>Cali</option>
        <option>Bucaramanga</option>
    </select>

    <!-- IMAGENES -->
    <label>Imágenes (máx 5)</label>
    <input type="file" name="imagenes[]" multiple class="form-control mb-2" required>
    
    <button class="btn btn-success">Guardar</button>
</form>

<script>
    //Modelo
    document.getElementById('marca').addEventListener('change', function () {
        let marcaId = this.value;
        fetch('/modelos/' + marcaId)
            .then(res => res.json())
            .then(data => {
                let modeloSelect = document.getElementById('modelo');
                modeloSelect.innerHTML = '';

                data.forEach(modelo => {
                    let option = document.createElement('option');
                    option.value = modelo.id;
                    option.text = modelo.nombre;
                    modeloSelect.add(option);
                });
            });
    });
    
    //Tipo
    document.getElementById('modelo').addEventListener('change', function () {
        let modeloId = this.value;
        
        fetch('/tipo/' + modeloId)
            .then(res => res.json())
            .then(data => {
                document.getElementById('tipo').value = data.tipo_nombre;
                document.getElementById('tipo_id').value = data.tipo_id;
            });

    });
</script>

@endsection