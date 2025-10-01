<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Usuário - Sistema Hierárquico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(45deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .mega-destaque {
            background: linear-gradient(45deg, #ff0000, #ff8c00, #ffd700) !important;
            border: 15px solid #ff0000 !important;
            border-radius: 25px !important;
            padding: 40px !important;
            margin: 40px 0 !important;
            box-shadow: 0 0 50px rgba(255, 0, 0, 0.8) !important;
            animation: blink 1s infinite, pulse 2s infinite;
        }
        @keyframes blink { 0%, 50% { opacity: 1; } 51%, 100% { opacity: 0.7; } }
        @keyframes pulse { 0% { transform: scale(1); } 50% { transform: scale(1.05); } 100% { transform: scale(1); } }
        .nivel-input { border: 10px solid #ff0000 !important; font-size: 28px !important; padding: 25px !important; }
        .titulo-mega { font-size: 48px !important; color: #fff !important; text-shadow: 3px 3px 6px #000; }
    </style>
</head>
<body>
    <div class="container-fluid p-4">
        <div class="text-center mb-5">
            <h1 class="titulo-mega">
                🚨🚨🚨 FORMULÁRIO DE CRIAÇÃO COM NÍVEL 🚨🚨🚨
            </h1>
            <h2 style="color: #fff; font-size: 24px;">
                ⚡ VERSÃO ULTRA DESTACADA - IMPOSSÍVEL NÃO VER ⚡
            </h2>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header bg-danger text-white text-center">
                        <h3>📋 FORMULÁRIO COMPLETO COM TODOS OS CAMPOS</h3>
                    </div>
                    <div class="card-body" style="background: #fff;">
                        <form method="POST" action="{{ route('admin.users.store') }}">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label"><strong>1. Nome Completo *</strong></label>
                                        <input type="text" class="form-control" name="name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label"><strong>2. Username *</strong></label>
                                        <input type="text" class="form-control" name="username" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label"><strong>3. Área *</strong></label>
                                        <select class="form-select" name="area" required>
                                            <option value="">Selecione...</option>
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
                                        <label class="form-label"><strong>4. Role Sistema *</strong></label>
                                        <select class="form-select" name="role" required>
                                            <option value="">Selecione...</option>
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
                            
                            <!-- CAMPO NIVEL - MEGA ULTRA DESTACADO -->
                            <div class="mega-destaque">
                                <div class="text-center mb-4">
                                    <h1 style="font-size: 60px; color: #000; text-shadow: 2px 2px 4px #fff;">
                                        🔥🔥🔥 CAMPO NÍVEL - NOVO!!! 🔥🔥🔥
                                    </h1>
                                    <h2 style="font-size: 32px; color: #000;">
                                        5. NÍVEL HIERÁRQUICO DO USUÁRIO
                                    </h2>
                                </div>
                                
                                <select class="form-select nivel-input" name="nivel" required id="campoNivel">
                                    <option value="">🎯 ESCOLHA O NÍVEL OBRIGATÓRIO...</option>
                                    <option value="Gerente">👑 Gerente (Máximo)</option>
                                    <option value="Gestor">�� Gestor (Alto)</option>
                                    <option value="Administrativo">📋 Administrativo</option>
                                    <option value="Prevenção">🛡️ Prevenção</option>
                                    <option value="SESMIT">🏥 SESMIT</option>
                                    <option value="Agente 01">🔧 Agente 01</option>
                                    <option value="Agente 02">🔧 Agente 02</option>
                                    <option value="Agente 03">🔧 Agente 03</option>
                                    <option value="Agente 04">🔧 Agente 04</option>
                                </select>
                                
                                <div class="text-center mt-4">
                                    <div class="badge bg-dark" style="font-size: 24px; padding: 20px;">
                                        ✅ 9 NÍVEIS HIERÁRQUICOS IMPLEMENTADOS
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label"><strong>6. Senha *</strong></label>
                                        <input type="password" class="form-control" name="password" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label"><strong>7. Confirmar Senha *</strong></label>
                                        <input type="password" class="form-control" name="password_confirmation" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="alert alert-success text-center">
                                <h4>📊 TODOS OS 7 CAMPOS OBRIGATÓRIOS PRESENTES</h4>
                                <p>Nome, Username, Área, Role, <strong>NÍVEL</strong>, Senha, Confirmar Senha</p>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary w-100 btn-lg">Cancelar</a>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-success w-100 btn-lg">
                                        ✅ CRIAR USUÁRIO COM NÍVEL
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
            console.log('🎉 SISTEMA CARREGADO!');
            
            const campoNivel = document.getElementById('campoNivel');
            if (campoNivel) {
                console.log('✅ CAMPO NÍVEL ENCONTRADO!');
                console.log('📊 Opções:', campoNivel.options.length);
                
                campoNivel.addEventListener('change', function() {
                    console.log('🎯 Nível selecionado:', this.value);
                    alert('✅ NÍVEL SELECIONADO: ' + this.value);
                });
            } else {
                console.error('❌ CAMPO NÍVEL NÃO ENCONTRADO!');
                alert('❌ ERRO: Campo nível não encontrado!');
            }
        });
    </script>
</body>
</html>
