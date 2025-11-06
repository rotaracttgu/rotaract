<style>
    /* 1. Reset y Contenedor Principal */
    body {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .impact-hero-container {
        /* *** RUTA DE LA IMAGEN DE FONDO ACTUALIZADA *** */
        background-image: url('{{ asset('images/Gemini_Generated_Image_2ix7bp2ix7bp2ix7.png') }}'); 
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        font-family: 'Instrument Sans', sans-serif;
        color: white; 
        padding: 20px;
    }
    
    /* Capa de Degradado Oscuro (Overlay) para asegurar la legibilidad del texto */
    .impact-hero-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        /* Degradado de oscuro a más oscuro para un efecto dinámico */
        background: linear-gradient(135deg, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.9) 100%); 
        z-index: 1;
    }

    /* 2. Tarjeta de Contenido Principal (Glassmorphism sutil) */
    .impact-card {
        position: relative;
        z-index: 2;
        text-align: center;
        max-width: 420px;
        width: 100%;
        padding: 35px;
        background-color: rgba(255, 255, 255, 0.1); 
        border-radius: 15px;
        border: 1px solid rgba(255, 255, 255, 0.2); 
        backdrop-filter: blur(5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
    }

    /* 3. Logo (Tamaño ajustado para destacar) */
    .logo-impact {
        width: 340px; 
        height: auto;
        margin: 0 auto 25px auto;
        display: block;
        filter: 
            brightness(0) 
            invert(1);
    }

    /* 4. Tipografía */
    .impact-title {
        font-size: 2.4em;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 10px;
        line-height: 1.1;
        text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7); 
    }

    .impact-subtitle {
        font-size: 1.1em;
        color: #e0e0e0;
        margin-bottom: 30px;
        font-weight: 300;
        line-height: 1.5;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
    }

    /* 5. Botón de Acceso Único */
    .btn-impact {
        display: inline-block;
        text-decoration: none;
        font-weight: 700;
        padding: 15px 45px; 
        border-radius: 50px; 
        background-color: #008ac9; 
        color: white;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
        border: none;
        box-shadow: 0 8px 20px rgba(0, 138, 201, 0.4);
    }

    .btn-impact:hover {
        background-color: #006b9a;
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(0, 138, 201, 0.6);
    }

    /* 6. Responsividad */
    @media (max-width: 600px) {
        .impact-card {
            padding: 30px 20px;
        }
        .impact-title {
            font-size: 2.2em;
        }
        .impact-subtitle {
            font-size: 1em;
        }
        .logo-impact {
            width: 120px;
        }
    }
</style>

<div class="impact-hero-container">
    <div class="impact-card">
        <img src="{{ asset('images/LogoRotaract.png') }}" alt="Logo Rotaract Club" class="logo-impact">

        <h1 class="impact-title">Haciendo la Diferencia en Tegucigalpa</h1> 
        
        <p class="impact-subtitle">Únete a la red de líderes jóvenes comprometidos con el servicio a la comunidad y el desarrollo personal.</p>

        <a href="/login" class="btn-impact">ACCEDER A LA PLATAFORMA</a>
    </div>
</div>