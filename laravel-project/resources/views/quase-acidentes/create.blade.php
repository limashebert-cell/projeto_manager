@extends('layouts.app')

@section('title', 'Registrar Quase Acidente')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
    <h4>Registrar Quase Acidente</h4>
    <a href="{{ route('quase-acidentes.index') }}" class="btn btn-secondary btn-sm">← Voltar</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('quase-acidentes.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-2">
                        <label class="form-label">Data da Ocorrência</label>
                        <input type="datetime-local" 
                               name="data_ocorrencia" 
                               class="form-control @error('data_ocorrencia') is-invalid @enderror" 
                               value="{{ old('data_ocorrencia', now()->format('Y-m-d\TH:i')) }}" 
                               required>
                        @error('data_ocorrencia')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group mb-2">
                        <label class="form-label">Local</label>
                        <input type="text" 
                               name="local" 
                               class="form-control @error('local') is-invalid @enderror" 
                               value="{{ old('local') }}" 
                               placeholder="Ex: Setor de Produção, Almoxarifado..."
                               required>
                        @error('local')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-2">
                        <label class="form-label">Colaborador Envolvido</label>
                        <input type="text" 
                               name="colaborador_envolvido" 
                               class="form-control @error('colaborador_envolvido') is-invalid @enderror" 
                               value="{{ old('colaborador_envolvido') }}" 
                               placeholder="Nome do colaborador (opcional)">
                        @error('colaborador_envolvido')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group mb-2">
                        <label class="form-label">Gravidade</label>
                        <select name="gravidade" class="form-control @error('gravidade') is-invalid @enderror" required>
                            <option value="baixa" {{ old('gravidade') == 'baixa' ? 'selected' : '' }}>Baixa</option>
                            <option value="media" {{ old('gravidade') == 'media' ? 'selected' : '' }}>Média</option>
                            <option value="alta" {{ old('gravidade') == 'alta' ? 'selected' : '' }}>Alta</option>
                        </select>
                        @error('gravidade')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="form-group mb-2">
                <label class="form-label">Descrição do Ocorrido</label>
                <textarea name="descricao" 
                          class="form-control @error('descricao') is-invalid @enderror" 
                          rows="4" 
                          placeholder="Descreva detalhadamente o que aconteceu..."
                          required>{{ old('descricao') }}</textarea>
                @error('descricao')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group mb-2">
                <label class="form-label">Ações Tomadas</label>
                <textarea name="acoes_tomadas" 
                          class="form-control @error('acoes_tomadas') is-invalid @enderror" 
                          rows="3" 
                          placeholder="Quais ações foram tomadas imediatamente?">{{ old('acoes_tomadas') }}</textarea>
                @error('acoes_tomadas')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-2">
                        <label class="form-label">
                            <i class="fas fa-camera me-1"></i>
                            Imagem 1 (Opcional)
                        </label>
                        
                        <!-- Botões de Ação -->
                        <div class="d-flex gap-2 mb-2">
                            <button type="button" class="btn btn-primary btn-sm" onclick="openCamera(1)">
                                <i class="fas fa-camera"></i> Tirar Foto
                            </button>
                            <button type="button" class="btn btn-secondary btn-sm" onclick="document.getElementById('file1').click()">
                                <i class="fas fa-folder"></i> Galeria
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="clearImage(1)" style="display: none;" id="clear1">
                                <i class="fas fa-trash"></i> Remover
                            </button>
                        </div>

                        <!-- Input de arquivo (oculto) -->
                        <input type="file" 
                               id="file1"
                               name="imagem_1" 
                               class="d-none @error('imagem_1') is-invalid @enderror" 
                               accept="image/*"
                               onchange="previewImage(this, 'preview1', 1)">
                        
                        <!-- Canvas para captura da câmera (oculto) -->
                        <canvas id="canvas1" style="display: none;"></canvas>
                        
                        @error('imagem_1')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        
                        <!-- Preview da imagem -->
                        <div class="mt-2">
                            <img id="preview1" src="#" alt="Preview" style="display: none; max-width: 200px; max-height: 150px; border-radius: 5px; border: 1px solid #ddd;">
                        </div>
                        <small class="text-muted">Formato: JPG, PNG. Tamanho máx: 2MB</small>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group mb-2">
                        <label class="form-label">
                            <i class="fas fa-camera me-1"></i>
                            Imagem 2 (Opcional)
                        </label>
                        
                        <!-- Botões de Ação -->
                        <div class="d-flex gap-2 mb-2">
                            <button type="button" class="btn btn-primary btn-sm" onclick="openCamera(2)">
                                <i class="fas fa-camera"></i> Tirar Foto
                            </button>
                            <button type="button" class="btn btn-secondary btn-sm" onclick="document.getElementById('file2').click()">
                                <i class="fas fa-folder"></i> Galeria
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="clearImage(2)" style="display: none;" id="clear2">
                                <i class="fas fa-trash"></i> Remover
                            </button>
                        </div>

                        <!-- Input de arquivo (oculto) -->
                        <input type="file" 
                               id="file2"
                               name="imagem_2" 
                               class="d-none @error('imagem_2') is-invalid @enderror" 
                               accept="image/*"
                               onchange="previewImage(this, 'preview2', 2)">
                        
                        <!-- Canvas para captura da câmera (oculto) -->
                        <canvas id="canvas2" style="display: none;"></canvas>
                        
                        @error('imagem_2')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        
                        <!-- Preview da imagem -->
                        <div class="mt-2">
                            <img id="preview2" src="#" alt="Preview" style="display: none; max-width: 200px; max-height: 150px; border-radius: 5px; border: 1px solid #ddd;">
                        </div>
                        <small class="text-muted">Formato: JPG, PNG. Tamanho máx: 2MB</small>
                    </div>
                </div>
            </div>
            
            <div class="form-group mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                    <option value="pendente" {{ old('status') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                    <option value="em_andamento" {{ old('status') == 'em_andamento' ? 'selected' : '' }}>Em Andamento</option>
                    <option value="concluido" {{ old('status') == 'concluido' ? 'selected' : '' }}>Concluído</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Seção de Danos e Prejuízos -->
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Avaliação de Danos
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Houve Dano Material?</label>
                                <div class="form-check">
                                    <input type="radio" 
                                           name="houve_dano_material" 
                                           value="1" 
                                           class="form-check-input" 
                                           id="dano_sim"
                                           {{ old('houve_dano_material') == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="dano_sim">
                                        <i class="fas fa-check-circle text-danger me-1"></i>
                                        Sim
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" 
                                           name="houve_dano_material" 
                                           value="0" 
                                           class="form-check-input" 
                                           id="dano_nao"
                                           {{ old('houve_dano_material', '0') == '0' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="dano_nao">
                                        <i class="fas fa-times-circle text-success me-1"></i>
                                        Não
                                    </label>
                                </div>
                                @error('houve_dano_material')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Houve Prejuízo?</label>
                                <div class="form-check">
                                    <input type="radio" 
                                           name="houve_prejuizo" 
                                           value="1" 
                                           class="form-check-input" 
                                           id="prejuizo_sim"
                                           onclick="toggleValorEstimado(true)"
                                           {{ old('houve_prejuizo') == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="prejuizo_sim">
                                        <i class="fas fa-check-circle text-danger me-1"></i>
                                        Sim
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" 
                                           name="houve_prejuizo" 
                                           value="0" 
                                           class="form-check-input" 
                                           id="prejuizo_nao"
                                           onclick="toggleValorEstimado(false)"
                                           {{ old('houve_prejuizo', '0') == '0' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="prejuizo_nao">
                                        <i class="fas fa-times-circle text-success me-1"></i>
                                        Não
                                    </label>
                                </div>
                                @error('houve_prejuizo')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Campo Valor Estimado -->
                    <div class="row" id="valorEstimadoContainer" style="{{ old('houve_prejuizo') == '1' ? '' : 'display: none;' }}">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">
                                    <i class="fas fa-dollar-sign me-1"></i>
                                    Valor Estimado (R$)
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">R$</span>
                                    <input type="number" 
                                           name="valor_estimado" 
                                           class="form-control @error('valor_estimado') is-invalid @enderror" 
                                           value="{{ old('valor_estimado') }}"
                                           step="0.01"
                                           min="0"
                                           placeholder="0,00">
                                </div>
                                @error('valor_estimado')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Informe o valor estimado do prejuízo em reais</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm">Salvar Registro</button>
                <a href="{{ route('quase-acidentes.index') }}" class="btn btn-secondary btn-sm">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<!-- Modal da Câmera -->
<div class="modal fade" id="cameraModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-camera me-2"></i>
                    Tirar Foto
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <div id="cameraContainer">
                    <video id="video" width="100%" height="300" autoplay style="border-radius: 5px; background: #000;"></video>
                </div>
                <div class="mt-3">
                    <button type="button" class="btn btn-primary" onclick="capturePhoto()">
                        <i class="fas fa-camera"></i> Capturar Foto
                    </button>
                    <button type="button" class="btn btn-secondary ms-2" onclick="switchCamera()" id="switchBtn" style="display: none;">
                        <i class="fas fa-sync-alt"></i> Trocar Câmera
                    </button>
                </div>
                <div id="cameraError" style="display: none;" class="alert alert-danger mt-3">
                    <i class="fas fa-exclamation-triangle"></i>
                    Não foi possível acessar a câmera. Verifique as permissões ou use a opção "Galeria".
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
let currentStream = null;
let currentImageSlot = 1;
let facingMode = 'environment'; // 'user' para frontal, 'environment' para traseira

function previewImage(input, previewId, slot) {
    const preview = document.getElementById(previewId);
    const clearBtn = document.getElementById('clear' + slot);
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            clearBtn.style.display = 'inline-block';
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.style.display = 'none';
        clearBtn.style.display = 'none';
    }
}

function clearImage(slot) {
    const preview = document.getElementById('preview' + slot);
    const fileInput = document.getElementById('file' + slot);
    const clearBtn = document.getElementById('clear' + slot);
    
    preview.style.display = 'none';
    fileInput.value = '';
    clearBtn.style.display = 'none';
}

async function openCamera(slot) {
    currentImageSlot = slot;
    const modal = new bootstrap.Modal(document.getElementById('cameraModal'));
    const video = document.getElementById('video');
    const errorDiv = document.getElementById('cameraError');
    const switchBtn = document.getElementById('switchBtn');
    
    try {
        errorDiv.style.display = 'none';
        
        // Parar stream anterior se existir
        if (currentStream) {
            currentStream.getTracks().forEach(track => track.stop());
        }
        
        // Verificar se há múltiplas câmeras
        const devices = await navigator.mediaDevices.enumerateDevices();
        const videoDevices = devices.filter(device => device.kind === 'videoinput');
        
        if (videoDevices.length > 1) {
            switchBtn.style.display = 'inline-block';
        }
        
        // Solicitar acesso à câmera
        currentStream = await navigator.mediaDevices.getUserMedia({
            video: {
                facingMode: facingMode,
                width: { ideal: 1280 },
                height: { ideal: 720 }
            }
        });
        
        video.srcObject = currentStream;
        modal.show();
        
    } catch (err) {
        console.error('Erro ao acessar câmera:', err);
        errorDiv.style.display = 'block';
        modal.show();
    }
}

async function switchCamera() {
    facingMode = facingMode === 'environment' ? 'user' : 'environment';
    await openCamera(currentImageSlot);
}

function capturePhoto() {
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas' + currentImageSlot);
    const preview = document.getElementById('preview' + currentImageSlot);
    const fileInput = document.getElementById('file' + currentImageSlot);
    const clearBtn = document.getElementById('clear' + currentImageSlot);
    
    // Configurar canvas com as dimensões do vídeo
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    
    // Desenhar frame atual do vídeo no canvas
    const ctx = canvas.getContext('2d');
    ctx.drawImage(video, 0, 0);
    
    // Converter canvas para blob e criar arquivo
    canvas.toBlob(function(blob) {
        // Criar arquivo a partir do blob
        const file = new File([blob], 'camera_photo_' + Date.now() + '.jpg', {
            type: 'image/jpeg',
            lastModified: Date.now()
        });
        
        // Criar FileList para o input
        const dt = new DataTransfer();
        dt.items.add(file);
        fileInput.files = dt.files;
        
        // Mostrar preview
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            clearBtn.style.display = 'inline-block';
        }
        reader.readAsDataURL(file);
        
    }, 'image/jpeg', 0.8);
    
    // Fechar modal
    const modal = bootstrap.Modal.getInstance(document.getElementById('cameraModal'));
    modal.hide();
}

// Limpar stream quando modal for fechado
document.getElementById('cameraModal').addEventListener('hidden.bs.modal', function() {
    if (currentStream) {
        currentStream.getTracks().forEach(track => track.stop());
        currentStream = null;
    }
});

// Verificar suporte à câmera
document.addEventListener('DOMContentLoaded', function() {
    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        // Esconder botões de câmera se não há suporte
        document.querySelectorAll('button[onclick^="openCamera"]').forEach(btn => {
            btn.style.display = 'none';
        });
    }
});

// Função para mostrar/esconder campo de valor estimado
function toggleValorEstimado(show) {
    const container = document.getElementById('valorEstimadoContainer');
    const valorInput = document.querySelector('input[name="valor_estimado"]');
    
    if (show) {
        container.style.display = 'block';
        valorInput.setAttribute('required', 'required');
    } else {
        container.style.display = 'none';
        valorInput.removeAttribute('required');
        valorInput.value = '';
    }
}
</script>
@endpush