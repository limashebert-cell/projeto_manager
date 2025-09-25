@extends('layouts.app')

@section('title', 'Histórico de Presença - Painel Administrativo')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-history me-2 text-info"></i>
        Histórico de Presença
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('presencas.index') }}" class="btn btn-outline-warning me-2">
            <i class="fas fa-clipboard-check me-1"></i>
            Registrar Presença
        </a>
        <div class="badge bg-primary fs-6">
            <i class="fas fa-calendar me-1"></i>
            {{ now()->format('d/m/Y') }}
        </div>
    </div>
</div>

<!-- Filtros de Data -->
<div class="row mb-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('presencas.historico') }}" class="row g-3">
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
                    <div class="col-md-4">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i>
                                Filtrar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-light">
            <div class="card-body text-center">
                <h6 class="card-title">Período Selecionado</h6>
                <p class="mb-0">
                    <strong>{{ \Carbon\Carbon::parse($dataInicio)->format('d/m/Y') }}</strong>
                    até
                    <strong>{{ \Carbon\Carbon::parse($dataFim)->format('d/m/Y') }}</strong>
                </p>
            </div>
        </div>
    </div>
</div>

@if($presencas->count() > 0)
    <!-- Histórico por Data -->
    @foreach($presencas as $data => $presencasDia)
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-calendar-day me-2"></i>
                        {{ \Carbon\Carbon::parse($data)->format('d/m/Y') }} - 
                        {{ \Carbon\Carbon::parse($data)->locale('pt_BR')->dayName }}
                    </h5>
                    <div class="badge-group">
                        @php
                            $estatisticas = $presencasDia->groupBy('status');
                            $total = $presencasDia->count();
                        @endphp
                        @if($estatisticas->has('presente'))
                            <span class="badge bg-success me-1">
                                {{ $estatisticas['presente']->count() }} Presente(s)
                            </span>
                        @endif
                        @if($estatisticas->has('falta'))
                            <span class="badge bg-danger me-1">
                                {{ $estatisticas['falta']->count() }} Falta(s)
                            </span>
                        @endif
                        @if($estatisticas->has('atestado'))
                            <span class="badge bg-warning me-1">
                                {{ $estatisticas['atestado']->count() }} Atestado(s)
                            </span>
                        @endif
                        @if($estatisticas->has('banco_horas'))
                            <span class="badge bg-info me-1">
                                {{ $estatisticas['banco_horas']->count() }} Banco Horas
                            </span>
                        @endif
                        <span class="badge bg-secondary">
                            Total: {{ $total }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 15%">Prontuário</th>
                                <th style="width: 25%">Nome</th>
                                <th style="width: 15%">Cargo</th>
                                <th style="width: 15%">Status</th>
                                <th style="width: 30%">Observações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($presencasDia->sortBy('colaborador.nome') as $presenca)
                                <tr>
                                    <td class="align-middle">
                                        <span class="badge bg-light text-dark">
                                            {{ $presenca->colaborador->prontuario }}
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        <strong>{{ $presenca->colaborador->nome }}</strong>
                                    </td>
                                    <td class="align-middle">
                                        <span class="badge bg-info">
                                            {{ $presenca->colaborador->cargo }}
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        <span class="badge bg-{{ $presenca->status_cor }}">
                                            @if($presenca->status == 'presente')
                                                ✅ {{ $presenca->status_formatado }}
                                            @elseif($presenca->status == 'falta')
                                                ❌ {{ $presenca->status_formatado }}
                                            @elseif($presenca->status == 'atestado')
                                                📋 {{ $presenca->status_formatado }}
                                            @elseif($presenca->status == 'banco_horas')
                                                🕐 {{ $presenca->status_formatado }}
                                            @endif
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        @if($presenca->observacoes)
                                            <small class="text-muted">{{ $presenca->observacoes }}</small>
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
    @endforeach
    
    <!-- Resumo Geral -->
    <div class="card bg-light">
        <div class="card-body">
            <h6 class="card-title">
                <i class="fas fa-chart-pie me-2"></i>
                Resumo do Período
            </h6>
            @php
                $resumoGeral = $presencas->flatten()->groupBy('status');
                $totalGeral = $presencas->flatten()->count();
            @endphp
            <div class="row text-center">
                <div class="col-md-3">
                    <div class="bg-success text-white p-3 rounded">
                        <h4>{{ $resumoGeral->has('presente') ? $resumoGeral['presente']->count() : 0 }}</h4>
                        <small>Presentes</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="bg-danger text-white p-3 rounded">
                        <h4>{{ $resumoGeral->has('falta') ? $resumoGeral['falta']->count() : 0 }}</h4>
                        <small>Faltas</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="bg-warning text-white p-3 rounded">
                        <h4>{{ $resumoGeral->has('atestado') ? $resumoGeral['atestado']->count() : 0 }}</h4>
                        <small>Atestados</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="bg-info text-white p-3 rounded">
                        <h4>{{ $resumoGeral->has('banco_horas') ? $resumoGeral['banco_horas']->count() : 0 }}</h4>
                        <small>Banco Horas</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@else
    <!-- Nenhum registro encontrado -->
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fas fa-calendar-times fa-4x text-muted mb-4"></i>
            <h3 class="text-muted mb-3">Nenhum registro encontrado</h3>
            <p class="text-muted mb-4">
                Não há registros de presença para o período selecionado.
            </p>
            <a href="{{ route('presencas.index') }}" class="btn btn-warning btn-lg">
                <i class="fas fa-clipboard-check me-2"></i>
                Registrar Presença
            </a>
        </div>
    </div>
@endif

@endsection