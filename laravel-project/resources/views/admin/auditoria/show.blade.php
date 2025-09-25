@extends('layouts.app')

@section('title', 'Detalhes da Auditoria - Painel Administrativo')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-clipboard-list me-2 text-info"></i>
        Detalhes da Auditoria
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('auditoria.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>
            Voltar
        </a>
    </div>
</div>

<!-- Informações Gerais -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Informações do Registro
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <strong>Data/Hora do Registro:</strong><br>
                        <span class="text-primary">{{ $auditoria->created_at->format('d/m/Y H:i:s') }}</span>
                    </div>
                    <div class="col-md-3">
                        <strong>Data das Presenças:</strong><br>
                        <span class="badge bg-primary">{{ $auditoria->data_registro->format('d/m/Y') }}</span>
                    </div>
                    <div class="col-md-3">
                        <strong>Endereço IP:</strong><br>
                        <span class="text-muted">{{ $auditoria->ip_address }}</span>
                    </div>
                    <div class="col-md-3">
                        <strong>Gestor:</strong><br>
                        <span class="text-info">{{ $auditoria->adminUser->name }}</span>
                    </div>
                </div>
                @if($auditoria->observacoes)
                    <div class="row mt-3">
                        <div class="col-12">
                            <strong>Observações:</strong><br>
                            <p class="text-muted mb-0">{{ $auditoria->observacoes }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Estatísticas -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center bg-light">
            <div class="card-body">
                <i class="fas fa-users fa-2x text-secondary mb-2"></i>
                <h4 class="text-secondary">{{ $auditoria->total_colaboradores }}</h4>
                <p class="card-text">Total de Colaboradores</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center bg-success text-white">
            <div class="card-body">
                <i class="fas fa-check fa-2x mb-2"></i>
                <h4>{{ $auditoria->total_presentes }}</h4>
                <p class="card-text">Presentes</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center bg-danger text-white">
            <div class="card-body">
                <i class="fas fa-times fa-2x mb-2"></i>
                <h4>{{ $auditoria->total_ausentes }}</h4>
                <p class="card-text">Ausentes</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center bg-warning text-white">
            <div class="card-body">
                <i class="fas fa-file-medical fa-2x mb-2"></i>
                <h4>{{ $auditoria->total_justificados }}</h4>
                <p class="card-text">Justificados</p>
            </div>
        </div>
    </div>
</div>

<!-- Detalhes dos Colaboradores -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-list-ul me-2"></i>
            Detalhes por Colaborador
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nome do Colaborador</th>
                        <th>Status</th>
                        <th>Observações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($auditoria->dados_presenca as $dado)
                        <tr>
                            <td>
                                <span class="badge bg-light text-dark">{{ $dado['colaborador_id'] }}</span>
                            </td>
                            <td>
                                <strong>{{ $dado['colaborador_nome'] }}</strong>
                            </td>
                            <td>
                                @switch($dado['status'])
                                    @case('presente')
                                        <span class="badge bg-success">
                                            <i class="fas fa-check me-1"></i>
                                            Presente
                                        </span>
                                        @break
                                    @case('falta')
                                        <span class="badge bg-danger">
                                            <i class="fas fa-times me-1"></i>
                                            Falta
                                        </span>
                                        @break
                                    @case('atestado')
                                        <span class="badge bg-warning">
                                            <i class="fas fa-file-medical me-1"></i>
                                            Atestado
                                        </span>
                                        @break
                                    @case('banco_horas')
                                        <span class="badge bg-info">
                                            <i class="fas fa-clock me-1"></i>
                                            Banco de Horas
                                        </span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                @if($dado['observacoes'])
                                    <small class="text-muted">{{ $dado['observacoes'] }}</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Botões de Ação -->
<div class="mt-4 d-flex justify-content-between">
    <a href="{{ route('auditoria.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>
        Voltar à Lista
    </a>
    <div>
        <a href="{{ route('presencas.index', ['data' => $auditoria->data_registro->format('Y-m-d')]) }}" 
           class="btn btn-primary">
            <i class="fas fa-calendar-check me-2"></i>
            Ver Presenças desta Data
        </a>
    </div>
</div>

@endsection