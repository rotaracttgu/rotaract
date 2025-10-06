
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Tesorero - Bienvenida</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

        <!-- Styles -->
        <style>
            * {
                box-sizing: border-box;
            }

            body {
                font-family: 'Figtree', ui-sans-serif, system-ui, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
                font-weight: 400;
                line-height: 1.5;
                margin: 0;
                background: linear-gradient(135deg, #10b981 0%, #059669 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                position: relative;
            }

            .container {
                width: 100%;
                max-width: 1200px;
                margin: 0 auto;
                padding: 2rem;
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 4rem;
                align-items: center;
            }

            .content {
                color: white;
            }

            .content h1 {
                font-size: 3.5rem;
                font-weight: 600;
                margin-bottom: 1rem;
                text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            }

            .content p {
                font-size: 1.2rem;
                margin-bottom: 2rem;
                opacity: 0.9;
            }

            .welcome-card {
                background: rgba(255, 255, 255, 0.95);
                border-radius: 20px;
                padding: 2rem;
                box-shadow: 0 20px 40px rgba(0,0,0,0.1);
                backdrop-filter: blur(10px);
            }

            .welcome-card h2 {
                color: #333;
                font-size: 1.8rem;
                margin-bottom: 1rem;
                text-align: center;
            }

            .links {
                list-style: none;
                padding: 0;
                margin: 0;
            }

            .links li {
                margin-bottom: 1rem;
            }

            .links a {
                display: flex;
                align-items: center;
                padding: 0.75rem 1rem;
                color: #333;
                text-decoration: none;
                border-radius: 10px;
                transition: all 0.3s ease;
                border: 1px solid #e5e7eb;
            }

            .links a:hover {
                background: #f3f4f6;
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            }

            .links i {
                margin-right: 0.75rem;
                width: 20px;
                text-align: center;
            }

            /* Botón del sistema financiero en la esquina */
            .financial-access {
                position: fixed;
                top: 2rem;
                right: 2rem;
                z-index: 1000;
            }

            .financial-btn {
                background: linear-gradient(45deg, #f59e0b, #d97706);
                color: white;
                padding: 1rem 1.5rem;
                border-radius: 50px;
                text-decoration: none;
                display: flex;
                align-items: center;
                font-weight: 600;
                box-shadow: 0 8px 20px rgba(217, 119, 6, 0.3);
                transition: all 0.3s ease;
                border: none;
                cursor: pointer;
            }

            .financial-btn:hover {
                transform: translateY(-3px) scale(1.05);
                box-shadow: 0 12px 30px rgba(217, 119, 6, 0.5);
                color: white;
                text-decoration: none;
            }

            .financial-btn i {
                margin-right: 0.5rem;
                font-size: 1.2rem;
            }

            /* Responsive */
            @media (max-width: 768px) {
                .container {
                    grid-template-columns: 1fr;
                    gap: 2rem;
                    padding: 1rem;
                }

                .content h1 {
                    font-size: 2.5rem;
                }

                .financial-access {
                    position: relative;
                    top: auto;
                    right: auto;
                    margin: 2rem 0;
                    text-align: center;
                }
            }

            /* Animación de pulso para el botón financiero */
            @keyframes pulse {
                0% {
                    box-shadow: 0 8px 20px rgba(217, 119, 6, 0.3);
                }
                50% {
                    box-shadow: 0 8px 20px rgba(217, 119, 6, 0.6);
                }
                100% {
                    box-shadow: 0 8px 20px rgba(217, 119, 6, 0.3);
                }
            }

            .financial-btn {
                animation: pulse 3s infinite;
            }

            /* Estilo para la tarjeta de información del sistema */
            .system-info {
                background: rgba(255,255,255,0.1);
                padding: 1.5rem;
                border-radius: 15px;
                margin-top: 2rem;
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255,255,255,0.2);
            }

            .system-info h3 {
                margin-bottom: 1rem;
                display: flex;
                align-items: center;
                color: #ffd700;
            }

            .system-info ul {
                list-style: none;
                padding: 0;
                margin: 0;
            }

            .system-info li {
                margin-bottom: 0.5rem;
                display: flex;
                align-items: center;
            }

            .deploy-btn {
                background: #10b981;
                color: white;
                padding: 0.75rem 2rem;
                border-radius: 8px;
                text-decoration: none;
                display: inline-block;
                font-weight: 600;
                transition: all 0.3s ease;
            }

            .deploy-btn:hover {
                background: #059669;
                color: white;
                text-decoration: none;
                transform: translateY(-2px);
            }
        </style>
    </head>
    <body>
        {{-- Botón del dashboard en la esquina superior derecha --}}
        <div class="financial-access">
            <a href="{{ route('tesorero.index') }}" class="financial-btn">
                <i class="fas fa-chart-line"></i>
                Ir al Dashboard
            </a>
        </div>

        <div class="container">
            <div class="content">
                <h1>Tesorero</h1>
                <p>Gestiona las finanzas de tu organización de manera eficiente y profesional.</p>
                
                {{-- Información sobre el sistema financiero --}}
                <div class="system-info">
                    <h3>
                        <i class="fas fa-star me-2"></i>
                        Sistema de Gestión Financiera
                    </h3>
                    <p style="margin-bottom: 1rem; font-size: 1rem; opacity: 0.9;">
                        Control total sobre ingresos, egresos y flujo de caja de tu organización.
                    </p>
                    <ul>
                        <li>
                            <i class="fas fa-check me-2" style="color: #4ade80;"></i>
                            Dashboard con métricas financieras en tiempo real
                        </li>
                        <li>
                            <i class="fas fa-check me-2" style="color: #4ade80;"></i>
                            Gestión completa de ingresos y egresos
                        </li>
                        <li>
                            <i class="fas fa-check me-2" style="color: #4ade80;"></i>
                            Calendario de obligaciones financieras
                        </li>
                        <li>
                            <i class="fas fa-check me-2" style="color: #4ade80;"></i>
                            Reportes y análisis de flujo de efectivo
                        </li>
                    </ul>
                </div>
            </div>

            <div class="welcome-card">
                <h2>¡Comencemos!</h2>
                <ul class="links">
                    <li>
                        <a href="{{ route('tesorero.index') }}">
                            <i class="fas fa-tachometer-alt"></i>
                            Dashboard Principal
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('tesorero.calendario') }}">
                            <i class="fas fa-calendar-alt"></i>
                            Calendario Financiero
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('tesorero.finanzas') }}">
                            <i class="fas fa-coins"></i>
                            Gestión de Finanzas
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard') }}">
                            <i class="fas fa-home"></i>
                            Volver al Dashboard General
                        </a>
                    </li>
                </ul>

                {{-- Deploy button adaptado --}}
                <div style="margin-top: 2rem; text-align: center;">
                    <a href="{{ route('tesorero.index') }}" class="deploy-btn">
                        Acceder al Sistema
                    </a>
                </div>
            </div>
        </div>

        {{-- Script para efectos del botón --}}
        <script>
            // Efecto de hover suave para el botón
            document.addEventListener('DOMContentLoaded', function() {
                const financialBtn = document.querySelector('.financial-btn');
                
                if (financialBtn) {
                    financialBtn.addEventListener('mouseenter', function() {
                        this.style.transform = 'translateY(-3px) scale(1.05)';
                        this.style.animation = 'none';
                    });
                    
                    financialBtn.addEventListener('mouseleave', function() {
                        this.style.transform = 'translateY(0) scale(1)';
                        this.style.animation = 'pulse 3s infinite';
                    });

                    // Efecto de click
                    financialBtn.addEventListener('mousedown', function() {
                        this.style.transform = 'translateY(-1px) scale(1.02)';
                    });
                }
            });
        </script>
    </body>
</html>