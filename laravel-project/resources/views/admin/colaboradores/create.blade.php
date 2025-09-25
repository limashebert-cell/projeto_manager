@extends('layouts.app')

@section('title', 'Novo Colaborador - Painel Administrativo')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-user-plus me-2 text-primary"></i>
        Novo Colaborador
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
                <form action="{{ route('colaboradores.store') }}" method="POST">
                    @csrf
                    
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
                                   value="{{ old('prontuario') }}" 
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
                                   value="{{ old('nome') }}" 
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
                                   value="{{ old('data_admissao') }}" 
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
                                   value="{{ old('contato') }}" 
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
                                   value="{{ old('data_aniversario') }}" 
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
                                <option value="Auxiliar" {{ old('cargo') === 'Auxiliar' ? 'selected' : '' }}>
                                    Auxiliar
                                </option>
                                <option value="Conferente" {{ old('cargo') === 'Conferente' ? 'selected' : '' }}>
                                    Conferente
                                </option>
                                <option value="Adm" {{ old('cargo') === 'Adm' ? 'selected' : '' }}>
                                    Administrativo
                                </option>
                                <option value="Op Empilhadeira" {{ old('cargo') === 'Op Empilhadeira' ? 'selected' : '' }}>
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
                                <option value="ativo" {{ old('status') === 'ativo' ? 'selected' : '' }}>
                                    Ativo
                                </option>
                                <option value="inativo" {{ old('status') === 'inativo' ? 'selected' : '' }}>
                                    Inativo
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('colaboradores.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Voltar
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-2"></i>
                            Cadastrar Colaborador
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
                    Informações
                </h6>
            </div>
            <div class="card-body">
                <div class="alert alert-info mb-3">
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
                
                <div class="alert alert-warning">
                    <i class="fas fa-shield-alt me-2"></i>
                    <strong>Privacidade:</strong><br>
                    Este colaborador será vinculado apenas à sua conta e não será visível para outros usuários.
                </div>
            </div>
        </div>
    </div>
</div>

@endsection