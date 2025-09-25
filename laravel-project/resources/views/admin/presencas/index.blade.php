@extends('layouts.app')

@section('title', 'Controle de Presença - Painel Administrativo')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-clipboard-check me-2 text-warning"></i>
        Atestar Absenteísmo
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('presencas.historico') }}" class="btn btn-outline-primary me-2">
            <i class="fas fa-history me-1"></i>
            Histórico
        </a>
        <a href="{{ route('auditoria.index') }}" class="btn btn-outline-info me-2">
            <i class="fas fa-clipboard-list me-1"></i>
            Auditoria
        </a>
        <div class="badge bg-primary fs-6">
            <i class="fas fa-calendar me-1"></i>
            {{ $dataFormatada->format('d/m/Y') }}
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

<!-- Seletor de Data -->
<div class="row mb-4">
    <div class="col-md-4">
        <form method="GET" action="{{ route('presencas.index') }}" class="d-flex">
            <input type="date" 
                   name="data" 
                   value="{{ $data }}" 
                   class="form-control me-2"
                   onchange="this.form.submit()">
        </form>
    </div>
</div>

@if($colaboradores->count() > 0)
    <!-- Formulário de Presença -->
    <form method="POST" action="{{ route('presencas.store') }}">
        @csrf
        <input type="hidden" name="data" value="{{ $data }}">
        
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-users me-2"></i>
                        Lista de Colaboradores - {{ $dataFormatada->format('d/m/Y') }}
                    </h5>
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-outline-success" onclick="marcarTodos('presente')">
                            <i class="fas fa-check me-1"></i>
                            Todos Presentes
                        </button>
                        <button type="button" class="btn btn-outline-danger" onclick="marcarTodos('falta')">
                            <i class="fas fa-times me-1"></i>
                            Todos Falta
                        </button>
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
                                <th style="width: 20%">Status</th>
                                <th style="width: 25%">Observações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($colaboradores as $colaborador)
                                @php
                                    $presencaExistente = $presencasExistentes->get($colaborador->id);
                                    $statusAtual = $presencaExistente ? $presencaExistente->status : 'presente';
                                    $observacoesAtuais = $presencaExistente ? $presencaExistente->observacoes : '';
                                @endphp
                                <tr>
                                    <td class="align-middle">
                                        <span class="badge bg-light text-dark">{{ $colaborador->prontuario }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <strong>{{ $colaborador->nome }}</strong>
                                    </td>
                                    <td class="align-middle">
                                        <span class="badge bg-info">{{ $colaborador->cargo }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <input type="hidden" name="presencas[{{ $loop->index }}][colaborador_id]" value="{{ $colaborador->id }}">
                                        
                                        <select name="presencas[{{ $loop->index }}][status]" 
                                                class="form-select form-select-sm status-select" 
                                                data-row="{{ $loop->index }}"
                                                required>
                                            <option value="presente" {{ $statusAtual == 'presente' ? 'selected' : '' }}>
                                                ✅ Presente
                                            </option>
                                            <option value="falta" {{ $statusAtual == 'falta' ? 'selected' : '' }}>
                                                ❌ Falta
                                            </option>
                                            <option value="atestado" {{ $statusAtual == 'atestado' ? 'selected' : '' }}>
                                                📋 Atestado
                                            </option>
                                            <option value="banco_horas" {{ $statusAtual == 'banco_horas' ? 'selected' : '' }}>
                                                🕐 Banco de Horas
                                            </option>
                                        </select>
                                    </td>
                                    <td class="align-middle">
                                        <textarea name="presencas[{{ $loop->index }}][observacoes]" 
                                                  class="form-control form-control-sm observacoes-field" 
                                                  rows="2" 
                                                  placeholder="Observações..."
                                                  data-row="{{ $loop->index }}">{{ $observacoesAtuais }}</textarea>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Total de {{ $colaboradores->count() }} colaborador(es)
                    </div>
                    <div>
                        <a href="{{ route('admin.timeclock.index') }}" class="btn btn-secondary me-2">
                            <i class="fas fa-arrow-left me-1"></i>
                            Voltar
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save me-2"></i>
                            Salvar Presenças
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@else
    <!-- Nenhum colaborador cadastrado -->
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fas fa-users-slash fa-4x text-muted mb-4"></i>
            <h3 class="text-muted mb-3">Nenhum colaborador cadastrado</h3>
            <p class="text-muted mb-4">
                Você precisa cadastrar colaboradores antes de poder controlar a presença.
            </p>
            <a href="{{ route('colaboradores.create') }}" class="btn btn-success btn-lg">
                <i class="fas fa-user-plus me-2"></i>
                Cadastrar Primeiro Colaborador
            </a>
        </div>
    </div>
@endif

<script>
    function marcarTodos(status) {
        const selects = document.querySelectorAll('.status-select');
        selects.forEach(select => {
            select.value = status;
            // Trigger change event para mostrar/ocultar campos de observação se necessário
            select.dispatchEvent(new Event('change'));
        });
    }
    
    // Mostrar/ocultar campo de observações baseado no status
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelects = document.querySelectorAll('.status-select');
        
        statusSelects.forEach(select => {
            select.addEventListener('change', function() {
                const row = this.dataset.row;
                const observacoesField = document.querySelector(`textarea[data-row="${row}"]`);
                
                if (this.value === 'presente') {
                    observacoesField.style.display = 'none';
                    observacoesField.value = '';
                } else {
                    observacoesField.style.display = 'block';
                    if (this.value === 'atestado') {
                        observacoesField.placeholder = 'Detalhes do atestado...';
                    } else if (this.value === 'banco_horas') {
                        observacoesField.placeholder = 'Motivo do uso do banco de horas...';
                    } else {
                        observacoesField.placeholder = 'Motivo da falta...';
                    }
                }
            });
            
            // Trigger inicial
            select.dispatchEvent(new Event('change'));
        });
    });
</script>

@endsection