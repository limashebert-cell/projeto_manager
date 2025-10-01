@extends('layouts.app')

@section('title', 'Detalhes do Usuário - Painel Administrativo')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-user me-2 text-primary"></i>
        Detalhes do Usuário
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>Editar
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Voltar
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Informações Pessoais
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">
                                <i class="fas fa-user me-2"></i>Nome Completo
                            </label>
                            <p class="h5">{{ $user->name }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted">
                                <i class="fas fa-at me-2"></i>Nome de Usuário
                            </label>
                            <p><code class="fs-6">{{ $user->username }}</code></p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">
                                <i class="fas fa-building me-2"></i>Área de Trabalho
                            </label>
                            <p>
                                <span class="badge bg-info fs-6">{{ $user->area }}</span>
                            </p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted">
                                <i class="fas fa-shield-alt me-2"></i>Tipo de Usuário
                            </label>
                            <p>
                                <span class="badge bg-{{ $user->role === 'super_admin' ? 'danger' : 'primary' }} fs-6">
                                    {{ $user->getRoleName() }}
                                </span>
                            </p>
                        </div>
                        
                        <!-- NOVO CAMPO NIVEL -->
                        <div class="mb-3" style="border: 2px solid #28a745; border-radius: 8px; padding: 15px; background: #f8fff9;">
                            <label class="form-label text-muted">
                                <i class="fas fa-star me-2 text-success"></i>Nível 
                                <span class="badge bg-success ms-2">NOVO</span>
                            </label>
                            <p>
                                <span class="badge bg-success fs-6">
                                    {{ $user->getNivelName() }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
                
                <hr>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">
                                <i class="fas fa-toggle-on me-2"></i>Status
                            </label>
                            <p>
                                @if($user->active)
                                    <span class="badge bg-success fs-6">
                                        <i class="fas fa-check me-1"></i>Ativo
                                    </span>
                                @else
                                    <span class="badge bg-danger fs-6">
                                        <i class="fas fa-times me-1"></i>Inativo
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">
                                <i class="fas fa-calendar-plus me-2"></i>Cadastrado em
                            </label>
                            <p>{{ $user->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
                
                @if($user->updated_at != $user->created_at)
                    <div class="mb-3">
                        <label class="form-label text-muted">
                            <i class="fas fa-calendar-edit me-2"></i>Última atualização
                        </label>
                        <p>{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-link me-2"></i>
                    Registros Relacionados
                </h6>
            </div>
            <div class="card-body">
                @if($totalRelacionamentos > 0)
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Atenção!</strong> Este usuário possui {{ $totalRelacionamentos }} registro(s) relacionado(s).
                        <br><small>A exclusão não será permitida até que esses registros sejam transferidos ou removidos.</small>
                    </div>
                @else
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>OK!</strong> Este usuário não possui registros relacionados e pode ser excluído com segurança.
                    </div>
                @endif
                
                <div class="list-group list-group-flush">
                    @if($relacionamentos['colaboradores'] > 0)
                        <div class="list-group-item d-flex justify-content-between align-items-center p-2">
                            <span><i class="fas fa-users me-2 text-primary"></i>Colaboradores</span>
                            <span class="badge bg-primary rounded-pill">{{ $relacionamentos['colaboradores'] }}</span>
                        </div>
                    @endif
                    
                    @if($relacionamentos['presencas'] > 0)
                        <div class="list-group-item d-flex justify-content-between align-items-center p-2">
                            <span><i class="fas fa-calendar-check me-2 text-success"></i>Presenças</span>
                            <span class="badge bg-success rounded-pill">{{ $relacionamentos['presencas'] }}</span>
                        </div>
                    @endif
                    
                    @if($relacionamentos['historicos'] > 0)
                        <div class="list-group-item d-flex justify-content-between align-items-center p-2">
                            <span><i class="fas fa-history me-2 text-info"></i>Histórico Presença</span>
                            <span class="badge bg-info rounded-pill">{{ $relacionamentos['historicos'] }}</span>
                        </div>
                    @endif
                    
                    @if($relacionamentos['auditorias'] > 0)
                        <div class="list-group-item d-flex justify-content-between align-items-center p-2">
                            <span><i class="fas fa-search me-2 text-warning"></i>Auditorias</span>
                            <span class="badge bg-warning rounded-pill">{{ $relacionamentos['auditorias'] }}</span>
                        </div>
                    @endif
                    
                    @if($relacionamentos['timeclocks'] > 0)
                        <div class="list-group-item d-flex justify-content-between align-items-center p-2">
                            <span><i class="fas fa-clock me-2 text-secondary"></i>Registros Ponto</span>
                            <span class="badge bg-secondary rounded-pill">{{ $relacionamentos['timeclocks'] }}</span>
                        </div>
                    @endif
                    
                    @if($relacionamentos['quase_acidentes'] > 0)
                        <div class="list-group-item d-flex justify-content-between align-items-center p-2">
                            <span><i class="fas fa-exclamation-triangle me-2 text-danger"></i>Quase Acidentes</span>
                            <span class="badge bg-danger rounded-pill">{{ $relacionamentos['quase_acidentes'] }}</span>
                        </div>
                    @endif
                    
                    @if($totalRelacionamentos == 0)
                        <div class="list-group-item text-center p-3 text-muted">
                            <i class="fas fa-inbox fa-2x mb-2"></i>
                            <br>Nenhum registro relacionado
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-cogs me-2"></i>
                    Ações
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Editar Usuário
                    </a>
                    
                    <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                                class="btn btn-{{ $user->active ? 'secondary' : 'success' }} w-100"
                                onclick="return confirm('Tem certeza que deseja {{ $user->active ? 'desativar' : 'ativar' }} este usuário?')">
                            <i class="fas fa-{{ $user->active ? 'pause' : 'play' }} me-2"></i>
                            {{ $user->active ? 'Desativar' : 'Ativar' }} Usuário
                        </button>
                    </form>
                    
                    @if($totalRelacionamentos == 0)
                        <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" 
                              onsubmit="return confirm('Tem certeza que deseja excluir este usuário? Esta ação não pode ser desfeita.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash me-2"></i>Excluir Usuário
                            </button>
                        </form>
                    @else
                        <button type="button" class="btn btn-danger w-100" disabled title="Usuário possui registros relacionados">
                            <i class="fas fa-trash me-2"></i>Exclusão Bloqueada
                        </button>
                        <small class="text-muted d-block mt-2 text-center">
                            Para excluir, primeiro transfira ou remova os registros relacionados.
                        </small>
                    @endif
                    
                    @if($user->role !== 'super_admin')
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="btn btn-danger w-100"
                                    onclick="return confirm('Tem certeza que deseja excluir este usuário? Esta ação não pode ser desfeita.')">
                                <i class="fas fa-trash me-2"></i>Excluir Usuário
                            </button>
                        </form>
                    @endif
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
                    <div class="col-6">
                        <div class="border-end">
                            <h4 class="text-primary">{{ $user->id }}</h4>
                            <small class="text-muted">ID do Usuário</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <h4 class="text-success">{{ $user->created_at->diffInDays() }}</h4>
                        <small class="text-muted">Dias no Sistema</small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-info me-2"></i>
                    Informações do Sistema
                </h6>
            </div>
            <div class="card-body">
                <small class="text-muted d-block mb-2">
                    <i class="fas fa-database me-1"></i>
                    ID único: <code>#{{ $user->id }}</code>
                </small>
                <small class="text-muted d-block mb-2">
                    <i class="fas fa-clock me-1"></i>
                    Timezone: {{ config('app.timezone') }}
                </small>
                <small class="text-muted d-block">
                    <i class="fas fa-code me-1"></i>
                    Laravel {{ app()->version() }}
                </small>
            </div>
        </div>
    </div>
</div>

@endsection