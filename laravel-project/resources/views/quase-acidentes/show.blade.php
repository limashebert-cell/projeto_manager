@extends('layouts.app')

@section('title', 'Detalhes do Quase Acidente')

@section('content')
@if($quaseAcidente->acoes_tomadas)
<div class="card mb-3">
    <div class="card-header">
        <h6 class="mb-0">Ações Tomadas</h6>
    </div>
    <div class="card-body">
        <p>{{ $quaseAcidente->acoes_tomadas }}</p>
    </div>
</div>
@endif

@if($quaseAcidente->imagem_1 || $quaseAcidente->imagem_2)
<div class="card mb-3">
    <div class="card-header">
        <h6 class="mb-0">
            <i class="fas fa-camera me-2"></i>
            Imagens do Local
        </h6>
    </div>
    <div class="card-body">
        <div class="row">
            @if($quaseAcidente->imagem_1)
            <div class="col-md-6 mb-3">
                <div class="text-center">
                    <img src="{{ asset('uploads/quase_acidentes/' . $quaseAcidente->imagem_1) }}" 
                         alt="Imagem 1" 
                         class="img-fluid rounded shadow-sm" 
                         style="max-height: 300px; cursor: pointer;"
                         onclick="showImageModal('{{ asset('uploads/quase_acidentes/' . $quaseAcidente->imagem_1) }}', 'Imagem 1')">
                    <p class="text-muted mt-2 small">Imagem 1 - Clique para ampliar</p>
                </div>
            </div>
            @endif
            
            @if($quaseAcidente->imagem_2)
            <div class="col-md-6 mb-3">
                <div class="text-center">
                    <img src="{{ asset('uploads/quase_acidentes/' . $quaseAcidente->imagem_2) }}" 
                         alt="Imagem 2" 
                         class="img-fluid rounded shadow-sm" 
                         style="max-height: 300px; cursor: pointer;"
                         onclick="showImageModal('{{ asset('uploads/quase_acidentes/' . $quaseAcidente->imagem_2) }}', 'Imagem 2')">
                    <p class="text-muted mt-2 small">Imagem 2 - Clique para ampliar</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endif
<div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
    <h4>Quase Acidente #{{ $quaseAcidente->id }}</h4>
    <div class="btn-group">
        <a href="{{ route('quase-acidentes.index') }}" class="btn btn-secondary btn-sm">← Voltar</a>
        @if(Auth::guard('admin')->user()->isSuperAdmin() || $quaseAcidente->responsavel_id == Auth::guard('admin')->id())
            <a href="{{ route('quase-acidentes.edit', $quaseAcidente->id) }}" class="btn btn-warning btn-sm">Editar</a>
        @endif
        <a href="{{ route('quase-acidentes.pdf', $quaseAcidente->id) }}" class="btn btn-success btn-sm" target="_blank">📄 PDF</a>
        @if(Auth::guard('admin')->user()->isSuperAdmin() || $quaseAcidente->responsavel_id == Auth::guard('admin')->id())
            <form method="POST" action="{{ route('quase-acidentes.destroy', $quaseAcidente->id) }}" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" 
                        onclick="return confirm('Tem certeza que deseja excluir este quase acidente? Esta ação não pode ser desfeita.')">
                    🗑️ Excluir
                </button>
            </form>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h6 class="mb-0">Informações Gerais</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td><strong>Data da Ocorrência:</strong></td>
                        <td>{{ $quaseAcidente->data_ocorrencia->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Local:</strong></td>
                        <td>{{ $quaseAcidente->local }}</td>
                    </tr>
                    <tr>
                        <td><strong>Colaborador:</strong></td>
                        <td>{{ $quaseAcidente->colaborador_envolvido ?? 'Não informado' }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td><strong>Gravidade:</strong></td>
                        <td>
                            <span class="badge bg-{{ $quaseAcidente->gravidade == 'alta' ? 'danger' : ($quaseAcidente->gravidade == 'media' ? 'warning' : 'success') }}">
                                {{ ucfirst($quaseAcidente->gravidade) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Status:</strong></td>
                        <td>
                            <span class="badge bg-{{ $quaseAcidente->status == 'concluido' ? 'success' : ($quaseAcidente->status == 'em_andamento' ? 'warning' : 'secondary') }}">
                                {{ ucfirst(str_replace('_', ' ', $quaseAcidente->status)) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Responsável:</strong></td>
                        <td>{{ $quaseAcidente->responsavel->name ?? 'Não informado' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h6 class="mb-0">Descrição do Ocorrido</h6>
    </div>
    <div class="card-body">
        <p>{{ $quaseAcidente->descricao }}</p>
    </div>
</div>

@if($quaseAcidente->acoes_tomadas)
<div class="card">
    <div class="card-header">
        <h6 class="mb-0">Ações Tomadas</h6>
    </div>
    <div class="card-body">
        <p>{{ $quaseAcidente->acoes_tomadas }}</p>
    </div>
</div>
@endif

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
            <div class="col-md-4">
                <strong>Dano Material:</strong>
                @if($quaseAcidente->houve_dano_material)
                    <span class="badge bg-danger ms-2">
                        <i class="fas fa-check-circle me-1"></i>
                        Sim
                    </span>
                @else
                    <span class="badge bg-success ms-2">
                        <i class="fas fa-times-circle me-1"></i>
                        Não
                    </span>
                @endif
            </div>
            
            <div class="col-md-4">
                <strong>Prejuízo:</strong>
                @if($quaseAcidente->houve_prejuizo)
                    <span class="badge bg-danger ms-2">
                        <i class="fas fa-check-circle me-1"></i>
                        Sim
                    </span>
                @else
                    <span class="badge bg-success ms-2">
                        <i class="fas fa-times-circle me-1"></i>
                        Não
                    </span>
                @endif
            </div>
            
            @if($quaseAcidente->houve_prejuizo && $quaseAcidente->valor_estimado)
            <div class="col-md-4">
                <strong>Valor Estimado:</strong>
                <span class="badge bg-warning text-dark ms-2">
                    <i class="fas fa-dollar-sign me-1"></i>
                    R$ {{ number_format($quaseAcidente->valor_estimado, 2, ',', '.') }}
                </span>
            </div>
            @endif
        </div>
        
        @if($quaseAcidente->houve_dano_material || $quaseAcidente->houve_prejuizo)
        <div class="mt-2">
            <div class="alert alert-warning d-flex align-items-center" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <div>
                    <strong>Atenção:</strong> Este quase acidente resultou em 
                    @if($quaseAcidente->houve_dano_material && $quaseAcidente->houve_prejuizo)
                        dano material e prejuízo financeiro.
                    @elseif($quaseAcidente->houve_dano_material)
                        dano material.
                    @else
                        prejuízo financeiro.
                    @endif
                    Requer acompanhamento especial.
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h6 class="mb-0">Informações do Sistema</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <small class="text-muted">
                    <strong>Criado em:</strong> {{ $quaseAcidente->created_at->format('d/m/Y H:i') }}
                </small>
            </div>
            <div class="col-md-6">
                <small class="text-muted">
                    <strong>Última atualização:</strong> {{ $quaseAcidente->updated_at->format('d/m/Y H:i') }}
                </small>
            </div>
        </div>
    </div>
</div>

<!-- Modal para ampliar imagens -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Visualizar Imagem</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Imagem ampliada" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function showImageModal(imageSrc, title) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('imageModalLabel').textContent = title;
    new bootstrap.Modal(document.getElementById('imageModal')).show();
}
</script>
@endpush