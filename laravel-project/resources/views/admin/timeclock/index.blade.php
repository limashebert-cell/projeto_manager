@extends('layouts.app')

@section('title', 'Colaboradores - Painel Administrativo')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-users me-2 text-primary"></i>
        Colaboradores
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="badge bg-primary fs-6">
            <i class="fas fa-calendar me-1"></i>
            {{ now()->format('d/m/Y') }}
        </div>
    </div>
</div>

<!-- Gestão de Colaboradores -->
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-users fa-4x text-success mb-4"></i>
                <h2 class="card-title text-success mb-3">
                    Gerenciar Colaboradores
                </h2>
                <p class="text-muted mb-4 fs-5">
                    Cadastre, visualize e gerencie todos os seus colaboradores em um só lugar
                </p>
                <div class="d-grid gap-3 d-md-flex justify-content-md-center">
                    <a href="{{ route('colaboradores.index') }}" class="btn btn-success btn-lg px-5">
                        <i class="fas fa-user-plus me-2"></i>
                        Adicionar Colaboradores
                    </a>
                    <a href="{{ route('presencas.index') }}" class="btn btn-warning btn-lg px-5">
                        <i class="fas fa-clipboard-check me-2"></i>
                        Atestar Absenteísmo
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection