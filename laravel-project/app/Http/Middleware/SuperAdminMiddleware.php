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
        
        if (!$user->isSuperAdmin()) {
            return redirect()->route('admin.dashboard')
                           ->with('error', 'Acesso negado! Apenas o Super Administrador pode acessar esta funcionalidade.');
        }

        return $next($request);
    }
}
