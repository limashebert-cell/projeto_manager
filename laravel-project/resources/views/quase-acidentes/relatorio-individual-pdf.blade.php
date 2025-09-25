<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório Individual - Quase Acidente #{{ $quaseAcidente->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            color: #333;
        }
        .info-box {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        .info-row {
            display: table-row;
        }
        .info-label {
            display: table-cell;
            width: 30%;
            font-weight: bold;
            padding: 5px 10px 5px 0;
            vertical-align: top;
        }
        .info-value {
            display: table-cell;
            padding: 5px 0;
            vertical-align: top;
        }
        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            color: white;
            font-size: 10px;
            font-weight: bold;
        }
        .badge-success { background-color: #28a745; }
        .badge-warning { background-color: #ffc107; color: #000; }
        .badge-danger { background-color: #dc3545; }
        .badge-secondary { background-color: #6c757d; }
        .section {
            margin-bottom: 25px;
        }
        .section h3 {
            margin: 0 0 10px 0;
            font-size: 14px;
            color: #333;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        .description-box {
            background: #fff;
            border: 1px solid #ddd;
            padding: 15px;
            margin: 10px 0;
            border-radius: 3px;
            min-height: 50px;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        .priority-high {
            border-left: 4px solid #dc3545;
        }
        .priority-medium {
            border-left: 4px solid #ffc107;
        }
        .priority-low {
            border-left: 4px solid #28a745;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>RELATÓRIO DE QUASE ACIDENTE</h1>
        <p>Registro #{{ $quaseAcidente->id }}</p>
    </div>

    <div class="info-box priority-{{ $quaseAcidente->gravidade == 'alta' ? 'high' : ($quaseAcidente->gravidade == 'media' ? 'medium' : 'low') }}">
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Data da Ocorrência:</div>
                <div class="info-value">{{ $quaseAcidente->data_ocorrencia->format('d/m/Y H:i') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Local:</div>
                <div class="info-value">{{ $quaseAcidente->local }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Colaborador Envolvido:</div>
                <div class="info-value">{{ $quaseAcidente->colaborador_envolvido ?? 'Não informado' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Gravidade:</div>
                <div class="info-value">
                    <span class="badge badge-{{ $quaseAcidente->gravidade == 'alta' ? 'danger' : ($quaseAcidente->gravidade == 'media' ? 'warning' : 'success') }}">
                        {{ strtoupper($quaseAcidente->gravidade) }}
                    </span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Status:</div>
                <div class="info-value">
                    <span class="badge badge-{{ $quaseAcidente->status == 'concluido' ? 'success' : ($quaseAcidente->status == 'em_andamento' ? 'warning' : 'secondary') }}">
                        {{ strtoupper(str_replace('_', ' ', $quaseAcidente->status)) }}
                    </span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Responsável:</div>
                <div class="info-value">{{ $quaseAcidente->responsavel->name ?? 'Não informado' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Data de Registro:</div>
                <div class="info-value">{{ $quaseAcidente->created_at->format('d/m/Y H:i') }}</div>
            </div>
        </div>
    </div>

    <div class="section">
        <h3>Descrição do Ocorrido</h3>
        <div class="description-box">
            {{ $quaseAcidente->descricao }}
        </div>
    </div>

    @if($quaseAcidente->acoes_tomadas)
    <div class="section">
        <h3>Ações Tomadas</h3>
        <div class="description-box">
            {{ $quaseAcidente->acoes_tomadas }}
        </div>
    </div>
    @endif

    @if($quaseAcidente->imagem_1 || $quaseAcidente->imagem_2)
    <div class="section">
        <h3>Registros Fotográficos</h3>
        <div class="images-container" style="text-align: center;">
            @if($quaseAcidente->imagem_1)
                <div style="margin-bottom: 15px;">
                    <img src="{{ public_path('uploads/quase_acidentes/' . $quaseAcidente->imagem_1) }}" 
                         alt="Registro Fotográfico 1" 
                         style="max-width: 300px; max-height: 200px; border: 1px solid #ddd; border-radius: 5px;">
                    <p style="margin: 5px 0; font-size: 12px; color: #666;">Imagem 1 - Registro do local</p>
                </div>
            @endif
            
            @if($quaseAcidente->imagem_2)
                <div style="margin-bottom: 15px;">
                    <img src="{{ public_path('uploads/quase_acidentes/' . $quaseAcidente->imagem_2) }}" 
                         alt="Registro Fotográfico 2" 
                         style="max-width: 300px; max-height: 200px; border: 1px solid #ddd; border-radius: 5px;">
                    <p style="margin: 5px 0; font-size: 12px; color: #666;">Imagem 2 - Registro do local</p>
                </div>
            @endif
        </div>
    </div>
    @endif

    <div class="section">
        <h3>Classificação de Risco</h3>
        <div class="info-box">
            <div style="text-align: center; padding: 20px;">
                @if($quaseAcidente->gravidade == 'alta')
                    <div style="color: #dc3545; font-size: 16px; font-weight: bold;">
                        ⚠️ RISCO ALTO
                    </div>
                    <p style="margin: 10px 0; color: #721c24;">
                        Requer ação imediata e acompanhamento rigoroso. Potencial para causar lesões graves ou danos significativos.
                    </p>
                @elseif($quaseAcidente->gravidade == 'media')
                    <div style="color: #856404; font-size: 16px; font-weight: bold;">
                        ⚡ RISCO MÉDIO
                    </div>
                    <p style="margin: 10px 0; color: #856404;">
                        Requer monitoramento e ações preventivas. Potencial para causar lesões moderadas.
                    </p>
                @else
                    <div style="color: #155724; font-size: 16px; font-weight: bold;">
                        ✅ RISCO BAIXO
                    </div>
                    <p style="margin: 10px 0; color: #155724;">
                        Situação sob controle, manter práticas preventivas adequadas.
                    </p>
                @endif
            </div>
        </div>
    </div>

    <div class="footer">
        <p><strong>Relatório gerado automaticamente pelo Sistema de Gestão de Segurança</strong></p>
        <p>Data de geração: {{ $dataGeracao }}</p>
        <p>Este documento contém informações confidenciais e deve ser tratado adequadamente</p>
    </div>
</body>
</html>