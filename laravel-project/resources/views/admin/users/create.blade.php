@extends('layouts.app')

@section('title', 'Criar Usuário - Painel Administrativo')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-user-plus me-2 text-primary"></i>
        Criar Novo Usuário
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
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
                    Dados do Novo Usuário
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.users.store') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">
                            <i class="fas fa-user me-2"></i>Nome Completo *
                        </label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}" 
                               required 
                               autofocus
                               placeholder="Digite o nome completo do gestor">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Nome que aparecerá no sistema
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">
                            <i class="fas fa-at me-2"></i>Nome de Usuário *
                        </label>
                        <input type="text" 
                               class="form-control @error('username') is-invalid @enderror" 
                               id="username" 
                               name="username" 
                               value="{{ old('username') }}" 
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
                            <option value="Administração" {{ old('area') == 'Administração' ? 'selected' : '' }}>Administração</option>
                            <option value="Financeiro" {{ old('area') == 'Financeiro' ? 'selected' : '' }}>Financeiro</option>
                            <option value="Recursos Humanos" {{ old('area') == 'Recursos Humanos' ? 'selected' : '' }}>Recursos Humanos</option>
                            <option value="Vendas" {{ old('area') == 'Vendas' ? 'selected' : '' }}>Vendas</option>
                            <option value="Marketing" {{ old('area') == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                            <option value="Tecnologia da Informação" {{ old('area') == 'Tecnologia da Informação' ? 'selected' : '' }}>Tecnologia da Informação</option>
                            <option value="Operações" {{ old('area') == 'Operações' ? 'selected' : '' }}>Operações</option>
                            <option value="Atendimento ao Cliente" {{ old('area') == 'Atendimento ao Cliente' ? 'selected' : '' }}>Atendimento ao Cliente</option>
                            <option value="Jurídico" {{ old('area') == 'Jurídico' ? 'selected' : '' }}>Jurídico</option>
                            <option value="Outra" {{ old('area') == 'Outra' ? 'selected' : '' }}>Outra</option>
                        </select>
                        @error('area')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock me-2"></i>Senha *
                        </label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               required
                               placeholder="Digite uma senha segura">
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-shield-alt me-1"></i>
                            Mínimo de 6 caracteres
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">
                            <i class="fas fa-lock me-2"></i>Confirmar Senha *
                        </label>
                        <input type="password" 
                               class="form-control" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               required
                               placeholder="Digite a senha novamente">
                        <div class="form-text">
                            <i class="fas fa-check me-1"></i>
                            Repita a senha para confirmação
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Informação:</strong> O usuário criado terá permissão de administrador e poderá acessar o painel de controle com as credenciais definidas aqui.
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-grid">
                                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>Cancelar
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Criar Usuário
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-gerar username baseado no nome
    document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.getElementById('name');
        const usernameInput = document.getElementById('username');
        
        nameInput.addEventListener('input', function() {
            if (!usernameInput.value) {
                let username = this.value
                    .toLowerCase()
                    .normalize('NFD')
                    .replace(/[\u0300-\u036f]/g, '') // Remove acentos
                    .replace(/[^a-z0-9]/g, '') // Remove caracteres especiais
                    .substring(0, 20); // Limita a 20 caracteres
                
                usernameInput.value = username;
            }
        });
    });
</script>
@endpush

@endsection