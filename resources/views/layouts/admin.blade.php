<!DOCTYPE html>
<html>
<head>
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<style>
    html, body {
        height: 100%;
        margin: 0;
    }

    .wrapper {
        display: flex;
        min-height: 100vh;
    }

    .sidebar {
        width: 250px;
        background: #1e1e2d;
        min-height: 100vh;
    }

    .content {
        flex: 1;
        padding: 20px;
    }
</style>

<div class="wrapper">

    <!-- Sidebar -->
    <div class="bg-dark text-white p-3" style="width:250px;">
        <h4>Admin</h4>

        <ul class="nav flex-column">
            <li>
                <a href="{{ route('dashboard') }}" class="nav-link text-white" >Dashboard</a>
            </li>

            <li>
                <a href="/admin/vehiculos" class="nav-link text-white">Vehículos</a>
            </li>

            <li>
                <span class="nav-link text-white">Reservas</span>
                <ul class="nav flex-column ms-3">
                    <li>
                        <a href="/admin/reservas" class="nav-link text-white">
                            Todas las reservas
                        </a>
                    </li>
                    <li>
                        <a href="/admin/reservas/nueva" class="nav-link text-white">
                            Nueva reserva
                        </a>
                    </li>

                </ul>
            </li>

            <li>
                <a href="{{ route('admin.clientes') }}" class="nav-link text-white">Clientes</a>
            </li>

            <li>
                <a href="{{ route('admin.reportes') }}" class="nav-link text-white">Reportes</a>
            </li>
        </ul>
    </div>

    <!-- Contenido -->
    <div class="content">
        @yield('content')
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: "{{ session('success') }}",
            });
        </script>
    @endif

    @if($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                html: `{!! implode('<br>', $errors->all()) !!}`
            });
        </script>
    @endif
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>