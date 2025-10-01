@extends('layouts.app')

@section('title', 'Auditoria de Presenças - Painel Administrativo')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-clipboard-list me-2 text-info"></i>
        Auditoria de Presenças
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="badge bg-info fs-6">
            <i class="fas fa-database me-1"></i>
            Registros de Auditoria
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Filtro por Data -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-filter me-2"></i>
                    Filtrar por Período
                </h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('auditoria.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <label for="data_inicio" class="form-label">Data Início</label>
                        <input type="date" 
                               name="data_inicio" 
                               id="data_inicio" 
                               value="{{ $dataInicio }}" 
                               class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label for="data_fim" class="form-label">Data Fim</label>
                        <input type="date" 
                               name="data_fim" 
                               id="data_fim" 
                               value="{{ $dataFim }}" 
                               class="form-control">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i>
                            Filtrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if($auditorias->count() > 0)
    <!-- Lista de Auditorias -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-list me-2"></i>
                Registros de Auditoria ({{ $auditorias->total() }})
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Data/Hora do Registro</th>
                            <th>Data das Presenças</th>
                            <th>Total Colaboradores</th>
                            <th>Presentes</th>
                            <th>Ausentes</th>
                            <th>Justificados</th>
                            <th>IP</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($auditorias as $auditoria)
                            <tr>
                                <td>
                                    <i class="fas fa-clock me-1 text-muted"></i>
                                    {{ $auditoria->created_at->format('d/m/Y H:i:s') }}
                                </td>
                                <td>
                                    <span class="badge bg-primary">
                                        {{ $auditoria->data_registro->format('d/m/Y') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">
                                        {{ $auditoria->total_colaboradores }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-success">
                                        {{ $auditoria->total_presentes }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-danger">
                                        {{ $auditoria->total_ausentes }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-warning">
                                        {{ $auditoria->total_justificados }}
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $auditoria->ip_address }}</small>
                                </td>
                                <td>
                                    <a href="{{ route('auditoria.show', $auditoria->id) }}" 
                                       class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-eye"></i>
                                        Detalhes
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $auditorias->withQueryString()->links() }}
        </div>
    </div>
@else
    <!-- Nenhuma auditoria encontrada -->
    <div class="card">
        <div class="card-body text-center py-5">
            <div class="mb-4">
                <i class="fas fa-search fa-3x text-muted"></i>
            </div>
            <h5 class="text-muted">Nenhum registro de auditoria encontrado</h5>
            <p class="text-muted">
                Não foram encontrados registros de auditoria para o período selecionado.
            </p>
            <a href="{{ route('presencas.index') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>
                Registrar Presenças
            </a>
        </div>
    </div>
@endif

@endsection