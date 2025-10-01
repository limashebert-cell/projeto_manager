@extends('layouts.app')

@section('title', 'Quase Acidentes')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
    <h4>Quase Acidentes ({{ $quaseAcidentes->total() }})</h4>
    <div class="btn-group">
        <a href="{{ route('quase-acidentes.create') }}" class="btn btn-primary btn-sm">+ Novo Registro</a>
        <a href="{{ route('quase-acidentes.relatorio') }}" class="btn btn-success btn-sm" target="_blank">📄 Relatório PDF</a>
    </div>
</div>

@if($quaseAcidentes->count() > 0)
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Local</th>
                            <th>Colaborador</th>
                            <th>Gravidade</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($quaseAcidentes as $acidente)
                            <tr>
                                <td>{{ $acidente->data_ocorrencia->format('d/m/Y') }}</td>
                                <td>{{ $acidente->local }}</td>
                                <td>{{ $acidente->colaborador_envolvido ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-{{ $acidente->gravidade == 'alta' ? 'danger' : ($acidente->gravidade == 'media' ? 'warning' : 'success') }}">
                                        {{ ucfirst($acidente->gravidade) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $acidente->status == 'concluido' ? 'success' : ($acidente->status == 'em_andamento' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst(str_replace('_', ' ', $acidente->status)) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('quase-acidentes.show', $acidente->id) }}" class="btn btn-outline-info btn-sm">Ver</a>
                                        <a href="{{ route('quase-acidentes.pdf', $acidente->id) }}" class="btn btn-outline-success btn-sm" target="_blank">PDF</a>
                                        @if(Auth::guard('admin')->user()->isSuperAdmin() || $acidente->responsavel_id == Auth::guard('admin')->id())
                                            <a href="{{ route('quase-acidentes.edit', $acidente->id) }}" class="btn btn-outline-warning btn-sm">Edit</a>
                                            <form method="POST" action="{{ route('quase-acidentes.destroy', $acidente->id) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                        onclick="return confirm('Excluir este quase acidente?')">
                                                    Del
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="mt-3">
        {{ $quaseAcidentes->links() }}
    </div>
@else
    <div class="card">
        <div class="card-body text-center p-3">
            <p class="text-muted mb-2">Nenhum quase acidente registrado</p>
            <a href="{{ route('quase-acidentes.create') }}" class="btn btn-primary btn-sm">Registrar Primeiro Quase Acidente</a>
        </div>
    </div>
@endif

@endsection