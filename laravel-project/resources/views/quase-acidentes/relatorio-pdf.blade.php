<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Quase Acidentes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }
        .info {
            margin-bottom: 20px;
            font-size: 10px;
            color: #666;
        }
        .filtros {
            background: #f5f5f5;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
        }
        .filtros h3 {
            margin: 0 0 10px 0;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
            font-size: 10px;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .badge {
            padding: 2px 6px;
            border-radius: 3px;
            color: white;
            font-size: 9px;
        }
        .badge-success { background-color: #28a745; }
        .badge-warning { background-color: #ffc107; color: #000; }
        .badge-danger { background-color: #dc3545; }
        .badge-secondary { background-color: #6c757d; }
        .badge-info { background-color: #17a2b8; }
        .resumo {
            margin-top: 20px;
            padding: 15px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>RELATÓRIO DE QUASE ACIDENTES</h1>
        <p>Sistema de Gestão de Segurança</p>
    </div>

    <div class="info">
        <strong>Data de Geração:</strong> {{ $dataGeracao }}<br>
        <strong>Total de Registros:</strong> {{ $quaseAcidentes->count() }}
    </div>

    @if($filtros)
        <div class="filtros">
            <h3>Filtros Aplicados:</h3>
            @if(isset($filtros['data_inicio']))
                <strong>Data Início:</strong> {{ \Carbon\Carbon::parse($filtros['data_inicio'])->format('d/m/Y') }}<br>
            @endif
            @if(isset($filtros['data_fim']))
                <strong>Data Fim:</strong> {{ \Carbon\Carbon::parse($filtros['data_fim'])->format('d/m/Y') }}<br>
            @endif
            @if(isset($filtros['gravidade']))
                <strong>Gravidade:</strong> {{ ucfirst($filtros['gravidade']) }}<br>
            @endif
            @if(isset($filtros['status']))
                <strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $filtros['status'])) }}<br>
            @endif
        </div>
    @endif

    @if($quaseAcidentes->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 12%;">Data</th>
                    <th style="width: 15%;">Local</th>
                    <th style="width: 15%;">Colaborador</th>
                    <th style="width: 10%;">Gravidade</th>
                    <th style="width: 30%;">Descrição</th>
                    <th style="width: 10%;">Status</th>
                    <th style="width: 8%;">Responsável</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quaseAcidentes as $acidente)
                    <tr>
                        <td>{{ $acidente->data_ocorrencia->format('d/m/Y H:i') }}</td>
                        <td>{{ $acidente->local }}</td>
                        <td>{{ $acidente->colaborador_envolvido ?? '-' }}</td>
                        <td>
                            <span class="badge badge-{{ $acidente->gravidade == 'alta' ? 'danger' : ($acidente->gravidade == 'media' ? 'warning' : 'success') }}">
                                {{ ucfirst($acidente->gravidade) }}
                            </span>
                        </td>
                        <td>{{ Str::limit($acidente->descricao, 100) }}</td>
                        <td>
                            <span class="badge badge-{{ $acidente->status == 'concluido' ? 'success' : ($acidente->status == 'em_andamento' ? 'warning' : 'secondary') }}">
                                {{ ucfirst(str_replace('_', ' ', $acidente->status)) }}
                            </span>
                        </td>
                        <td>{{ $acidente->responsavel->name ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="resumo">
            <h3>Resumo Estatístico</h3>
            <div style="display: flex; justify-content: space-between;">
                <div>
                    <strong>Por Gravidade:</strong><br>
                    • Alta: {{ $quaseAcidentes->where('gravidade', 'alta')->count() }}<br>
                    • Média: {{ $quaseAcidentes->where('gravidade', 'media')->count() }}<br>
                    • Baixa: {{ $quaseAcidentes->where('gravidade', 'baixa')->count() }}
                </div>
                <div>
                    <strong>Por Status:</strong><br>
                    • Pendente: {{ $quaseAcidentes->where('status', 'pendente')->count() }}<br>
                    • Em Andamento: {{ $quaseAcidentes->where('status', 'em_andamento')->count() }}<br>
                    • Concluído: {{ $quaseAcidentes->where('status', 'concluido')->count() }}
                </div>
            </div>
        </div>
    @else
        <div style="text-align: center; padding: 50px;">
            <h3>Nenhum registro encontrado com os filtros aplicados</h3>
        </div>
    @endif

    <div class="footer">
        <p>Relatório gerado automaticamente pelo Sistema de Gestão de Segurança</p>
        <p>{{ $dataGeracao }}</p>
    </div>
</body>
</html>