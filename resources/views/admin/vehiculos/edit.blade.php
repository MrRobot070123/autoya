@extends('layouts.admin')

@section('content')

<h2>Editar Vehículo</h2>

<div class="row mb-3">
    @foreach($vehiculo->imagenes as $img)
        <div class="col-md-3 text-center">

            <img src="{{ asset('storage/'.$img->ruta) }}"
                class="img-fluid rounded mb-1"
                style="height:120px; width:100%; object-fit:cover;">

            <!-- ESTE FORM SE QUEDA SEPARADO -->
            <form action="{{ route('imagenes.delete', $img->id) }}" method="POST">
                @csrf
                @method('DELETE')                         
                <button type="button" class="btn btn-danger btn-sm btn-eliminar">
                    Eliminar
                </button>
            </form>
        </div>
    @endforeach
</div>

<form action="{{ route('vehiculos.update', $vehiculo->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- PLACA -->
    <div class="mb-2">
        <label>Placa</label>
        <input name="placa" value="{{ $vehiculo->placa }}" class="form-control" readonly>
    </div>

    <!-- MARCA -->
    <div class="mb-2">
        <label>Marca</label>
        <select id="marca" name="marca_id" class="form-control">
            @foreach($marcas as $marca)
                <option value="{{ $marca->id }}"
                    {{ $vehiculo->marca_id == $marca->id ? 'selected' : '' }}>
                    {{ $marca->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- MODELO -->
    <div class="mb-2">
        <label>Modelo</label>
        <select id="modelo" name="modelo_id" class="form-control"></select>
    </div>

    <!-- TIPO -->
    <div class="mb-2">
        <label>Tipo</label>
        <input id="tipo" class="form-control mb-2" readonly>
        <input type="hidden" id="tipo_id" name="tipo_id">
    </div>

    <!-- AÑO -->
    <div class="mb-2">
        <label>Año</label>
        <select name="anio" class="form-control">
            @for($i = 2006; $i <= 2027; $i++)
                <option value="{{ $i }}"
                    {{ $vehiculo->anio == $i ? 'selected' : '' }}>
                    {{ $i }}
                </option>
            @endfor
        </select>
    </div>

    <!-- TARIFA -->
    <div class="mb-2">
        <label>Tarifa</label>
        <input name="tarifa_diaria" value="{{ $vehiculo->tarifa_diaria }}" class="form-control">
    </div>

    <!-- UBICACIÓN -->
    <div class="mb-2">
        <label>Ubicación</label>
        <select name="ubicacion" class="form-control">
            <option {{ $vehiculo->ubicacion == 'Barranquilla' ? 'selected' : '' }}>Barranquilla</option>
            <option {{ $vehiculo->ubicacion == 'Bogotá' ? 'selected' : '' }}>Bogotá</option>
            <option {{ $vehiculo->ubicacion == 'Medellín' ? 'selected' : '' }}>Medellín</option>
            <option {{ $vehiculo->ubicacion == 'Cali' ? 'selected' : '' }}>Cali</option>
            <option {{ $vehiculo->ubicacion == 'Bucaramanga' ? 'selected' : '' }}>Bucaramanga</option>
        </select>
    </div>

    <!-- ESTADO -->
    <div class="mb-2">
        <label>Estado</label>
        <select name="estado" class="form-control">
            <option value="activo" {{ $vehiculo->estado == 'activo' ? 'selected' : '' }}>Activo</option>
            <option value="inactivo" {{ $vehiculo->estado == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
            <option value="matto" {{ $vehiculo->estado == 'matto' ? 'selected' : '' }}>En Mantenimiento</option>
        </select>
    </div>

    <!-- Imagenes nuevas-->
    <div class="mb-3">
        <label><b>Agregar nuevas imágenes</b></label>

        <input type="file"
            name="imagenes[]"
            multiple
            class="form-control">
    </div>

    <button type="button" class="btn btn-primary btn-sm btn-update">
        Actualizar
    </button>
</form>

<script>
    const marcaSelect = document.getElementById('marca');
    const modeloSelect = document.getElementById('modelo');
    const tipoInput = document.getElementById('tipo');
    const tipoInputID = document.getElementById('tipo_id');

    const modeloActual = {{ $vehiculo->modelo_id }};

    // Cargar modelos al cambiar marca
    marcaSelect.addEventListener('change', function () {

        fetch('/modelos/' + this.value)
            .then(res => res.json())
            .then(data => {

                modeloSelect.innerHTML = '';

                data.forEach(modelo => {
                    let option = document.createElement('option');
                    option.value = modelo.id;
                    option.text = modelo.nombre;

                    if (modelo.id == modeloActual) {
                        option.selected = true;
                    }

                    modeloSelect.add(option);
                });

                modeloSelect.dispatchEvent(new Event('change'));

            });

    });

    // Cargar tipo automáticamente
    modeloSelect.addEventListener('change', function () {

        fetch('/tipo/' + this.value)
            .then(res => res.json())
            .then(data => {
                tipoInput.value = data.tipo_nombre;
                tipoInputID.value = data.tipo_id;
            });

    });
    marcaSelect.dispatchEvent(new Event('change'));
</script>

<!-- Mensajes de confirmacion-->
<script>
    document.querySelectorAll('.btn-update').forEach((btn) => {
        btn.addEventListener('click', function () {
            let form = this.closest('form');
            Swal.fire({
                title: '¿Actualizar estado?',
                text: "Se cambiará el estado de la reserva",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0d6efd',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, actualizar',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>

<script>
    document.querySelectorAll('.btn-eliminar').forEach((btn) => {
        btn.addEventListener('click', function () {
            let form = this.closest('form');
            Swal.fire({
                title: '¿Seguro?',
                text: "No podrás revertir esto",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>

@endsection