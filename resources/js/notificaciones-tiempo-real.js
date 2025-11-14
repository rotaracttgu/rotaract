// Sistema de notificaciones en tiempo real para todos los módulos
class NotificacionesTiempoReal {
    constructor(modulo) {
        this.modulo = modulo; // 'vocero', 'presidente', 'vicepresidente', 'secretaria'
        this.checkInterval = 30000; // 30 segundos
        this.intervalId = null;
        this.isActive = false;
    }

    /**
     * Iniciar el sistema de notificaciones
     */
    iniciar() {
        if (this.isActive) return;
        
        this.isActive = true;
        this.verificarActualizaciones(); // Verificar inmediatamente
        
        // Luego verificar cada intervalo
        this.intervalId = setInterval(() => {
            this.verificarActualizaciones();
        }, this.checkInterval);

        console.log(`🔔 Sistema de notificaciones iniciado para ${this.modulo}`);
    }

    /**
     * Detener el sistema de notificaciones
     */
    detener() {
        if (this.intervalId) {
            clearInterval(this.intervalId);
            this.intervalId = null;
        }
        
        this.isActive = false;
        console.log(`🔕 Sistema de notificaciones detenido para ${this.modulo}`);
    }

    /**
     * Verificar actualizaciones en el servidor
     */
    async verificarActualizaciones() {
        try {
            const response = await fetch(`/${this.modulo}/notificaciones/verificar`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
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
        // Actualizar contador de notificaciones
        this.actualizarBadgeNotificaciones(data.notificaciones_nuevas || 0);
        
        // Mostrar notificación si hay nuevas
        if (data.notificaciones_nuevas > 0 && data.ultima_notificacion) {
            this.mostrarNotificacion(data.ultima_notificacion);
        }

        // Refrescar calendario si está en la vista de calendario
        if (window.location.pathname.includes('/calendario') && window.calendar) {
            window.calendar.refetchEvents();
        }

        // Emitir evento personalizado
        window.dispatchEvent(new CustomEvent(`${this.modulo}:actualizacion`, {
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
                badge.classList.add('animate-pulse');
                setTimeout(() => badge.classList.remove('animate-pulse'), 2000);
            } else {
                badge.classList.add('hidden');
            }
        }
    }

    /**
     * Mostrar notificación toast
     */
    mostrarNotificacion(notificacion) {
        const lastShown = localStorage.getItem(`${this.modulo}_last_notification_shown`);
        if (lastShown === notificacion.id.toString()) return;
        
        localStorage.setItem(`${this.modulo}_last_notification_shown`, notificacion.id.toString());

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

        setTimeout(() => toast.classList.remove('translate-x-full'), 100);
        setTimeout(() => {
            toast.classList.add('translate-x-full');
            setTimeout(() => toast.remove(), 300);
        }, 5000);

        this.reproducirSonido();
    }

    /**
     * Reproducir sonido de notificación
     */
    reproducirSonido() {
        const audio = new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBSuBzvLZiTYIFmS57OWaTBELUKvj8LNiHQU2jdXzzn0vBSl+zPLaizsKFGG36+mjUBEJQ5zd8sFuIgUpgM7y2Ik2CRZluu3lmUsSC1Cr4+y0Yh0FNo3V88t+MAUqfszy2Ys5ChRht+zoomESCUKa3PKyZiUFKoHO8tiKNgkWZbrt5JlLEgtQq+PrtWIdBTaN1fPJfi8FKn7M8tuLOAoUYbfr6aJgEgk=');
        audio.volume = 0.3;
        audio.play().catch(() => {});
    }

    /**
     * Ajustar intervalo de verificación
     */
    ajustarIntervalo(activo) {
        this.detener();
        this.checkInterval = activo ? 30000 : 60000;
        if (this.isActive) this.iniciar();
    }
}

// Auto-iniciar según el módulo actual
document.addEventListener('DOMContentLoaded', () => {
    const path = window.location.pathname;
    let modulo = null;

    if (path.includes('/admin')) modulo = 'admin';
    else if (path.includes('/vocero')) modulo = 'vocero';
    else if (path.includes('/presidente')) modulo = 'presidente';
    else if (path.includes('/vicepresidente')) modulo = 'vicepresidente';
    else if (path.includes('/secretaria')) modulo = 'secretaria';
    else if (path.includes('/socio')) modulo = 'socio';

    if (modulo) {
        window.notificacionesTiempoReal = new NotificacionesTiempoReal(modulo);
        window.notificacionesTiempoReal.iniciar();

        // Pausar cuando la pestaña no está visible
        document.addEventListener('visibilitychange', () => {
            window.notificacionesTiempoReal.ajustarIntervalo(!document.hidden);
        });

        // Detener al salir
        window.addEventListener('beforeunload', () => {
            window.notificacionesTiempoReal.detener();
        });
    }
});
