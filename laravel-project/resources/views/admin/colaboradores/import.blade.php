@extends('layouts.app')

@section('title', 'Importar Colaboradores - Painel Administrativo')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-upload me-2 text-primary"></i>
        Importar Colaboradores
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('colaboradores.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>
            Voltar
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('import_errors'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>Alguns registros não foram importados:</strong>
        <ul class="mb-0 mt-2">
            @foreach(session('import_errors') as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-file-csv me-2"></i>
                    Upload do Arquivo
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('colaboradores.import.process') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="arquivo" class="form-label">
                            <strong>Selecione o arquivo CSV:</strong>
                        </label>
                        <input type="file" class="form-control @error('arquivo') is-invalid @enderror" 
                               id="arquivo" name="arquivo" accept=".csv" required>
                        @error('arquivo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Apenas arquivos CSV são aceitos. Tamanho máximo: 2MB.
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="atualizar_existentes" name="atualizar_existentes" value="1">
                            <label class="form-check-label" for="atualizar_existentes">
                                <strong>Atualizar colaboradores existentes</strong>
                                <small class="d-block text-muted">
                                    Se marcado, colaboradores com o mesmo prontuário serão atualizados. 
                                    Caso contrário, serão ignorados.
                                </small>
                            </label>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload me-2"></i>
                            Importar Colaboradores
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-download me-2"></i>
                    Template do Arquivo
                </h5>
            </div>
            <div class="card-body">
                <p class="card-text">
                    Baixe o template CSV para garantir que os dados estejam no formato correto.
                </p>
                
                <a href="{{ route('colaboradores.download-template') }}" class="btn btn-success w-100 mb-3">
                    <i class="fas fa-download me-2"></i>
                    Baixar Template CSV
                </a>

                <div class="alert alert-info">
                    <h6><i class="fas fa-info-circle me-1"></i> Instruções:</h6>
                    <ul class="mb-0 small">
                        <li>Baixe o template CSV</li>
                        <li>Preencha com os dados dos colaboradores</li>
                        <li>Mantenha o formato das colunas</li>
                        <li>Datas no formato: YYYY-MM-DD</li>
                        <li>Status: ativo, inativo, afastado ou desligado</li>
                        <li>Salve como CSV (separado por vírgulas)</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-table me-2"></i>
                    Campos Obrigatórios
                </h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0 small">
                    <li><strong>prontuario:</strong> Número único do colaborador</li>
                    <li><strong>nome:</strong> Nome completo</li>
                    <li><strong>data_admissao:</strong> Data de admissão (YYYY-MM-DD)</li>
                    <li><strong>cargo:</strong> Cargo/função</li>
                    <li><strong>status:</strong> ativo/inativo/afastado/desligado</li>
                    <li class="text-muted mt-2"><em>Outros campos são opcionais</em></li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection