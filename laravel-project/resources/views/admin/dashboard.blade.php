@extends('layouts.app')

@section('title', 'Painel de Controle - Gerenciamento de Usuários')

@section('content')
<div class="border-bottom mb-2 d-flex justify-content-between align-items-center">
    <h3>Painel de Gerenciamento</h3>
    <div class="text-end">
        <small class="text-muted">
            <i class="fas fa-palette me-1"></i>
            <strong class="text-primary">Hebert Design</strong>
        </small>
    </div>
</div>

@if(Auth::guard('admin')->user()->canManageUsers())
<div class="row mb-2">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body p-2">
                <h5 class="mb-0">{{ $totalUsers }}</h5>
                <small>Usuários</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body p-2">
                <h5 class="mb-0">Ativo</h5>
                <small>Sistema</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white">
            <div class="card-body p-2">
                <h5 class="mb-0">Admin</h5>
                <small>Acesso</small>
            </div>
        </div>
    </div>
</div>

<!-- Menu Principal -->
<div class="card mb-2">
    <div class="card-header">
        <h6 class="mb-0">Menu Principal</h6>
    </div>
    <div class="card-body p-3">
        <div class="row text-center">
            <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary btn-lg btn-menu-principal d-flex flex-column align-items-center justify-content-center">
                    <i class="fas fa-tachometer-alt fa-2x mb-2"></i>
                    <span>Dashboard</span>
                </a>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                <a href="{{ route('presencas.index') }}" class="btn btn-outline-success btn-lg btn-menu-principal d-flex flex-column align-items-center justify-content-center">
                    <i class="fas fa-calendar-check fa-2x mb-2"></i>
                    <span>Absenteísmo</span>
                </a>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                <a href="{{ route('colaboradores.index') }}" class="btn btn-outline-info btn-lg btn-menu-principal d-flex flex-column align-items-center justify-content-center">
                    <i class="fas fa-users fa-2x mb-2"></i>
                    <span>Colaboradores</span>
                </a>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                <a href="{{ route('quase-acidentes.index') }}" class="btn btn-outline-warning btn-lg btn-menu-principal d-flex flex-column align-items-center justify-content-center">
                    <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                    <span>Quase Acidente</span>
                </a>
            </div>
            @if(Auth::guard('admin')->user()->canManageUsers())
            <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-lg btn-menu-principal d-flex flex-column align-items-center justify-content-center">
                    <i class="fas fa-user-cog fa-2x mb-2"></i>
                    <span>Usuários</span>
                </a>
            </div>
            @endif
            <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                <a href="{{ route('logout.get') }}" class="btn btn-outline-danger btn-lg btn-menu-principal d-flex flex-column align-items-center justify-content-center">
                    <i class="fas fa-sign-out-alt fa-2x mb-2"></i>
                    <span>Sair</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Ações Rápidas -->
<div class="card mb-2">
    <div class="card-header">
        <h6 class="mb-0">Ações Rápidas</h6>
    </div>
    <div class="card-body p-2">
        <div class="row">
            <div class="col-md-6">
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm w-100 mb-1">
                    Criar Usuário
                </a>
            </div>
            <div class="col-md-6">
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary btn-sm w-100 mb-1">
                    Ver Usuários
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Usuários -->
<div class="card">
    <div class="card-header">
        <h6 class="mb-0">Usuários Recentes</h6>
    </div>
    <div class="card-body p-0">
        @if($recentUsers && $recentUsers->count() > 0)
            <div class="table-responsive">
                <table class="table table-sm table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Usuário</th>
                            <th>Nível</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentUsers as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->username }}</td>
                                <td>
                                    <span class="badge bg-{{ $user->role === 'super_admin' ? 'danger' : 'primary' }}">
                                        {{ $user->getRoleName() }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $user->active ? 'success' : 'secondary' }}">
                                        {{ $user->active ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-outline-primary">Ver</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center p-3">
                <p class="text-muted mb-2">Nenhum usuário encontrado</p>
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
                    Criar Usuário
                </a>
            </div>
        @endif
    </div>
</div>

@else
<!-- Menu Principal para Usuários Normais -->
<div class="card mb-3">
    <div class="card-header">
        <h6 class="mb-0">Bem-vindo, {{ Auth::guard('admin')->user()->name }}!</h6>
    </div>
    <div class="card-body p-3">
        <div class="row text-center">
            <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary btn-lg btn-menu-principal d-flex flex-column align-items-center justify-content-center">
                    <i class="fas fa-tachometer-alt fa-2x mb-2"></i>
                    <span>Dashboard</span>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
                <a href="{{ route('presencas.index') }}" class="btn btn-outline-success btn-lg btn-menu-principal d-flex flex-column align-items-center justify-content-center">
                    <i class="fas fa-calendar-check fa-2x mb-2"></i>
                    <span>Absenteísmo</span>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
                <a href="{{ route('colaboradores.index') }}" class="btn btn-outline-info btn-lg btn-menu-principal d-flex flex-column align-items-center justify-content-center">
                    <i class="fas fa-users fa-2x mb-2"></i>
                    <span>Colaboradores</span>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
                <a href="{{ route('quase-acidentes.index') }}" class="btn btn-outline-warning btn-lg btn-menu-principal d-flex flex-column align-items-center justify-content-center">
                    <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                    <span>Quase Acidente</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endif

@endsection