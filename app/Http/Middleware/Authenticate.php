<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }
        
        // En lugar de redirigir a 'login', podrías devolver un mensaje de error JSON o cualquier otro comportamiento
        abort(response()->json([
            'meta' => [
                'code' => 401,
                'status' => 'error',
                'message' => 'Usuario no autenticado.',
            ],
            'data' => null,
        ], 401));
    }
}
