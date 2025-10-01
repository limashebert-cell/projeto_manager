@extends('layouts.app')

@section('title', 'Histórico de Presença - Painel Administrativo')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <div>
        <h1 class="h2">
            <i class="fas fa-history me-2 text-info"></i>
            Histórico de Presença
        </h1>
        <p class="text-muted mb-0">
            <i class="fas fa-user-tie me-1"></i>
            Gerente: <strong>{{ Auth::user()->name }}</strong>
            <span class="ms-3">
                <i class="fas fa-users me-1"></i>
                Colaboradores: <strong>{{ Auth::user()->colaboradores->where('status', 'ativo')->count() }}</strong>
            </span>
        </p>
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('presencas.index') }}" class="btn btn-outline-warning me-2">
            <i class="fas fa-clipboard-check me-1"></i>
            Registrar Presença
        </a>
        <a href="{{ route('presencas.historico-alteracoes') }}" class="btn btn-outline-info me-2">
            <i class="fas fa-list-alt me-1"></i>
            Log de Alterações
        </a>
        <button type="button" class="btn btn-success me-2" onclick="exportarHistoricoGeralCSV()">
            <i class="fas fa-file-csv me-1"></i>
            Exportar CSV
        </button>
        <div class="btn-group me-2" role="group">
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="expandAll()">
                <i class="fas fa-expand-arrows-alt me-1"></i>
                Expandir Todos
            </button>
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="collapseAll()">
                <i class="fas fa-compress-arrows-alt me-1"></i>
                Recolher Todos
            </button>
        </div>
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
    <!-- Histórico por Data - Accordion -->
    <div class="accordion" id="historicoAccordion">
    @foreach($presencas as $data => $presencasDia)
        @php
            $isFirst = $loop->first; // Primeiro item (mais recente) fica aberto
            $accordionId = 'collapse' . str_replace('-', '', $data);
        @endphp
        <div class="accordion-item mb-3">
            <h2 class="accordion-header" id="heading{{ $accordionId }}">
                <button class="accordion-button {{ $isFirst ? '' : 'collapsed' }}" 
                        type="button" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#{{ $accordionId }}" 
                        aria-expanded="{{ $isFirst ? 'true' : 'false' }}" 
                        aria-controls="{{ $accordionId }}">
                    <div class="d-flex justify-content-between align-items-center w-100 me-3">
                        <div>
                            <i class="fas fa-calendar-day me-2"></i>
                            <strong>{{ \Carbon\Carbon::parse($data)->format('d/m/Y') }}</strong> - 
                            {{ \Carbon\Carbon::parse($data)->locale('pt_BR')->dayName }}
                        </div>
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
                </button>
            </h2>
            <div id="{{ $accordionId }}" 
                 class="accordion-collapse collapse {{ $isFirst ? 'show' : '' }}" 
                 aria-labelledby="heading{{ $accordionId }}" 
                 data-bs-parent="#historicoAccordion">
                <div class="accordion-body p-0">
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
                                        @if($presenca->status)
                                            <span class="badge bg-{{ $presenca->status_cor ?? ($presenca->status == 'presente' ? 'success' : ($presenca->status == 'falta' ? 'danger' : ($presenca->status == 'atestado' ? 'warning' : 'info'))) }}">
                                                @if($presenca->status == 'presente')
                                                    ✅ {{ $presenca->status_formatado ?? 'Presente' }}
                                                @elseif($presenca->status == 'falta')
                                                    ❌ {{ $presenca->status_formatado ?? 'Falta' }}
                                                @elseif($presenca->status == 'atestado')
                                                    📋 {{ $presenca->status_formatado ?? 'Atestado' }}
                                                @elseif($presenca->status == 'banco_horas')
                                                    🕐 {{ $presenca->status_formatado ?? 'Banco de Horas' }}
                                                @else
                                                    ❓ {{ $presenca->status_formatado ?? ucfirst($presenca->status) }}
                                                @endif
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                ⏳ Não Registrado
                                            </span>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        @if(isset($presenca->observacoes) && $presenca->observacoes)
                                            <small class="text-muted">{{ $presenca->observacoes }}</small>
                                        @elseif(!$presenca->status)
                                            <small class="text-warning">
                                                <i class="fas fa-exclamation-triangle me-1"></i>
                                                Aguardando registro
                                            </small>
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
        </div>
    @endforeach
    </div>
    
    <!-- Resumo Geral -->
    <div class="row">
        <div class="col-md-8">
            <div class="card bg-light">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="fas fa-chart-pie me-2"></i>
                        Resumo do Período
                    </h6>
                    @php
                        $resumoGeral = $presencas->flatten()->filter(function($p) { return isset($p->status); })->groupBy('status');
                        $totalGeral = $presencas->flatten()->count();
                        $totalRegistrado = $presencas->flatten()->filter(function($p) { return isset($p->status); })->count();
                        $totalNaoRegistrado = $totalGeral - $totalRegistrado;
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
                    <div class="row text-center mt-3">
                        <div class="col-md-6">
                            <div class="bg-secondary text-white p-2 rounded">
                                <h5>{{ $totalNaoRegistrado }}</h5>
                                <small>Não Registrados</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-dark text-white p-2 rounded">
                                <h5>{{ $totalGeral }}</h5>
                                <small>Total de Registros</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-light">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="fas fa-users me-2"></i>
                        Colaboradores Ativos
                    </h6>
                    <div class="text-center">
                        <div class="bg-primary text-white p-3 rounded">
                            <h3>{{ Auth::user()->colaboradores->where('status', 'ativo')->count() }}</h3>
                            <small>Total de Colaboradores</small>
                        </div>
                        <p class="mt-3 mb-0 text-muted">
                            <small>
                                <i class="fas fa-info-circle me-1"></i>
                                Período: {{ \Carbon\Carbon::parse($dataInicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($dataFim)->format('d/m/Y') }}
                            </small>
                        </p>
                        <p class="mb-0 text-muted mt-1">
                            <small>
                                <i class="fas fa-keyboard me-1"></i>
                                Atalhos: <kbd>Ctrl+O</kbd> Expandir | <kbd>Ctrl+F</kbd> Recolher
                            </small>
                        </p>
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

@push('styles')
<style>
    .accordion-button {
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }
    
    .accordion-button:not(.collapsed) {
        background-color: #e3f2fd;
        border-color: #2196f3;
        color: #1976d2;
    }
    
    .accordion-button:focus {
        box-shadow: 0 0 0 0.25rem rgba(33, 150, 243, 0.25);
    }
    
    .accordion-item {
        border: 1px solid #dee2e6;
        border-radius: 0.5rem !important;
    }
    
    .badge-group .badge {
        font-size: 0.75em;
    }
    
    .accordion-body .table {
        margin-bottom: 0;
    }
</style>
@endpush

@push('scripts')
<script>
    function expandAll() {
        const collapses = document.querySelectorAll('.accordion-collapse');
        collapses.forEach(collapse => {
            if (!collapse.classList.contains('show')) {
                const bsCollapse = new bootstrap.Collapse(collapse);
                bsCollapse.show();
            }
        });
    }

    function collapseAll() {
        const collapses = document.querySelectorAll('.accordion-collapse');
        collapses.forEach(collapse => {
            if (collapse.classList.contains('show')) {
                const bsCollapse = new bootstrap.Collapse(collapse);
                bsCollapse.hide();
            }
        });
    }

    // Atalhos de teclado
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey) {
            if (e.key === 'o' || e.key === 'O') {
                e.preventDefault();
                expandAll();
            } else if (e.key === 'f' || e.key === 'F') {
                e.preventDefault();
                collapseAll();
            }
        }
    });
</script>
@endpush