<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Rotaract Club Tegucigalpa Sur</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #d41367; /* Cranberry */
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
        }

        .login-wrapper {
            width: 100%;
            max-width: 600px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        .logo-container {
            text-align: center;
            animation: fadeInDown 0.8s ease-out;
            width: 100%;
            padding: 15px;
        }

        .logo-container img {
            max-width: 280px;
            width: 100%;
            height: auto;
            filter: brightness(10) contrast(1);
            display: block;
            margin: 0 auto;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-container {
            background: #ffffff; /* White */
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            max-width: 600px;
            width: 100%;
            padding: 30px 40px;
            animation: fadeInUp 0.8s ease-out;
            border: 3px solid #901f93; /* Violet border */
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            color: #901f93; /* Violet */
            font-weight: 600;
            margin-bottom: 6px;
            font-size: 14px;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 11px 14px;
            border: 2px solid #d0cfcd; /* Silver */
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.2s ease;
            background: #ffffff;
            color: #000000;
        }

        .form-group input[type="text"]:focus,
        .form-group input[type="email"]:focus,
        .form-group input[type="password"]:focus {
            outline: none;
            border-color: #901f93; /* Violet */
            box-shadow: 0 0 0 3px rgba(144, 31, 147, 0.1);
        }

        .form-group input[type="text"]::placeholder,
        .form-group input[type="email"]::placeholder,
        .form-group input[type="password"]::placeholder {
            color: #b1b1b1; /* Smoke */
        }

        .form-group input.error {
            border: 2px solid #d41367; /* Cranberry for errors */
        }

        .error-message {
            color: #d41367; /* Cranberry */
            font-size: 12px;
            margin-top: 6px;
            display: block;
            font-weight: 500;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            margin-top: -2px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #901f93; /* Violet */
            font-size: 14px;
            cursor: pointer;
            user-select: none;
            font-weight: 500;
        }

        .remember-me input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #901f93; /* Violet */
        }

        .forgot-password {
            color: #00adbb; /* Turquoise */
            text-decoration: none;
            font-size: 14px;
            transition: color 0.2s ease;
            font-weight: 500;
        }

        .forgot-password:hover {
            color: #d41367; /* Cranberry on hover */
            text-decoration: underline;
        }

        .btn-login {
            width: 100%;
            max-width: 140px;
            padding: 13px 24px;
            background: linear-gradient(135deg, #d41367 0%, #901f93 100%); /* Cranberry to Violet */
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            float: right;
            box-shadow: 0 4px 15px rgba(212, 19, 103, 0.3);
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #901f93 0%, #d41367 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(212, 19, 103, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .register-link {
            clear: both;
            text-align: center;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 2px solid #d0cfcd; /* Silver */
            color: #898a8d; /* Pewter */
            font-size: 13px;
        }

        .register-link a {
            color: #00adbb; /* Turquoise */
            text-decoration: none;
            font-weight: 600;
        }

        .register-link a:hover {
            color: #d41367; /* Cranberry */
            text-decoration: underline;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 13px;
            font-weight: 500;
        }

        .alert-error {
            background-color: rgba(212, 19, 103, 0.1); /* Cranberry */
            border: 2px solid #d41367;
            color: #d41367;
        }

        .alert-success {
            background-color: rgba(0, 151, 57, 0.1); /* Grass */
            border: 2px solid #009739;
            color: #009739;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-wrapper {
                gap: 30px;
            }

            .logo-container img {
                max-width: 280px;
            }

            .login-container {
                padding: 35px 30px;
            }
        }

        @media (max-width: 480px) {
            .login-wrapper {
                gap: 25px;
            }

            .logo-container {
                padding: 15px;
            }

            .logo-container img {
                max-width: 240px;
            }

            .login-container {
                padding: 30px 24px;
            }

            .remember-forgot {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .btn-login {
                width: 100%;
                max-width: 100%;
                float: none;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <!-- Logo del Club -->
        <div class="logo-container">
            <img src="{{ asset('images/LogoRotaract.png') }}" alt="Rotaract Club Tegucigalpa Sur" 
                 onerror="this.onerror=null; this.src='{{ asset('build/images/LogoRotaract.png') }}'">
        </div>

        <div class="login-container">
            <!-- Mensajes de error -->
            @if ($errors->any())
                <div class="alert alert-error">
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            <!-- Mensaje de sesión (si existe) -->
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Formulario de Login -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Usuario o Email -->
                <div class="form-group">
                    <label for="email">Usuario o Email</label>
                    <input 
                        type="text" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        placeholder="Ingresa tu nombre de usuario o email"
                        required 
                        autofocus
                        oninput="this.value = this.value.toUpperCase()"
                        class="@error('email') error @enderror"
                    >
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="Ingresa tu contraseña"
                        required
                        class="@error('password') error @enderror"
                    >
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="remember-forgot">
                    <label class="remember-me">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span>Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-password">
                            Forgot your password?
                        </a>
                    @endif
                </div>

                <!-- Botón de Login -->
                <button type="submit" class="btn-login">
                    LOG IN
                </button>

                <!-- Link de Registro (opcional) -->
                @if (Route::has('register'))
                    <div class="register-link">
                        Don't have an account? <a href="{{ route('register') }}">Sign up here</a>
                    </div>
                @endif
            </form>
        </div>
    </div>
</body>
</html>