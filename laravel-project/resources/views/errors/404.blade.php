@extends('layouts.app')

@section('title', '404 - Página não encontrada')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-75">
        <div class="col-md-6 text-center">
            <div class="card shadow-sm">
                <div class="card-body p-5">
                    <div class="mb-4">
                        <i class="fas fa-exclamation-triangle fa-4x text-warning"></i>
                    </div>
                    <h1 class="display-4 text-primary">404</h1>
                    <h4 class="mb-3">Página não encontrada</h4>
                    <p class="text-muted mb-4">
                        A página que você está procurando não existe ou foi movida.
                    </p>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                            <i class="fas fa-home me-2"></i>Voltar ao Dashboard
                        </a>
                        <button onclick="history.back()" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Página Anterior
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <small class="text-muted">
                    <i class="fas fa-code me-1"></i>
                    Sistema desenvolvido por <strong class="text-primary">Hebert Design</strong>
                </small>
            </div>
        </div>
    </div>
</div>

<style>
.min-vh-75 {
    min-height: 75vh;
}
</style>
@endsection