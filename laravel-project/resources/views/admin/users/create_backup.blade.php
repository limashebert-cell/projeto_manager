@extends('layouts.app')

@section('title', 'Criar Usuário')

@section('content')
<div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-user-plus me-2"></i>🎉 CRIAR USUÁRIO COM NIVEL 🎉
    </h1>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Voltar
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    🌟 NOVA VERSÃO - CAMPO NIVEL IMPLEMENTADO 🌟
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.users.store') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome Completo *</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">Nome de Usuário *</label>
                        <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="area" class="form-label">Área de Trabalho *</label>
                        <select class="form-select" id="area" name="area" required>
                            <option value="">Selecione a área...</option>
                            <option value="Picking">Picking</option>
                            <option value="Cross">Cross</option>
                            <option value="Expedição">Expedição</option>
                            <option value="Administração">Administração</option>
                            <option value="Recebimento">Recebimento</option>
                            <option value="Armazenagem">Armazenagem</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Role (Sistema) *</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="">Selecione o role...</option>
                            <option value="gerente">Gerente</option>
                            <option value="gestor">Gestor</option>
                            <option value="administrativo">Administrativo</option>
                            <option value="prevencao">Prevenção</option>
                            <option value="sesmit">SESMIT</option>
                            <option value="agente_01">Agente 01</option>
                            <option value="agente_02">Agente 02</option>
                            <option value="agente_03">Agente 03</option>
                            <option value="agente_04">Agente 04</option>
                        </select>
                    </div>

                    <!-- CAMPO NIVEL - MEGA DESTACADO -->
                    <div class="alert alert-warning" style="border: 8px solid #ff6b00; background: #fff3cd;">
                        <h3 style="color: #ff6b00; text-align: center; margin-bottom: 15px;">
                            🚀🚀 CAMPO NIVEL - NOVA FUNCIONALIDADE 🚀🚀
                        </h3>
                        <div class="mb-3">
                            <label for="nivel" class="form-label" style="font-size: 22px; font-weight: bold; color: #ff6b00;">
                                ⭐ NÍVEL DO USUÁRIO (OBRIGATÓRIO) ⭐
                            </label>
                            <select class="form-select" id="nivel" name="nivel" required 
                                    style="border: 6px solid #ff6b00; font-size: 20px; padding: 20px; background: #fff;">
                                <option value="">🎯 ESCOLHA O NÍVEL...</option>
                                <option value="Gerente">👑 Gerente</option>
                                <option value="Gestor">👤 Gestor</option>
                                <option value="Administrativo">📋 Administrativo</option>
                                <option value="Prevenção">🛡️ Prevenção</option>
                                <option value="SESMIT">🏥 SESMIT</option>
                                <option value="Agente 01">🔧 Agente 01</option>
                                <option value="Agente 02">🔧 Agente 02</option>
                                <option value="Agente 03">🔧 Agente 03</option>
                                <option value="Agente 04">🔧 Agente 04</option>
                            </select>
                            <div class="mt-3 text-center">
                                <span class="badge bg-success" style="font-size: 16px; padding: 10px;">
                                    ✅ IMPLEMENTADO: 9 NÍVEIS HIERÁRQUICOS
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Senha *</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Confirmar Senha *</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary w-100">Cancelar</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary w-100">Criar Usuário</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
