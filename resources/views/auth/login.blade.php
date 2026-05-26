<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Login - AutoYa</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <style>
            body {
                font-family: 'Poppins', sans-serif;
                background: linear-gradient(155deg, #04143A, #0d6efd);
                height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .login-card {
                background: white;
                padding: 30px;
                border-radius: 12px;
                width: 380px;
                box-shadow: 0 10px 25px rgba(0,0,0,0.15);
                animation: fadeIn 0.5s ease;
            }

            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }

            .logo {
                display: block;
                margin: 0 auto 20px;
                width: 140px;
            }

            .form-control {
                border-radius: 8px;
                padding: 10px;
            }

            .btn-login {
                border-radius: 8px;
                padding: 10px;
                font-weight: 500;
                background:#04143A;
            }

            .btn-login:hover {
                transform: translateY(-1px);
            }

            .login-title {
                text-align: center;
                font-weight: 600;
                margin-bottom: 15px;
            }
 
            .form-control:focus {
                border-color: #0d6efd;
                box-shadow: 0 0 0 2px rgba(13,110,253,0.15);
            }


        </style>
    </head>
    <body>

        <div class="login-card">

            <img src="/img/logo-trans.png" alt="AutoYa" class="logo">

            <h4 class="login-title">Iniciar sesión</h4>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" 
                        class="form-control" required autofocus>
                </div>

                <div class="mb-3">
                    <label>Contraseña</label>
                    <input type="password" name="password" 
                        class="form-control" required>
                </div>

                <div class="d-grid">
                    <button class="btn btn-primary btn-login">
                        <i class="bi bi-box-arrow-in-right"></i> Ingresar
                    </button>
                </div>

            </form>

        </div>

    </body>
</html>