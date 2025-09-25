@extends('layouts.app')

@section('title', 'Colaboradores - Painel Administrativo')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-users me-2 text-primary"></i>
        Meus Colaboradores
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('colaboradores.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>
            Novo Colaborador
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($colaboradores->count() > 0)
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-list me-2"></i>
                Lista de Colaboradores
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Prontuário</th>
                            <th>Nome</th>
                            <th>Cargo</th>
                            <th>Admissão</th>
                            <th>Contato</th>
                            <th>Status</th>
                            <th width="200">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($colaboradores as $colaborador)
                            <tr>
                                <td>
                                    <i class="fas fa-id-card me-2 text-muted"></i>
                                    <strong>{{ $colaborador->prontuario }}</strong>
                                </td>
                                <td>
                                    <i class="fas fa-user me-2 text-muted"></i>
                                    {{ $colaborador->nome }}
                                </td>
                                <td>
                                    <i class="fas fa-briefcase me-2 text-muted"></i>
                                    {{ $colaborador->cargo }}
                                </td>
                                <td>
                                    <i class="fas fa-calendar me-2 text-muted"></i>
                                    {{ $colaborador->data_admissao->format('d/m/Y') }}
                                </td>
                                <td>
                                    <i class="fas fa-phone me-2 text-muted"></i>
                                    {{ $colaborador->contato }}
                                </td>
                                <td>
                                    @if($colaborador->status === 'ativo')
                                        <span class="badge bg-success">
                                            <i class="fas fa-check me-1"></i>
                                            Ativo
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            <i class="fas fa-times me-1"></i>
                                            Inativo
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('colaboradores.show', $colaborador) }}" 
                                           class="btn btn-sm btn-outline-info" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('colaboradores.edit', $colaborador) }}" 
                                           class="btn btn-sm btn-outline-warning" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('colaboradores.destroy', $colaborador) }}" 
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Tem certeza que deseja remover este colaborador?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir">
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
        
        @if($colaboradores->hasPages())
            <div class="card-footer">
                {{ $colaboradores->links() }}
            </div>
        @endif
    </div>
@else
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fas fa-users fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">Nenhum colaborador cadastrado</h4>
            <p class="text-muted">Cadastre seu primeiro colaborador para começar.</p>
            <a href="{{ route('colaboradores.create') }}" class="btn btn-primary btn-lg mt-3">
                <i class="fas fa-plus me-2"></i>
                Cadastrar Primeiro Colaborador
            </a>
        </div>
    </div>
@endif

@endsection