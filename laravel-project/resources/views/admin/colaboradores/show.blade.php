@extends('layouts.app')

@section('title', 'Colaborador: ' . $colaborador->nome . ' - Painel Administrativo')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-user me-2 text-primary"></i>
        {{ $colaborador->nome }}
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('colaboradores.edit', $colaborador) }}" class="btn btn-warning me-2">
            <i class="fas fa-edit me-1"></i>
            Editar
        </a>
        <form action="{{ route('colaboradores.destroy', $colaborador) }}" 
              method="POST" 
              class="d-inline"
              onsubmit="return confirm('Tem certeza que deseja remover este colaborador?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-trash me-1"></i>
                Excluir
            </button>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Informações do Colaborador
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-id-card me-1 text-muted"></i>
                            Prontuário
                        </label>
                        <p class="form-control-plaintext">{{ $colaborador->prontuario }}</p>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-user me-1 text-muted"></i>
                            Nome Completo
                        </label>
                        <p class="form-control-plaintext">{{ $colaborador->nome }}</p>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-calendar-plus me-1 text-muted"></i>
                            Data de Admissão
                        </label>
                        <p class="form-control-plaintext">
                            @if($colaborador->data_admissao)
                                {{ $colaborador->data_admissao->format('d/m/Y') }}
                            @else
                                <span class="text-muted">Não informado</span>
                            @endif
                        </p>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-phone me-1 text-muted"></i>
                            Contato
                        </label>
                        <p class="form-control-plaintext">
                            @if($colaborador->contato)
                                {{ $colaborador->contato }}
                            @else
                                <span class="text-muted">Não informado</span>
                            @endif
                        </p>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-birthday-cake me-1 text-muted"></i>
                            Data de Aniversário
                        </label>
                        <p class="form-control-plaintext">
                            @if($colaborador->data_aniversario)
                                {{ $colaborador->data_aniversario->format('d/m/Y') }}
                            @else
                                <span class="text-muted">Não informado</span>
                            @endif
                        </p>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-briefcase me-1 text-muted"></i>
                            Cargo
                        </label>
                        <p class="form-control-plaintext">
                            @if($colaborador->cargo)
                                {{ $colaborador->cargo }}
                            @else
                                <span class="text-muted">Não informado</span>
                            @endif
                        </p>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-toggle-on me-1 text-muted"></i>
                            Status
                        </label>
                        <p class="form-control-plaintext">
                            @if($colaborador->status === 'ativo')
                                <span class="badge bg-success fs-6">
                                    <i class="fas fa-check me-1"></i>
                                    Ativo
                                </span>
                            @else
                                <span class="badge bg-danger fs-6">
                                    <i class="fas fa-times me-1"></i>
                                    Inativo
                                </span>
                            @endif
                        </p>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-calendar me-1 text-muted"></i>
                            Data de Cadastro
                        </label>
                        <p class="form-control-plaintext">
                            {{ $colaborador->created_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                </div>
                
                @if($colaborador->updated_at != $colaborador->created_at)
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-edit me-1 text-muted"></i>
                                Última Atualização
                            </label>
                            <p class="form-control-plaintext">
                                {{ $colaborador->updated_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-cog me-2"></i>
                    Ações Rápidas
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('colaboradores.edit', $colaborador) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>
                        Editar Informações
                    </a>
                    
                    @if($colaborador->telefone)
                        <a href="tel:{{ $colaborador->telefone }}" class="btn btn-info">
                            <i class="fas fa-phone me-2"></i>
                            Ligar para {{ $colaborador->nome }}
                        </a>
                    @endif
                    
                    <a href="mailto:{{ $colaborador->email }}" class="btn btn-secondary">
                        <i class="fas fa-envelope me-2"></i>
                        Enviar Email
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-chart-bar me-2"></i>
                    Estatísticas
                </h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-12 mb-3">
                        <div class="border rounded p-3">
                            <i class="fas fa-calendar-alt fa-2x text-primary mb-2"></i>
                            <h6 class="mb-1">Tempo de Empresa</h6>
                            <small class="text-muted">
                                {{ $colaborador->created_at->diffForHumans() }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Botões de Navegação -->
<div class="mt-4">
    <div class="d-flex justify-content-between">
        <a href="{{ route('colaboradores.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>
            Voltar à Lista
        </a>
        
        <div>
            <a href="{{ route('colaboradores.edit', $colaborador) }}" class="btn btn-warning me-2">
                <i class="fas fa-edit me-2"></i>
                Editar
            </a>
            <form action="{{ route('colaboradores.destroy', $colaborador) }}" 
                  method="POST" 
                  class="d-inline"
                  onsubmit="return confirm('Tem certeza que deseja remover este colaborador?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash me-2"></i>
                    Excluir
                </button>
            </form>
        </div>
    </div>
</div>

@endsection