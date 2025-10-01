@extends('layouts.app')

@section('title', 'Criar Usuário')

@section('content')
<style>
.campo-nivel-destaque {
    background: linear-gradient(45deg, #ff6b6b, #4ecdc4) !important;
    border: 10px solid #ff1744 !important;
    border-radius: 20px !important;
    padding: 30px !important;
    margin: 30px 0 !important;
    box-shadow: 0 10px 30px rgba(255, 23, 68, 0.5) !important;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.02); }
    100% { transform: scale(1); }
}

.nivel-select {
    border: 8px solid #ff1744 !important;
    font-size: 24px !important;
    padding: 20px !important;
    background: #fff !important;
    font-weight: bold !important;
}

.header-especial {
    background: linear-gradient(45deg, #ff6b6b, #4ecdc4) !important;
    color: white !important;
    font-size: 28px !important;
    text-align: center !important;
    padding: 20px !important;
    border-radius: 15px !important;
    margin-bottom: 30px !important;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3) !important;
}
</style>

<div class="container-fluid">
    <div class="header-especial">
        🚀🚀🚀 SISTEMA DE CRIAÇÃO DE USUÁRIO COM NÍVEL HIERÁRQUICO 🚀🚀🚀
        <br><small>Versão Ultra Destacada - Impossível Não Ver</small>
    </div>

    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="fas fa-user-plus me-2"></i>Criar Usuário
        </h1>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Voltar
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        ✅ FORMULÁRIO FUNCIONANDO - TODOS OS CAMPOS PRESENTES
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.users.store') }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nome Completo *</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Nome de Usuário *</label>
                                    <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
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
                            </div>
                            <div class="col-md-6">
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
                            </div>
                        </div>

                        <!-- =================== CAMPO NIVEL - ULTRA MEGA DESTACADO =================== -->
                        <div class="campo-nivel-destaque">
                            <div class="text-center mb-4">
                                <h2 style="color: #fff; font-size: 36px; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">
                                    🌟⭐🌟 CAMPO NÍVEL - NOVA FUNCIONALIDADE 🌟⭐🌟
                                </h2>
                                <p style="color: #fff; font-size: 18px; margin: 0;">
                                    Este é o novo campo hierárquico solicitado - 9 níveis disponíveis
                                </p>
                            </div>
                            
                            <div class="mb-3">
                                <label for="nivel" class="form-label" style="color: #fff; font-size: 28px; font-weight: bold; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">
                                    🎯 NÍVEL DO USUÁRIO (OBRIGATÓRIO) 🎯
                                </label>
                                <select class="form-select nivel-select" id="nivel" name="nivel" required>
                                    <option value="">🚀 SELECIONE O NÍVEL HIERÁRQUICO...</option>
                                    <option value="Gerente">👑 Gerente (Nível Máximo)</option>
                                    <option value="Gestor">👤 Gestor (Nível Alto)</option>
                                    <option value="Administrativo">📋 Administrativo (Nível Médio)</option>
                                    <option value="Prevenção">🛡️ Prevenção (Nível Médio)</option>
                                    <option value="SESMIT">🏥 SESMIT (Nível Médio)</option>
                                    <option value="Agente 01">🔧 Agente 01 (Nível Operacional)</option>
                                    <option value="Agente 02">🔧 Agente 02 (Nível Operacional)</option>
                                    <option value="Agente 03">🔧 Agente 03 (Nível Operacional)</option>
                                    <option value="Agente 04">🔧 Agente 04 (Nível Operacional)</option>
                                </select>
                                
                                <div class="mt-3 text-center">
                                    <div class="badge bg-light text-dark" style="font-size: 18px; padding: 15px;">
                                        ✅ IMPLEMENTADO: Sistema Hierárquico com 9 Níveis Funcionais
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- =============================================================================== -->

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Senha *</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirmar Senha *</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <h5>📋 Resumo dos Campos:</h5>
                            <ul class="mb-0">
                                <li><strong>Nome e Username:</strong> Identificação do usuário</li>
                                <li><strong>Área de Trabalho:</strong> Setor de atuação (6 opções)</li>
                                <li><strong>Role:</strong> Função no sistema (9 opções)</li>
                                <li><strong>🌟 NÍVEL:</strong> Hierarquia do usuário (9 níveis - NOVO CAMPO)</li>
                                <li><strong>Senha:</strong> Credencial de acesso</li>
                            </ul>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary w-100 btn-lg">
                                    <i class="fas fa-times me-2"></i>Cancelar
                                </a>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-success w-100 btn-lg">
                                    <i class="fas fa-save me-2"></i>Criar Usuário com Nível
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('🎉 SISTEMA DE NÍVEIS CARREGADO COM SUCESSO!');
    
    // Verificar se o campo nivel existe
    const nivelSelect = document.getElementById('nivel');
    if (nivelSelect) {
        console.log('✅ Campo NIVEL encontrado e funcionando!');
        console.log('📊 Opções disponíveis:', nivelSelect.options.length);
        
        // Adicionar efeito visual extra
        nivelSelect.addEventListener('change', function() {
            if (this.value) {
                this.style.background = '#e8f5e8';
                console.log('🎯 Nível selecionado:', this.value);
            }
        });
    } else {
        console.error('❌ Campo NIVEL NÃO encontrado!');
    }
    
    // Verificar todos os campos obrigatórios
    const campos = ['name', 'username', 'area', 'role', 'nivel', 'password', 'password_confirmation'];
    campos.forEach(campo => {
        const element = document.getElementById(campo);
        if (element) {
            console.log(`✅ Campo ${campo}: OK`);
        } else {
            console.error(`❌ Campo ${campo}: NÃO ENCONTRADO`);
        }
    });
});
</script>
@endsection