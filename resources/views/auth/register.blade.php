<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - AutoYa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #04143A, #0d6efd);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-register {
            background: white;
            padding: 25px;
            border-radius: 12px;
            width: 600px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .logo {
            display: block;
            margin: 0 auto 15px;
            width: 130px;
        }

        .form-control {
            border-radius: 8px;
            padding: 8px 10px;
        }

        .btn-primary {
            border-radius: 8px;
            padding: 10px;
            font-weight: 500;
            background: #04143A;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
        }

        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }
    </style>
</head>

<body>

<div class="card-register">

    <img src="/img/logo-trans.png" class="logo">

    <h4 class="text-center mb-3">Crear cuenta</h4>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="row g-3">

            <!-- Cedula -->
            <div class="col-md-6 position-relative">
                <label>Cédula</label>
                <input type="text" name="cedula"
                    value="{{ old('cedula') }}"
                    class="form-control pe-3">
            </div>

            <!-- Nombre -->
            <div class="col-md-6 mb-2 position-relative">
                <label>Nombre</label>
                <input type="text" name="nombre"
                    value="{{ old('nombre') }}"
                    class="form-control pe-3">
            </div>

            <!-- Email -->
            <div class="col-md-6 mb-2 position-relative">
                <label>Email</label>
                <input type="email" name="email"
                    value="{{ old('email') }}"
                    class="form-control pe-3">
            </div>

            <!-- Teléfono -->
            <div class="col-md-6 mb-2 position-relative">
                <label>Teléfono</label>
                <input type="text" name="telefono"
                    value="{{ old('telefono') }}"
                    class="form-control pe-3">
            </div>

            <!-- Password -->
            <div class="col-md-6 mb-2 position-relative">
                <label>Contraseña</label>
                <input type="password" name="password"
                    class="form-control pe-3">
            </div>

            <!-- Confirm -->
            <div class="col-md-6 mb-3 position-relative">
                <label>Confirmar contraseña</label>
                <input type="password" name="password_confirmation"
                    class="form-control pe-3">
            </div>

        </div>

        <!-- BOTÓN -->
        <div class="d-grid">
            <button class="btn btn-primary">
                <i class="bi bi-person-plus"></i> Registrar
            </button>
        </div>

        <div class="text-center mt-3">
            <a href="{{ route('login') }}">
                ¿Ya tienes cuenta? Inicia sesión
            </a>
        </div>

    </form>

</div>

</body>
</html>