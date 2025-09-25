@extends('layouts.app')

@section('title', 'Histórico de Alterações - Presenças')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-history"></i> Histórico de Alterações - Presenças
                    </h4>
                    <div class="btn-group">
                        <a href="{{ route('presencas.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-calendar-check"></i> Registro de Presenças
                        </a>
                        <a href="{{ route('presencas.historico') }}" class="btn btn-outline-info">
                            <i class="fas fa-list"></i> Histórico Geral
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <!-- Filtros -->
                    <form method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="data_inicio">Data Início:</label>
                                <input type="date" name="data_inicio" id="data_inicio" 
                                       class="form-control form-control-sm" 
                                       value="{{ $dataInicio }}" required>
                            </div>
                            <div class="col-md-3">
                                <label for="data_fim">Data Fim:</label>
                                <input type="date" name="data_fim" id="data_fim" 
                                       class="form-control form-control-sm" 
                                       value="{{ $dataFim }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="colaborador_id">Colaborador:</label>
                                <select name="colaborador_id" id="colaborador_id" class="form-control form-control-sm">
                                    <option value="">Todos os colaboradores</option>
                                    @foreach($colaboradores as $colaborador)
                                        <option value="{{ $colaborador->id }}" 
                                                {{ $colaboradorId == $colaborador->id ? 'selected' : '' }}>
                                            {{ $colaborador->nome }} ({{ $colaborador->prontuario }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary btn-sm w-100">
                                    <i class="fas fa-filter"></i> Filtrar
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    @if($historico->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-sm">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Data/Hora</th>
                                        <th>Colaborador</th>
                                        <th>Data da Presença</th>
                                        <th>Ação</th>
                                        <th>Status Anterior</th>
                                        <th>Novo Status</th>
                                        <th>Observações</th>
                                        <th>IP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($historico as $item)
                                        <tr>
                                            <td>
                                                <small>{{ $item->created_at->format('d/m/Y H:i:s') }}</small>
                                            </td>
                                            <td>
                                                <strong>{{ $item->colaborador->nome }}</strong><br>
                                                <small class="text-muted">{{ $item->colaborador->prontuario }}</small>
                                            </td>
                                            <td>
                                                {{ Carbon\Carbon::parse($item->data_presenca)->format('d/m/Y') }}
                                            </td>
                                            <td>
                                                @if($item->acao == 'criado')
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-plus"></i> {{ $item->getAcaoFormatada() }}
                                                    </span>
                                                @elseif($item->acao == 'editado')
                                                    <span class="badge bg-warning">
                                                        <i class="fas fa-edit"></i> {{ $item->getAcaoFormatada() }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger">
                                                        <i class="fas fa-trash"></i> {{ $item->getAcaoFormatada() }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->status_anterior)
                                                    @php
                                                        $statusClass = '';
                                                        switch($item->status_anterior) {
                                                            case 'presente': $statusClass = 'bg-success'; break;
                                                            case 'falta': $statusClass = 'bg-danger'; break;
                                                            case 'atestado': $statusClass = 'bg-info'; break;
                                                            case 'banco_horas': $statusClass = 'bg-secondary'; break;
                                                        }
                                                    @endphp
                                                    <span class="badge {{ $statusClass }}">
                                                        {{ $item->getStatusAnteriorFormatado() }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $statusClass = '';
                                                    switch($item->status_novo) {
                                                        case 'presente': $statusClass = 'bg-success'; break;
                                                        case 'falta': $statusClass = 'bg-danger'; break;
                                                        case 'atestado': $statusClass = 'bg-info'; break;
                                                        case 'banco_horas': $statusClass = 'bg-secondary'; break;
                                                    }
                                                @endphp
                                                <span class="badge {{ $statusClass }}">
                                                    {{ $item->getStatusNovoFormatado() }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($item->observacoes_nova || $item->observacoes_anterior)
                                                    <div>
                                                        @if($item->observacoes_anterior && $item->acao == 'editado')
                                                            <small class="text-muted">
                                                                <strong>Anterior:</strong> {{ Str::limit($item->observacoes_anterior, 30) }}
                                                            </small><br>
                                                        @endif
                                                        @if($item->observacoes_nova)
                                                            <small>
                                                                <strong>Nova:</strong> {{ Str::limit($item->observacoes_nova, 30) }}
                                                            </small>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $item->ip_address }}</small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Paginação -->
                        <div class="d-flex justify-content-center">
                            {{ $historico->appends(request()->query())->links() }}
                        </div>
                        
                        <!-- Estatísticas -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">Estatísticas do Período</h6>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="text-center">
                                                    <h4 class="text-primary">{{ $historico->where('acao', 'criado')->count() }}</h4>
                                                    <small class="text-muted">Registros Criados</small>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="text-center">
                                                    <h4 class="text-warning">{{ $historico->where('acao', 'editado')->count() }}</h4>
                                                    <small class="text-muted">Registros Editados</small>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="text-center">
                                                    <h4 class="text-danger">{{ $historico->where('acao', 'excluido')->count() }}</h4>
                                                    <small class="text-muted">Registros Excluídos</small>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="text-center">
                                                    <h4 class="text-success">{{ $historico->total() }}</h4>
                                                    <small class="text-muted">Total de Alterações</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-history fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Nenhuma alteração encontrada</h5>
                            <p class="text-muted">Não há histórico de alterações para o período selecionado.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.badge {
    font-size: 0.75em;
}
.table-sm th,
.table-sm td {
    padding: 0.5rem;
    vertical-align: middle;
}
</style>
@endpush