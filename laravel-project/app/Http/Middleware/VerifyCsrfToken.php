<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'admin/users', // Rota de criação de usuário (para teste externo)
    ];
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Se estiver em ambiente de desenvolvimento, adicionar logs para debug
        if (config('app.debug') && $request->isMethod('post')) {
            \Log::info('CSRF Debug', [
                'token_from_session' => $request->session()->token(),
                'token_from_request' => $request->input('_token') ?: $request->header('X-CSRF-TOKEN'),
                'session_id' => $request->session()->getId(),
                'url' => $request->url()
            ]);
        }
        
        return parent::handle($request, $next);
    }
}
