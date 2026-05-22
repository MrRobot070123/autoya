<!DOCTYPE html>
<html>
    <head>
        <title>AutoYa</title>

        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Tu CSS -->
        <link rel="stylesheet" href="{{ asset('style.css') }}">
    </head>

    <body>

    <header>
        <div class="logo-section">
            <a href="/">
                <img src="{{ asset('img/logo.png') }}" class="logo">
            </a>
        </div>

        <nav>
            <a href="/">Inicio</a>
            <a href="/vehiculos">Vehículos</a>
            <a href="/vehiculos/buscar">Reservar</a>

            {{-- ✅ SI NO ESTÁ LOGUEADO --}}
            @guest
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Registrar</a>
            @endguest

            {{-- ✅ SI ESTÁ LOGUEADO --}}
            @auth
            <div class="dropdown" style="display:inline-block;">

                <button class="btn btn-sm dropdown-toggle"
                        type="button"
                        data-bs-toggle="dropdown"
                        style="
                            background: none;
                            border: none;
                            color: #F8B400;
                            font-weight: 500;
                            margin-left: 20px;
                            padding-left: 0;
                            padding-bottom: 6px;
                            font-weight: bold;
                        ">

                    {{ auth()->user()->nombre }}

                </button>

                <ul class="dropdown-menu dropdown-menu-end shadow-sm">

                    <li>
                        <a class="dropdown-item" href="/cliente/reservas">
                            Mis reservas
                        </a>
                    </li>

                    <li><hr class="dropdown-divider"></li>

                    <li>
                        <form method="POST" action="{{ route('logout') }}" style="margin: 0; padding: 0;">
                            @csrf
                            <button class="dropdown-item text-danger">
                                Cerrar sesión
                            </button>
                        </form>
                    </li>

                </ul>

            </div>
            @endauth
        </nav>
    </header>

    <div class="content">
        @yield('content')
    </div>

    <footer>
        <p>© 2026 AutoYa - Todos los derechos reservados</p>
    </footer>

    <!-- SweetAlert -->
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    </body>
</html>
