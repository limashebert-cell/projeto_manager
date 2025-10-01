<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth('admin')->check()) {
            return redirect()->route('login');
        }

        $user = auth('admin')->user();
        
        if (!$user->canManageUsers()) {
            return redirect()->route('admin.dashboard')
                           ->with('error', 'Acesso negado! Apenas Super Administradores e Gerentes podem acessar esta funcionalidade.');
        }

        return $next($request);
    }
}
