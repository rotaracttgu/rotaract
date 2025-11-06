// Servicio de notificaciones en tiempo real para Secretaría
class SecretariaNotificaciones {
    constructor() {
        this.pollingInterval = null;
        this.lastCheck = null;
        this.isActive = false;
        this.checkInterval = 30000; // 30 segundos
    }

    /**
     * Iniciar el sistema de notificaciones
     */
    iniciar() {
        if (this.isActive) return;
        
        this.isActive = true;
        console.log('🔔 Sistema de notificaciones iniciado');
        
        // Verificar inmediatamente
        this.verificarActualizaciones();
        
        // Configurar polling
        this.pollingInterval = setInterval(() => {
            this.verificarActualizaciones();
        }, this.checkInterval);
    }

    /**
     * Detener el sistema de notificaciones
     */
    detener() {
        if (this.pollingInterval) {
            clearInterval(this.pollingInterval);
            this.pollingInterval = null;
        }
        this.isActive = false;
        console.log('🔕 Sistema de notificaciones detenido');
    }

    /**
     * Verificar actualizaciones del servidor
     */
    async verificarActualizaciones() {
        try {
            const response = await fetch('/secretaria/notificaciones/verificar', {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                    'Accept': 'application/json',
                }
            });

            if (!response.ok) return;

            const data = await response.json();
            
            if (data.success) {
                this.procesarActualizaciones(data);
            }
        } catch (error) {
            console.error('Error verificando actualizaciones:', error);
        }
    }

    /**
     * Procesar las actualizaciones recibidas
     */
    procesarActualizaciones(data) {
        // Actualizar contador de notificaciones (siempre actualizar, incluso si es 0)
        this.actualizarBadgeNotificaciones(data.notificaciones_nuevas || 0);
        
        // Mostrar notificación si hay nuevas
        if (data.notificaciones_nuevas > 0 && data.ultima_notificacion) {
            this.mostrarNotificacion(data.ultima_notificacion);
        }

        // Actualizar consultas pendientes
        if (data.consultas_pendientes !== undefined) {
            this.actualizarContadorConsultas(data.consultas_pendientes);
        }

        // Actualizar eventos del calendario
        if (data.eventos_proximos > 0) {
            this.actualizarEventosProximos(data.eventos_proximos);
        }

        // Refrescar calendario si está en la vista de calendario
        if (window.location.pathname.includes('/calendario') && window.calendar) {
            window.calendar.refetchEvents();
        }

        // Emitir evento personalizado para que otros componentes reaccionen
        window.dispatchEvent(new CustomEvent('secretaria:actualizacion', {
            detail: data
        }));
    }

    /**
     * Actualizar badge de notificaciones
     */
    actualizarBadgeNotificaciones(cantidad) {
        const badge = document.querySelector('[data-notificaciones-badge]');
        if (badge) {
            badge.textContent = cantidad;
            
            if (cantidad > 0) {
                badge.classList.remove('hidden');
                // Animación de pulso
                badge.classList.add('animate-pulse');
                setTimeout(() => badge.classList.remove('animate-pulse'), 2000);
            } else {
                badge.classList.add('hidden');
            }
        }
    }

    /**
     * Actualizar contador de consultas pendientes
     */
    actualizarContadorConsultas(cantidad) {
        const elementos = document.querySelectorAll('[data-consultas-pendientes]');
        elementos.forEach(el => {
            el.textContent = cantidad;
        });
    }

    /**
     * Actualizar eventos próximos
     */
    actualizarEventosProximos(cantidad) {
        const badge = document.querySelector('[data-eventos-badge]');
        if (badge) {
            badge.textContent = cantidad;
            badge.classList.remove('hidden');
        }
    }

    /**
     * Mostrar notificación toast
     */
    mostrarNotificacion(notificacion) {
        // Verificar si ya mostramos esta notificación
        const lastShown = localStorage.getItem('last_notification_shown');
        if (lastShown === notificacion.id.toString()) return;
        
        // Guardar que ya mostramos esta notificación
        localStorage.setItem('last_notification_shown', notificacion.id.toString());

        // Crear el toast
        const toast = document.createElement('div');
        toast.className = 'fixed top-20 right-4 bg-white rounded-lg shadow-2xl border-l-4 border-purple-600 p-4 max-w-md z-50 transform transition-all duration-300 translate-x-full';
        toast.innerHTML = `
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-bell text-white"></i>
                    </div>
                </div>
                <div class="flex-1">
                    <h4 class="font-bold text-gray-800 mb-1">Nueva Notificación</h4>
                    <p class="text-sm text-gray-600">${notificacion.mensaje || notificacion.titulo}</p>
                    <p class="text-xs text-gray-400 mt-1">Hace un momento</p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;

        document.body.appendChild(toast);

        // Animación de entrada
        setTimeout(() => {
            toast.classList.remove('translate-x-full');
        }, 100);

        // Auto-remover después de 5 segundos
        setTimeout(() => {
            toast.classList.add('translate-x-full');
            setTimeout(() => toast.remove(), 300);
        }, 5000);

        // Sonido de notificación (opcional)
        this.reproducirSonido();
    }

    /**
     * Reproducir sonido de notificación
     */
    reproducirSonido() {
        // Solo si el usuario ha interactuado con la página
        const audio = new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBSuBzvLZiTYIFmS57OWaTBELUKvj8LNiHQU2jdXzzn0vBSl+zPLaizsKFGG36+mjUBEJQ5zd8sFuIgUpgM7y2Ik2CRZluu3lmUsSC1Cr4+y0Yh0FNo3V88t+MAUqfszy2Ys5ChRht+zoomESCUKa3PKyZiUFKoHO8tiKNgkWZbrt5JlLEgtQq+PrtWIdBTaN1fPJfi8FKn7M8tuLOAoUYbfr6aJgEgk=');
        audio.volume = 0.3;
        audio.play().catch(() => {}); // Ignorar errores si no se puede reproducir
    }

    /**
     * Ajustar intervalo de verificación (para cuando la pestaña no está activa)
     */
    ajustarIntervalo(activo) {
        this.detener();
        this.checkInterval = activo ? 30000 : 60000; // 30s activo, 60s inactivo
        if (this.isActive) this.iniciar();
    }
}

// Instancia global
window.secretariaNotificaciones = new SecretariaNotificaciones();

// Auto-iniciar cuando el documento esté listo
document.addEventListener('DOMContentLoaded', () => {
    // Solo iniciar en páginas de secretaría
    if (window.location.pathname.includes('/secretaria')) {
        window.secretariaNotificaciones.iniciar();
    }
});

// Pausar cuando la pestaña no está visible (ahorro de recursos)
document.addEventListener('visibilitychange', () => {
    if (window.secretariaNotificaciones) {
        window.secretariaNotificaciones.ajustarIntervalo(!document.hidden);
    }
});

// Detener al salir de la página
window.addEventListener('beforeunload', () => {
    if (window.secretariaNotificaciones) {
        window.secretariaNotificaciones.detener();
    }
});
