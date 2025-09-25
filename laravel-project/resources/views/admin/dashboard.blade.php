@extends('layouts.app')

@section('title', 'Dashboard - Painel Administrativo')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-tachometer-alt me-2 text-primary"></i>
        Dashboard
    </h1>
</div>

<!-- Cards de estatísticas -->
<div class="row mb-4">
    <div class="col-md-6 col-lg-3 mb-3">
        <div class="card text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">{{ $totalUsers }}</h4>
                        <p class="card-text">Usuários Cadastrados</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3 mb-3">
        <div class="card text-white" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">Online</h4>
                        <p class="card-text">Sistema Ativo</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3 mb-3">
        <div class="card text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">{{ ucfirst($user->role) }}</h4>
                        <p class="card-text">Seu Nível</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-crown fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3 mb-3">
        <div class="card text-white" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">{{ \Carbon\Carbon::now()->format('d/m') }}</h4>
                        <p class="card-text">Data Atual</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-calendar fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Informações do usuário -->
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2 text-primary"></i>
                    Bem-vindo ao Painel Administrativo
                </h5>
            </div>
            <div class="card-body">
                <p class="lead">Olá, <strong>{{ $user->name }}</strong>!</p>
                <p>Você está logado como <span class="badge bg-primary">{{ $user->role === 'super_admin' ? 'Super Administrador' : 'Administrador' }}</span></p>
                
                @if($user->area)
                    <p><strong>Área:</strong> {{ $user->area }}</p>
                @endif
                
                <hr>
                
                <h6><i class="fas fa-tools me-2"></i>Funcionalidades Disponíveis:</h6>
                <ul class="list-unstyled">
                    @if($user->isSuperAdmin())
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Gerenciar usuários do sistema
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Criar novos logins para gestores
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Editar informações de usuários
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Ativar/Desativar usuários
                        </li>
                    @else
                        <li class="mb-2">
                            <i class="fas fa-info text-info me-2"></i>
                            Acesso ao painel administrativo
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-info text-info me-2"></i>
                            Visualização do dashboard
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-info text-muted me-2"></i>
                            <span class="text-muted">Gerenciamento de usuários (Apenas Super Admin)</span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-rocket me-2 text-primary"></i>
                    Ações Rápidas
                </h5>
            </div>
            <div class="card-body">
                @if($user->isSuperAdmin())
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                            <i class="fas fa-user-plus me-2"></i>
                            Criar Novo Usuário
                        </a>
                        
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-list me-2"></i>
                            Ver Todos os Usuários
                        </a>
                        
                        <a href="{{ route('colaboradores.index') }}" class="btn btn-success">
                            <i class="fas fa-user-friends me-2"></i>
                            Gerenciar Colaboradores
                        </a>
                        
                        <a href="{{ route('presencas.index') }}" class="btn btn-warning">
                            <i class="fas fa-calendar-check me-2"></i>
                            Controle de Absenteísmo
                        </a>
                        
                        <a href="{{ route('auditoria.index') }}" class="btn btn-info">
                            <i class="fas fa-clipboard-list me-2"></i>
                            Auditoria de Presenças
                        </a>
                    </div>
                @else
                    <div class="d-grid gap-2 mb-3">
                        <a href="{{ route('colaboradores.index') }}" class="btn btn-success">
                            <i class="fas fa-user-friends me-2"></i>
                            Gerenciar Colaboradores
                        </a>
                        
                        <a href="{{ route('presencas.index') }}" class="btn btn-warning">
                            <i class="fas fa-calendar-check me-2"></i>
                            Controle de Absenteísmo
                        </a>
                        
                        <a href="{{ route('auditoria.index') }}" class="btn btn-info">
                            <i class="fas fa-clipboard-list me-2"></i>
                            Auditoria de Presenças
                        </a>
                    </div>
                    
                    <div class="alert alert-info mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Administrador Regular</strong><br>
                        <small>Você tem acesso ao painel e pode gerenciar colaboradores e controle de presenças. Apenas o Super Administrador pode gerenciar usuários.</small>
                    </div>
                @endif
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-user-circle me-2 text-info"></i>
                    Suas Informações
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td><strong>Nome:</strong></td>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Usuário:</strong></td>
                        <td>{{ $user->username }}</td>
                    </tr>
                    @if($user->area)
                    <tr>
                        <td><strong>Área:</strong></td>
                        <td>{{ $user->area }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td><strong>Tipo:</strong></td>
                        <td>
                            <span class="badge bg-{{ $user->role === 'super_admin' ? 'danger' : 'primary' }}">
                                {{ $user->role === 'super_admin' ? 'Super Admin' : 'Admin' }}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection