@extends('layouts.app')

@section('title', 'Painel de Controle - Gerenciamento de Usuários')

@section('content')
<div class="border-bottom mb-2">
    <h3>Painel de Gerenciamento</h3>
</div>

@if(Auth::guard('admin')->user()->isSuperAdmin())
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

<!-- Ações -->
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
                                        {{ $user->role === 'super_admin' ? 'Super' : 'Admin' }}
                                    </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $user->active ? 'success' : 'secondary' }}">
                                                {{ $user->active ? 'Ativo' : 'Inativo' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">Ativo</span>
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
<div class="card">
    <div class="card-body text-center p-3">
        <h5>Bem-vindo, {{ Auth::guard('admin')->user()->name }}!</h5>
        <p class="text-muted mb-0">Acesso limitado - contacte o administrador.</p>
    </div>
</div>
@endif

@endsection