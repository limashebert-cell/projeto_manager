# Funcionalidade de Importação e Exportação de Colaboradores

## Visão Geral

O sistema possui duas funcionalidades principais para gerenciamento em massa de colaboradores:

### 1. **Baixar Layout** (Download Template CSV)
- **Localização:** Página de listagem de colaboradores
- **Botão:** "Baixar Layout" (verde com ícone de download)
- **Função:** Gera e baixa um arquivo CSV modelo com a estrutura correta para importação

### 2. **Importar Layout** (Importar Dados CSV)
- **Localização:** Página de listagem de colaboradores
- **Botão:** "Importar Dados" (azul com ícone de upload)
- **Função:** Permite importar colaboradores via arquivo CSV

## Estrutura do Arquivo CSV

### Colunas do Template (em ordem):
1. **prontuario** - Número único do colaborador (obrigatório)
2. **nome** - Nome completo (obrigatório)
3. **email** - Email do colaborador (obrigatório, único)
4. **telefone** - Telefone do colaborador (opcional)
5. **data_admissao** - Data de admissão no formato YYYY-MM-DD (obrigatório)
6. **contato** - Contato adicional (opcional)
7. **data_aniversario** - Data de aniversário no formato YYYY-MM-DD (opcional)
8. **cargo** - Cargo: Auxiliar, Conferente, Adm, Op Empilhadeira (obrigatório)
9. **status** - Status: ativo, inativo (obrigatório)
10. **tipo_inatividade** - Tipo: afastado, desligado (opcional, obrigatório se status=inativo)

### Exemplo de Linha CSV:
```
123456;João da Silva;joao.silva@email.com;(11) 99999-9999;2023-01-15;(11) 88888-8888;1990-05-20;Auxiliar;ativo;
```

## Funcionalidades da Importação

### Validações Aplicadas:
- **Campos obrigatórios:** prontuario, nome, email, data_admissao, cargo, status
- **Email único:** Verifica se o email já existe no sistema
- **Formato de data:** YYYY-MM-DD
- **Cargos válidos:** Auxiliar, Conferente, Adm, Op Empilhadeira
- **Status válidos:** ativo, inativo
- **Tipo inatividade:** Obrigatório apenas se status = inativo

### Opções de Importação:
1. **Criar novos:** Colaboradores com prontuário inexistente são criados
2. **Atualizar existentes:** Opção para atualizar dados de colaboradores existentes
3. **Relatório de erros:** Mostra linhas que falharam na importação

### Processo de Importação:
1. Upload do arquivo CSV (máximo 2MB)
2. Validação da estrutura e dados
3. Verificação de duplicatas por prontuário
4. Criação/atualização dos registros
5. Relatório final com sucessos e erros

## Tratamento de Erros

### Erros Comuns:
- Campos obrigatórios em branco
- Email duplicado
- Formato de data inválido
- Cargo não permitido
- Status inválido
- Arquivo corrompido ou formato incorreto

### Feedback ao Usuário:
- **Sucesso:** Quantidade de colaboradores importados/atualizados
- **Erros:** Lista detalhada com número da linha e descrição do problema
- **Avisos:** Registros que foram pulados por já existirem

## Rotas Implementadas

```php
// Download do template CSV
Route::get('/admin/colaboradores/download-template', [ColaboradorController::class, 'downloadTemplate'])
    ->name('colaboradores.download-template');

// Página de importação
Route::get('/admin/colaboradores/import', [ColaboradorController::class, 'showImport'])
    ->name('colaboradores.import');

// Processamento da importação
Route::post('/admin/colaboradores/import', [ColaboradorController::class, 'import'])
    ->name('colaboradores.import.process');
```

## Segurança

- **Autenticação:** Apenas usuários administrativos logados
- **Autorização:** Cada usuário só pode importar colaboradores para si mesmo
- **Super Admin:** Pode importar colaboradores para qualquer gestor
- **Validação de arquivo:** Aceita apenas arquivos CSV com tamanho limitado
- **Sanitização:** Dados são validados antes da inserção no banco

## Uso Recomendado

1. **Para novos colaboradores:**
   - Baixar o template
   - Preencher os dados
   - Importar o arquivo

2. **Para atualização em massa:**
   - Exportar dados existentes (se necessário)
   - Modificar no template
   - Importar com opção "Atualizar existentes" marcada

3. **Para migração de sistemas:**
   - Adaptar dados para o formato do template
   - Fazer importação gradual testando com poucos registros primeiro