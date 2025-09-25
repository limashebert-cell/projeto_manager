@extends('layouts.app')

@section('title', 'Editar Colaborador: ' . $colaborador->nome . ' - Painel Administrativo')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-user-edit me-2 text-primary"></i>
        Editar Colaborador
    </h1>
</div>

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>Erro!</strong> Por favor, corrija os seguintes problemas:
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-form me-2"></i>
                    Dados do Colaborador
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('colaboradores.update', $colaborador) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="prontuario" class="form-label">
                                <i class="fas fa-id-card me-1"></i>
                                Prontuário *
                            </label>
                            <input type="text" 
                                   class="form-control @error('prontuario') is-invalid @enderror" 
                                   id="prontuario" 
                                   name="prontuario" 
                                   value="{{ old('prontuario', $colaborador->prontuario) }}" 
                                   required>
                            @error('prontuario')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="nome" class="form-label">
                                <i class="fas fa-user me-1"></i>
                                Nome Completo *
                            </label>
                            <input type="text" 
                                   class="form-control @error('nome') is-invalid @enderror" 
                                   id="nome" 
                                   name="nome" 
                                   value="{{ old('nome', $colaborador->nome) }}" 
                                   required>
                            @error('nome')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="data_admissao" class="form-label">
                                <i class="fas fa-calendar-plus me-1"></i>
                                Data de Admissão *
                            </label>
                            <input type="date" 
                                   class="form-control @error('data_admissao') is-invalid @enderror" 
                                   id="data_admissao" 
                                   name="data_admissao" 
                                   value="{{ old('data_admissao', $colaborador->data_admissao ? $colaborador->data_admissao->format('Y-m-d') : '') }}" 
                                   required>
                            @error('data_admissao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="contato" class="form-label">
                                <i class="fas fa-phone me-1"></i>
                                Contato *
                            </label>
                            <input type="text" 
                                   class="form-control @error('contato') is-invalid @enderror" 
                                   id="contato" 
                                   name="contato" 
                                   value="{{ old('contato', $colaborador->contato) }}" 
                                   placeholder="Telefone, celular ou email"
                                   required>
                            @error('contato')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="data_aniversario" class="form-label">
                                <i class="fas fa-birthday-cake me-1"></i>
                                Data de Aniversário *
                            </label>
                            <input type="date" 
                                   class="form-control @error('data_aniversario') is-invalid @enderror" 
                                   id="data_aniversario" 
                                   name="data_aniversario" 
                                   value="{{ old('data_aniversario', $colaborador->data_aniversario ? $colaborador->data_aniversario->format('Y-m-d') : '') }}" 
                                   required>
                            @error('data_aniversario')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="cargo" class="form-label">
                                <i class="fas fa-briefcase me-1"></i>
                                Cargo *
                            </label>
                            <select class="form-select @error('cargo') is-invalid @enderror" 
                                    id="cargo" 
                                    name="cargo" 
                                    required>
                                <option value="">Selecione o cargo</option>
                                <option value="Auxiliar" {{ old('cargo', $colaborador->cargo) === 'Auxiliar' ? 'selected' : '' }}>
                                    Auxiliar
                                </option>
                                <option value="Conferente" {{ old('cargo', $colaborador->cargo) === 'Conferente' ? 'selected' : '' }}>
                                    Conferente
                                </option>
                                <option value="Adm" {{ old('cargo', $colaborador->cargo) === 'Adm' ? 'selected' : '' }}>
                                    Administrativo
                                </option>
                                <option value="Op Empilhadeira" {{ old('cargo', $colaborador->cargo) === 'Op Empilhadeira' ? 'selected' : '' }}>
                                    Operador de Empilhadeira
                                </option>
                            </select>
                            @error('cargo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">
                                <i class="fas fa-toggle-on me-1"></i>
                                Status *
                            </label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" 
                                    name="status" 
                                    required>
                                <option value="">Selecione o status</option>
                                <option value="ativo" {{ old('status', $colaborador->status) === 'ativo' ? 'selected' : '' }}>
                                    Ativo
                                </option>
                                <option value="inativo" {{ old('status', $colaborador->status) === 'inativo' ? 'selected' : '' }}>
                                    Inativo
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Campo condicional para tipo de inatividade -->
                        <div class="col-md-6 mb-3" id="tipo-inatividade-container" style="display: none;">
                            <label for="tipo_inatividade" class="form-label">
                                <i class="fas fa-info-circle me-1"></i>
                                Tipo de Inatividade *
                            </label>
                            <select class="form-select @error('tipo_inatividade') is-invalid @enderror" 
                                    id="tipo_inatividade" 
                                    name="tipo_inatividade">
                                <option value="">Selecione o tipo</option>
                                <option value="afastado" {{ old('tipo_inatividade', $colaborador->tipo_inatividade) === 'afastado' ? 'selected' : '' }}>
                                    Afastado
                                </option>
                                <option value="desligado" {{ old('tipo_inatividade', $colaborador->tipo_inatividade) === 'desligado' ? 'selected' : '' }}>
                                    Desligado
                                </option>
                            </select>
                            @error('tipo_inatividade')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="{{ route('colaboradores.show', $colaborador) }}" class="btn btn-secondary me-2">
                                <i class="fas fa-arrow-left me-2"></i>
                                Voltar
                            </a>
                            <a href="{{ route('colaboradores.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-list me-2"></i>
                                Lista de Colaboradores
                            </a>
                        </div>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-2"></i>
                            Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Informações do Cadastro
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-calendar me-1 text-muted"></i>
                        Cadastrado em:
                    </label>
                    <p class="text-muted">{{ $colaborador->created_at->format('d/m/Y H:i') }}</p>
                </div>
                
                @if($colaborador->updated_at != $colaborador->created_at)
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-edit me-1 text-muted"></i>
                            Última atualização:
                        </label>
                        <p class="text-muted">{{ $colaborador->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                @endif
                
                <div class="alert alert-info">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>Campos obrigatórios:</strong>
                    <ul class="mb-0 mt-2">
                        <li>Prontuário</li>
                        <li>Nome Completo</li>
                        <li>Data de Admissão</li>
                        <li>Contato</li>
                        <li>Data de Aniversário</li>
                        <li>Cargo</li>
                        <li>Status</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-cog me-2"></i>
                    Ações Rápidas
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('colaboradores.show', $colaborador) }}" class="btn btn-info">
                        <i class="fas fa-eye me-2"></i>
                        Visualizar Colaborador
                    </a>
                    
                    @if($colaborador->telefone)
                        <a href="tel:{{ $colaborador->telefone }}" class="btn btn-outline-info">
                            <i class="fas fa-phone me-2"></i>
                            Ligar
                        </a>
                    @endif
                    
                    <a href="mailto:{{ $colaborador->email }}" class="btn btn-outline-secondary">
                        <i class="fas fa-envelope me-2"></i>
                        Enviar Email
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('status');
    const tipoInatividadeContainer = document.getElementById('tipo-inatividade-container');
    const tipoInatividadeSelect = document.getElementById('tipo_inatividade');
    
    function toggleTipoInatividade() {
        if (statusSelect.value === 'inativo') {
            tipoInatividadeContainer.style.display = 'block';
            tipoInatividadeSelect.required = true;
        } else {
            tipoInatividadeContainer.style.display = 'none';
            tipoInatividadeSelect.required = false;
            tipoInatividadeSelect.value = '';
        }
    }
    
    // Executa ao carregar a página
    toggleTipoInatividade();
    
    // Executa quando o status muda
    statusSelect.addEventListener('change', toggleTipoInatividade);
});
</script>
@endpush