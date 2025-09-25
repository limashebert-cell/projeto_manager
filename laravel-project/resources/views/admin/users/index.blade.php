@extends('layouts.app')

@section('title', 'Gerenciar Usuários - Painel Administrativo')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-users me-2 text-primary"></i>
        Gerenciar Usuários
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Novo Usuário
        </a>
    </div>
</div>

@if($users->count() > 0)
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-list me-2"></i>
                Lista de Usuários ({{ $users->count() }})
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Usuário</th>
                            <th>Área</th>
                            <th>Status</th>
                            <th>Criado em</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td><span class="badge bg-light text-dark">#{{ $user->id }}</span></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle me-2">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <strong>{{ $user->name }}</strong>
                                    </div>
                                </td>
                                <td>
                                    <code>{{ $user->username }}</code>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $user->area }}</span>
                                </td>
                                <td>
                                    @if($user->active)
                                        <span class="badge bg-success">
                                            <i class="fas fa-check me-1"></i>Ativo
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            <i class="fas fa-times me-1"></i>Inativo
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $user->created_at->format('d/m/Y H:i') }}
                                    </small>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.users.show', $user->id) }}" 
                                           class="btn btn-outline-info" 
                                           title="Ver Detalhes">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        <a href="{{ route('admin.users.edit', $user->id) }}" 
                                           class="btn btn-outline-warning" 
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <form action="{{ route('admin.users.toggle-status', $user->id) }}" 
                                              method="POST" 
                                              style="display: inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="btn btn-outline-{{ $user->active ? 'secondary' : 'success' }}" 
                                                    title="{{ $user->active ? 'Desativar' : 'Ativar' }}"
                                                    onclick="return confirm('Tem certeza que deseja {{ $user->active ? 'desativar' : 'ativar' }} este usuário?')">
                                                <i class="fas fa-{{ $user->active ? 'pause' : 'play' }}"></i>
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" 
                                              method="POST" 
                                              style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-outline-danger" 
                                                    title="Excluir"
                                                    onclick="return confirm('Tem certeza que deseja excluir este usuário? Esta ação não pode ser desfeita.')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@else
    <div class="text-center py-5">
        <div class="mb-4">
            <i class="fas fa-users fa-5x text-muted"></i>
        </div>
        <h3 class="text-muted">Nenhum usuário cadastrado</h3>
        <p class="text-muted mb-4">Comece criando o primeiro usuário do sistema.</p>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-plus me-2"></i>Criar Primeiro Usuário
        </a>
    </div>
@endif

<style>
    .avatar-circle {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 14px;
    }
    
    .table-responsive {
        border-radius: 15px;
    }
    
    .btn-group-sm .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        border-radius: 0.2rem;
    }
    
    @media (max-width: 768px) {
        .table {
            font-size: 0.875rem;
        }
        
        .btn-group {
            flex-direction: column;
        }
        
        .btn-group .btn {
            margin-bottom: 2px;
            border-radius: 0.375rem !important;
        }
    }
</style>
@endsection