<!DOCTYPE html>
<html>
<head>
    <title>Autoya - Admin</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('/img/favicon/favicon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preload" href="{{ asset('/img/logo-trans-blanco.png') }}" as="image">   
</head>

<body>

<style>
    html, body {
        height: 100%;
        margin: 0;
        font-family: 'Poppins', sans-serif;
    }

    h3, h4, h5 {
        font-weight: 600;
    }

    .btn {
        border-radius: 8px;
        padding: 8px 16px;
        font-size: 14px;
    }

    table {
        border-radius: 10px;
        overflow: hidden;
    }

    thead {
        background: #0d6efd;
        color: white;
    }
    
    input, select {
        border-radius: 8px;
    }

    .wrapper {
        display: flex;
        min-height: 100vh;
    }

    .content {
        margin-left:20%;
        width: 1000px;
        padding: 20px;
        background: #f8fafc;
        min-height: 100vh;
    }

    .sidebar {
        width: 220px;
        height: 100vh;
        background: #04143A;
        color: white;
        position: fixed;
        padding: 20px;
    }

    .sidebar a {
        display: block;
        padding: 10px;
        margin: 8px 0;
        color: #cbd5e1;
        text-decoration: none;
        border-radius: 6px;
    }

    .sidebar a:hover {
        background: #414e69;
        color: white;
    }

    .submenu {
        display: none;
        padding-left: 10px;
    }

    .submenu li a {
        font-size: 14px;
        padding: 8px;
        display: block;
    }

    .submenu-toggle {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .arrow {
        font-size: 12px;
        transition: transform 0.3s;
    }

    .submenu-open .submenu {
        display: block;
    }

    .submenu-open .arrow {
        transform: rotate(180deg);
    }

    .logo {
        margin-bottom: 20px;
        height: 8%;
        margin: 8px 0;
    }

    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: 0.2s;
    }

    .card:hover {
        transform: translateY(-2px);
    }

    .sidebar a {
        display: flex;
        align-items: center;
    }

    .menu-item {
        display: flex;
        justify-content: space-between;
        width: 100%;
        align-items: center;
    }

</style>

<div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar">
        <img src="{{ asset('/img/logo-trans-blanco.png') }}" alt="AutoYa" class="logo">
        <ul class="nav flex-column">
            <li>
                <a href="{{ route('dashboard') }}">
                    <i class="bi bi-speedometer2 me-2"></i>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="/admin/vehiculos">
                    <i class="bi bi-car-front-fill me-2"></i>
                    Vehículos
                </a>
            </li>
            <li class="{{ request()->is('admin/reservas*') ? 'submenu-open' : '' }}">              
                <a href="#" class="submenu-toggle">
                    <div class="menu-item">
                        <div>
                            <i class="bi bi-calendar-date me-1"></i>
                            Reservas
                        </div>
                        <span class="arrow"><i class="bi bi-caret-down-fill"></i></span>
                    </div>
                </a>
                <ul class="nav submenu">
                    <li>
                        <a href="/admin/reservas">
                            <i class="bi bi-calendar-check me-2"></i>
                            Mostrar reservas
                        </a>
                    </li>
                    <li>
                        <a href="/admin/reservas/nueva">
                            <i class="bi bi-calendar-plus me-2"></i>
                            Nueva reserva
                        </a>
                    </li>
                </ul>
            </li>
            <li class="{{ request()->is('admin/clientes*') ? 'submenu-open' : '' }}"> 
                <a href="#" class="submenu-toggle">
                    <div class="menu-item">
                        <div>
                            <i class="bi bi-people-fill me-1"></i>
                            Clientes
                        </div>
                        <span class="arrow"><i class="bi bi-caret-down-fill"></i></span>
                    </div>
                </a>
                <ul class="nav submenu">
                    <li>
                        <a href="{{ route('admin.clientes') }}">
                            <i class="bi bi-people-fill me-2"></i>
                            Mostrar clientes
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.clientes.crear') }}">
                            <i class="bi bi-people-fill me-2"></i>
                            Crear cliente
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ route('admin.reportes') }}">
                    <i class="bi bi-bar-chart-line-fill me-2"></i>
                    Reportes
                </a>
            </li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="dropdown-item text-danger">
                        <a>
                            <i class="bi bi-door-closed-fill me-2"></i>
                            Cerrar sesión
                        </a>
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <!-- Contenido -->
    <div class="content">
        @yield('content')
    </div>

</div>

<script>
    document.querySelectorAll('.submenu-toggle').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const parent = this.parentElement;
            parent.classList.toggle('submenu-open');
        });
    });
</script>

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