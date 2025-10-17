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
            background: #001f3f; /* Dark Blue*/
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

        .login-container {
            background: #ffffff; /* White */
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            max-width: 600px;
            width: 100%;
            padding: 30px 40px;
            animation: fadeInUp 0.8s ease-out;
            position: relative;
            z-index: 1;
        }

        /* Borde multicolor con gradiente que respeta border-radius */
        .login-container::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 16px;
            padding: 4px; /* Grosor del borde */
            background: linear-gradient(135deg, #d41367, #901f93, #00adbb, #ffc72c, #009739, #d41367);
            -webkit-mask: 
                linear-gradient(#fff 0 0) content-box, 
                linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            z-index: -1;
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

        .logo-container {
            text-align: center;
            animation: fadeInDown 0.8s ease-out;
            width: 100%;
            padding: 15px 0 25px 0;
            margin-bottom: 10px;
        }

        .logo-container {
            position: relative;
            display: inline-block;
        }

        .logo-container img {
            max-width: 280px;
            width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
            filter: 
                brightness(0) 
                saturate(100%) 
                invert(27%) 
                sepia(51%) 
                saturate(2878%) 
                hue-rotate(346deg) 
                brightness(104%) 
                contrast(97%);
            transition: all 0.3s ease;
            position: relative;
            z-index: 2;
        }

        /* Multicolor gradient overlay with blend modes */
        .logo-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 280px;
            height: 100%;
            background: linear-gradient(135deg, #d41367 0%, #901f93 25%, #00adbb 50%, #009739 75%, #d41367 100%);
            background-size: 200% 200%;
            animation: gradientShift 4s ease-in-out infinite;
            mix-blend-mode: multiply;
            opacity: 0.8;
            pointer-events: none;
            z-index: 1;
            border-radius: 8px;
        }

        /* Enhanced filter for better color vibrancy */
        .logo-container img {
            filter: 
                drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1))
                hue-rotate(0deg) 
                saturate(1.8) 
                brightness(1.1) 
                contrast(1.2);
        }

        @keyframes gradientShift {
            0%, 100% {
                background-position: 0% 50%;
            }
            25% {
                background-position: 100% 0%;
            }
            50% {
                background-position: 100% 100%;
            }
            75% {
                background-position: 0% 100%;
            }
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

        /* ⭐ NUEVO: Estilos para opciones de recuperación */
        .password-recovery-section {
            clear: both;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #d0cfcd; /* Silver */
        }

        .password-recovery-title {
            text-align: center;
            color: #901f93;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .recovery-options {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .recovery-option {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 16px;
            background: linear-gradient(135deg, #00adbb 0%, #009739 100%);
            color: #ffffff;
            text-decoration: none;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 3px 10px rgba(0, 173, 187, 0.3);
        }

        .recovery-option:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 173, 187, 0.4);
        }

        .recovery-option.email {
            background: linear-gradient(135deg, #00adbb 0%, #0094a8 100%);
        }

        .recovery-option.questions {
            background: linear-gradient(135deg, #901f93 0%, #d41367 100%);
        }

        .recovery-icon {
            width: 16px;
            height: 16px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-wrapper {
                gap: 30px;
            }

            .logo-container img {
                max-width: 280px;
            }

            .logo-container::before {
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
                padding: 15px 0 20px 0;
            }

            .logo-container img {
                max-width: 240px;
            }

            .logo-container::before {
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

            .recovery-options {
                flex-direction: column;
            }

            .recovery-option {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-container">
            <!-- Logo del Club -->
            <div class="logo-container">
                <img src="{{ asset('images/Logo_Rotarac.webp') }}" alt="Rotaract Club Tegucigalpa Sur" 
                     onerror="this.onerror=null; this.src='{{ asset('build/images/LogoRotaract.png') }}'">
            </div>

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

            <!-- Mensaje de éxito (si existe) -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
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
                </div>

                <!-- Botón de Login -->
                <button type="submit" class="btn-login">
                    LOG IN
                </button>

                <!-- ⭐ NUEVO: Sección de Recuperación de Contraseña -->
                <div class="password-recovery-section">
                    <p class="password-recovery-title">¿Olvidaste tu contraseña?</p>
                    <div class="recovery-options">
                        <a href="{{ route('password.request') }}" class="recovery-option email">
                            <svg class="recovery-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Por Email
                        </a>
                        <a href="{{ route('password.security.identify') }}" class="recovery-option questions">
                            <svg class="recovery-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Preguntas de Seguridad
                        </a>
                    </div>
                </div>

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