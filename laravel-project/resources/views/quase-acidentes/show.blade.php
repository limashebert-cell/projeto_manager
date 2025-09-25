@extends('layouts.app')

@section('title', 'Detalhes do Quase Acidente')

@section('content')
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

@endsection