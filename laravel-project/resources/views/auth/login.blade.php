@extends('layouts.app')

@section('title', 'Login - Painel Administrativo')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-lg">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            <i class="fas fa-shield-alt fa-3x text-primary"></i>
                        </div>
                        <h3 class="card-title fw-bold text-primary">Painel Administrativo</h3>
                        <p class="text-muted">Faça login para acessar o sistema</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="username" class="form-label">
                                <i class="fas fa-user me-2"></i>Usuário
                            </label>
                            <input type="text" 
                                   class="form-control @error('username') is-invalid @enderror" 
                                   id="username" 
                                   name="username" 
                                   value="{{ old('username') }}" 
                                   required 
                                   autofocus
                                   placeholder="Digite seu usuário">
                            @error('username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-2"></i>Senha
                            </label>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   required
                                   placeholder="Digite sua senha">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>Entrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="text-center mt-3">
                <small class="text-muted">
                    <i class="fas fa-lock me-1"></i>
                    Sistema protegido - Acesso restrito
                </small>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
    }
    
    .card {
        border-radius: 20px;
        border: none;
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.95);
    }
    
    .min-vh-100 {
        min-height: 100vh !important;
    }
    
    @media (max-width: 768px) {
        .card-body {
            padding: 2rem !important;
        }
        
        .fa-3x {
            font-size: 2rem !important;
        }
    }
</style>
@endsection