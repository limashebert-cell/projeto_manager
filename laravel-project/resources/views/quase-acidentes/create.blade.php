@extends('layouts.app')

@section('title', 'Registrar Quase Acidente')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
    <h4>Registrar Quase Acidente</h4>
    <a href="{{ route('quase-acidentes.index') }}" class="btn btn-secondary btn-sm">← Voltar</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('quase-acidentes.store') }}">
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
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm">Salvar Registro</button>
                <a href="{{ route('quase-acidentes.index') }}" class="btn btn-secondary btn-sm">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@endsection