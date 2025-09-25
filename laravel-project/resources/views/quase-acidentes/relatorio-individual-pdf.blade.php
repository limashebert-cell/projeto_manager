<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quase Acidente #{{ $quaseAcidente->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            line-height: 1.2;
            margin: 10px;
            padding: 0;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
            border-bottom: 1px solid #333;
            padding-bottom: 5px;
        }
        .header h1 {
            margin: 0;
            font-size: 16px;
            color: #333;
        }
        .header p {
            margin: 2px 0;
            font-size: 9px;
            color: #666;
        }
        .grid {
            display: table;
            width: 100%;
            margin-bottom: 8px;
        }
        .row {
            display: table-row;
        }
        .col {
            display: table-cell;
            padding: 2px 8px 2px 0;
            vertical-align: top;
            border-bottom: 1px dotted #ddd;
        }
        .col-label {
            width: 25%;
            font-weight: bold;
            font-size: 9px;
        }
        .col-value {
            width: 25%;
            font-size: 10px;
        }
        .badge {
            padding: 2px 6px;
            border-radius: 3px;
            color: white;
            font-size: 8px;
            font-weight: bold;
        }
        .badge-success { background-color: #28a745; }
        .badge-warning { background-color: #ffc107; color: #000; }
        .badge-danger { background-color: #dc3545; }
        .section {
            margin-bottom: 8px;
        }
        .section-title {
            font-size: 11px;
            font-weight: bold;
            margin: 5px 0 3px 0;
            color: #333;
            border-bottom: 1px solid #ddd;
            padding-bottom: 1px;
        }
        .description {
            background: #f9f9f9;
            border: 1px solid #ddd;
            padding: 6px;
            margin: 3px 0;
            font-size: 9px;
            line-height: 1.3;
        }
        .footer {
            margin-top: 10px;
            text-align: center;
            font-size: 8px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 5px;
        }
        .images {
            text-align: center;
            margin: 5px 0;
        }
        .images img {
            max-width: 120px;
            max-height: 80px;
            margin: 0 5px;
            border: 1px solid #ddd;
        }
        .alert {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 4px;
            font-size: 8px;
            margin: 3px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>QUASE ACIDENTE #{{ $quaseAcidente->id }}</h1>
        <p>{{ $quaseAcidente->data_ocorrencia->format('d/m/Y H:i') }} | {{ $quaseAcidente->local }}</p>
    </div>

    <!-- Informações Principais em Grid Compacto -->
    <div class="grid">
        <div class="row">
            <div class="col col-label">Colaborador:</div>
            <div class="col col-value">{{ $quaseAcidente->colaborador_envolvido ?? 'Não informado' }}</div>
            <div class="col col-label">Gravidade:</div>
            <div class="col col-value">
                <span class="badge badge-{{ $quaseAcidente->gravidade == 'alta' ? 'danger' : ($quaseAcidente->gravidade == 'media' ? 'warning' : 'success') }}">
                    {{ strtoupper($quaseAcidente->gravidade) }}
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col col-label">Status:</div>
            <div class="col col-value">
                <span class="badge badge-{{ $quaseAcidente->status == 'concluido' ? 'success' : ($quaseAcidente->status == 'em_andamento' ? 'warning' : 'secondary') }}">
                    {{ strtoupper(str_replace('_', ' ', $quaseAcidente->status)) }}
                </span>
            </div>
            <div class="col col-label">Responsável:</div>
            <div class="col col-value">{{ $quaseAcidente->responsavel->name ?? 'N/I' }}</div>
        </div>
    </div>

    <!-- Avaliação de Danos -->
    <div class="grid">
        <div class="row">
            <div class="col col-label">Dano Material:</div>
            <div class="col col-value">
                <span style="color: {{ $quaseAcidente->houve_dano_material ? '#dc3545' : '#28a745' }}; font-weight: bold;">
                    {{ $quaseAcidente->houve_dano_material ? '✓ SIM' : '✗ NÃO' }}
                </span>
            </div>
            <div class="col col-label">Prejuízo:</div>
            <div class="col col-value">
                <span style="color: {{ $quaseAcidente->houve_prejuizo ? '#dc3545' : '#28a745' }}; font-weight: bold;">
                    {{ $quaseAcidente->houve_prejuizo ? '✓ SIM' : '✗ NÃO' }}
                </span>
                @if($quaseAcidente->houve_prejuizo && $quaseAcidente->valor_estimado)
                    | R$ {{ number_format($quaseAcidente->valor_estimado, 2, ',', '.') }}
                @endif
            </div>
        </div>
    </div>

    <!-- Descrição -->
    <div class="section">
        <div class="section-title">DESCRIÇÃO DO OCORRIDO</div>
        <div class="description">{{ $quaseAcidente->descricao }}</div>
    </div>

    @if($quaseAcidente->acoes_tomadas)
    <!-- Ações Tomadas -->
    <div class="section">
        <div class="section-title">AÇÕES TOMADAS</div>
        <div class="description">{{ $quaseAcidente->acoes_tomadas }}</div>
    </div>
    @endif

    <!-- Evidências Fotográficas e Observações (seção compacta) -->
    @if($quaseAcidente->imagem_1 || $quaseAcidente->imagem_2 || $quaseAcidente->observacoes)
    <div class="section">
        <div class="grid">
            @if($quaseAcidente->imagem_1 || $quaseAcidente->imagem_2)
            <div class="row">
                <div class="col col-label">Evidências:</div>
                <div class="col" style="text-align: center;">
                    @if($quaseAcidente->imagem_1)
                        <img src="{{ public_path('uploads/quase_acidentes/' . $quaseAcidente->imagem_1) }}" style="max-width: 60px; max-height: 40px; margin: 0 2px; border: 1px solid #ddd;">
                    @endif
                    @if($quaseAcidente->imagem_2)
                        <img src="{{ public_path('uploads/quase_acidentes/' . $quaseAcidente->imagem_2) }}" style="max-width: 60px; max-height: 40px; margin: 0 2px; border: 1px solid #ddd;">
                    @endif
                </div>
            </div>
            @endif
            
            @if($quaseAcidente->observacoes)
            <div class="row">
                <div class="col col-label">Observações:</div>
                <div class="col col-value" style="font-size: 9px;">{{ $quaseAcidente->observacoes }}</div>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Classificação Final -->
    <div class="section">
        <div class="grid">
            <div class="row">
                <div class="col col-label">Avaliação Final:</div>
                <div class="col col-value">
                    @if($quaseAcidente->houve_dano_material || $quaseAcidente->houve_prejuizo)
                        <span style="color: #dc3545; font-weight: bold;">⚠️ REQUER ATENÇÃO</span>
                        @if($quaseAcidente->houve_prejuizo && $quaseAcidente->valor_estimado)
                            | Prejuízo: R$ {{ number_format($quaseAcidente->valor_estimado, 2, ',', '.') }}
                        @endif
                    @else
                        <span style="color: #28a745; font-weight: bold;">✓ SEM DANOS</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Rodapé Compacto -->
    <div class="footer">
        <div class="grid">
            <div class="row">
                <div class="col">
                    <div style="border-bottom: 1px solid #000; width: 120px; margin: 5px 0 2px 0;"></div>
                    <div style="font-size: 8px;">Responsável</div>
                </div>
                <div class="col" style="text-align: right; font-size: 8px;">
                    Gerado: {{ now()->format('d/m/Y H:i') }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>