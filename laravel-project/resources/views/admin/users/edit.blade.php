@extends('layouts.app')

@section('title', 'Editar Usuário - Painel Administrativo')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-user-edit me-2 text-primary"></i>
        Editar Usuário
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Voltar
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-form me-2"></i>
                    Editando: {{ $user->name }}
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">
                            <i class="fas fa-user me-2"></i>Nome Completo *
                        </label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $user->name) }}" 
                               required 
                               autofocus
                               placeholder="Digite o nome completo do gestor">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">
                            <i class="fas fa-at me-2"></i>Nome de Usuário *
                        </label>
                        <input type="text" 
                               class="form-control @error('username') is-invalid @enderror" 
                               id="username" 
                               name="username" 
                               value="{{ old('username', $user->username) }}" 
                               required
                               placeholder="Digite o nome de usuário para login">
                        @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Usado para fazer login no sistema
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="area" class="form-label">
                            <i class="fas fa-building me-2"></i>Área de Trabalho *
                        </label>
                        <select class="form-select @error('area') is-invalid @enderror" 
                                id="area" 
                                name="area" 
                                required>
                            <option value="">Selecione a área...</option>
                            <option value="Picking" {{ old('area', $user->area) == 'Picking' ? 'selected' : '' }}>Picking</option>
                            <option value="Cross" {{ old('area', $user->area) == 'Cross' ? 'selected' : '' }}>Cross</option>
                            <option value="Expedição" {{ old('area', $user->area) == 'Expedição' ? 'selected' : '' }}>Expedição</option>
                            <option value="Administração" {{ old('area', $user->area) == 'Administração' ? 'selected' : '' }}>Administração</option>
                            <option value="Recebimento" {{ old('area', $user->area) == 'Recebimento' ? 'selected' : '' }}>Recebimento</option>
                            <option value="Armazenagem" {{ old('area', $user->area) == 'Armazenagem' ? 'selected' : '' }}>Armazenagem</option>
                        </select>
                        @error('area')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <hr>
                    
                    <h6 class="text-muted mb-3">
                        <i class="fas fa-key me-2"></i>Alterar Senha (opcional)
                    </h6>

                    <div class="mb-3">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock me-2"></i>Nova Senha
                        </label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               placeholder="Deixe em branco para manter a senha atual">
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Deixe em branco para não alterar a senha
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">
                            <i class="fas fa-lock me-2"></i>Confirmar Nova Senha
                        </label>
                        <input type="password" 
                               class="form-control" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               placeholder="Repita a nova senha">
                    </div>

                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Atenção:</strong> As alterações serão salvas imediatamente. Se você alterar a senha, o usuário precisará usar a nova senha para fazer login.
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-grid">
                                <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>Cancelar
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Salvar Alterações
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Card com informações atuais -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Informações Atuais
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <small class="text-muted d-block">Nome atual:</small>
                        <strong>{{ $user->name }}</strong>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted d-block">Usuário atual:</small>
                        <code>{{ $user->username }}</code>
                    </div>
                </div>
                <hr class="my-2">
                <div class="row">
                    <div class="col-sm-6">
                        <small class="text-muted d-block">Área atual:</small>
                        <span class="badge bg-info">{{ $user->area }}</span>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted d-block">Status:</small>
                        <span class="badge bg-{{ $user->active ? 'success' : 'danger' }}">
                            {{ $user->active ? 'Ativo' : 'Inativo' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection