@extends('layouts.app')

@section('title', 'Auditoria de Presenças - Painel Administrativo')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-search me-2 text-info"></i>
        Auditoria de Presenças
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('presencas.index') }}" class="btn btn-outline-warning me-2">
            <i class="fas fa-arrow-left me-1"></i>
            Voltar
        </a>
        <a href="{{ route('presencas.historico') }}" class="btn btn-outline-primary me-2">
            <i class="fas fa-history me-1"></i>
            Histórico
        </a>
        <div class="badge bg-info fs-6">
            <i class="fas fa-audit me-1"></i>
            Auditoria
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

<!-- Filtros de Data -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('presencas.auditoria') }}" class="row g-3">
                    <div class="col-md-4">
                        <label for="data_inicio" class="form-label">Data Início</label>
                        <input type="date" class="form-control" id="data_inicio" name="data_inicio" value="{{ $dataInicio }}">
                    </div>
                    <div class="col-md-4">
                        <label for="data_fim" class="form-label">Data Fim</label>
                        <input type="date" class="form-control" id="data_fim" name="data_fim" value="{{ $dataFim }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary d-block">
                            <i class="fas fa-search me-1"></i>
                            Filtrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if($sessoesSalvamento->count() > 0)
    <!-- Resumo -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-save me-2"></i>
                        Total de Salvamentos
                    </h5>
                    <h2 class="mb-0">{{ $sessoesSalvamento->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-user-friends me-2"></i>
                        Registros Totais
                    </h5>
                    <h2 class="mb-0">{{ $sessoesSalvamento->flatten()->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-calendar me-2"></i>
                        Período
                    </h5>
                    <h6 class="mb-0">{{ \Carbon\Carbon::parse($dataInicio)->format('d/m/Y') }}</h6>
                    <small>até {{ \Carbon\Carbon::parse($dataFim)->format('d/m/Y') }}</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-clock me-2"></i>
                        Último Registro
                    </h5>
                    <h6 class="mb-0">{{ $sessoesSalvamento->first()->first()->data_hora_registro->format('d/m/Y') }}</h6>
                    <small>{{ $sessoesSalvamento->first()->first()->data_hora_registro->format('H:i:s') }}</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Sessões de Salvamento -->
    @foreach($sessoesSalvamento as $dataHoraSalvamento => $registros)
        @php
            $primeiroRegistro = $registros->first();
            $detalhes = $primeiroRegistro->detalhes_registro;
        @endphp
        
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">
                            <i class="fas fa-save me-2 text-primary"></i>
                            Salvamento em {{ \Carbon\Carbon::parse($dataHoraSalvamento)->format('d/m/Y H:i:s') }}
                        </h5>
                        <small class="text-muted">
                            Data da presença: {{ \Carbon\Carbon::parse($detalhes['data_presenca'])->format('d/m/Y') }} |
                            {{ $detalhes['total_colaboradores'] }} colaboradores registrados
                        </small>
                    </div>
                    <div class="text-end">
                        <small class="text-muted">
                            <i class="fas fa-network-wired me-1"></i>
                            IP: {{ $primeiroRegistro->ip_address }}
                        </small>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- Resumo de Status -->
                <div class="row mb-3">
                    <div class="col-12">
                        <h6>Resumo dos Status:</h6>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($detalhes['resumo_status'] as $status => $quantidade)
                                @php
                                    $cores = [
                                        'presente' => 'success',
                                        'falta' => 'danger',
                                        'atestado' => 'warning',
                                        'banco_horas' => 'info'
                                    ];
                                    $labels = [
                                        'presente' => 'Presente',
                                        'falta' => 'Falta',
                                        'atestado' => 'Atestado',
                                        'banco_horas' => 'Banco de Horas'
                                    ];
                                @endphp
                                <span class="badge bg-{{ $cores[$status] ?? 'secondary' }}">
                                    {{ $labels[$status] ?? $status }}: {{ $quantidade }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Detalhes dos Registros -->
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Colaborador</th>
                                <th>Status</th>
                                <th>Observações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($registros as $registro)
                                <tr>
                                    <td>
                                        <strong>{{ $registro->colaborador->nome }}</strong>
                                        @if($registro->colaborador->prontuario)
                                            <br><small class="text-muted">{{ $registro->colaborador->prontuario }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $registro->status_cor }}">
                                            {{ $registro->status_formatado }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $registro->observacoes ?? '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Informações Técnicas -->
                <div class="mt-3 pt-3 border-top">
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        <strong>Detalhes técnicos:</strong> 
                        Registrado por ID {{ $primeiroRegistro->registrado_por }} | 
                        User Agent: {{ Str::limit($primeiroRegistro->user_agent, 100) }}
                    </small>
                </div>
            </div>
        </div>
    @endforeach

@else
    <!-- Nenhum registro encontrado -->
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fas fa-search fa-3x text-muted mb-3"></i>
            <h4 class="text-muted">Nenhum registro de auditoria encontrado</h4>
            <p class="text-muted">
                Não foram encontrados registros de salvamento de presenças no período selecionado.
            </p>
            <a href="{{ route('presencas.index') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>
                Registrar Presenças
            </a>
        </div>
    </div>
@endif

@endsection