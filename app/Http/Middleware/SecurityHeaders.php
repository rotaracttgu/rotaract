<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Add baseline security headers, including CSP.
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        // Hide framework/runtime fingerprinting headers.
        if (function_exists('header_remove')) {
            header_remove('X-Powered-By');
            header_remove('Server');
        }
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('Server');

        if (! $response->headers->has('Content-Security-Policy')) {
            $response->headers->set('Content-Security-Policy', $this->buildCsp());
        }

        $response->headers->set('X-Content-Type-Options', 'nosniff');

        if (! $response->headers->has('X-Frame-Options')) {
            $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        }

        if (! $response->headers->has('Referrer-Policy')) {
            $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        }

        if (! $response->headers->has('Permissions-Policy')) {
            $response->headers->set(
                'Permissions-Policy',
                "camera=(), microphone=(), geolocation=(), payment=(), usb=()"
            );
        }

        return $response;
    }

    /**
     * Build a pragmatic CSP that does not break current UI while adding protection.
     */
    private function buildCsp(): string
    {
        return implode('; ', [
            "default-src 'self'",
            "base-uri 'self'",
            "form-action 'self'",
            "frame-ancestors 'self'",
            "object-src 'none'",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https: http://localhost:* http://127.0.0.1:*",
            "style-src 'self' 'unsafe-inline' https: http://localhost:* http://127.0.0.1:*",
            "img-src 'self' data: blob: https: http:",
            "font-src 'self' data: https: http:",
            "connect-src 'self' https: http: ws: wss:",
            "frame-src 'self' https: http:",
            "media-src 'self' data: blob: https: http:",
        ]);
    }
}
