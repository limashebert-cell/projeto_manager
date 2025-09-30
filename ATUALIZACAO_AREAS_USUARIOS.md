# Atualização das Áreas de Trabalho para Usuários

## Alteração Realizada

As áreas de trabalho disponíveis no formulário de criação e edição de usuários foram atualizadas para refletir as áreas específicas da empresa.

## Áreas Anteriores (Removidas)
- Administração
- Financeiro
- Recursos Humanos
- Vendas
- Marketing
- Tecnologia da Informação
- Operações
- Atendimento ao Cliente
- Jurídico
- Outra

## Novas Áreas (Implementadas)
1. **Picking** - Área de separação de produtos
2. **Cross** - Área de cross docking
3. **Expedição** - Área de expedição e envio
4. **Administração** - Área administrativa (mantida)
5. **Recebimento** - Área de recebimento de mercadorias
6. **Armazenagem** - Área de armazenagem e estoque

## Arquivos Modificados

### 1. Formulário de Criação
**Arquivo:** `resources/views/admin/users/create.blade.php`
- Atualizado o select com as novas opções de área
- Mantida a funcionalidade de seleção com `old()` para persistir dados após erro

### 2. Formulário de Edição
**Arquivo:** `resources/views/admin/users/edit.blade.php`
- Atualizado o select com as novas opções de área
- Mantida a funcionalidade de seleção com `old()` e valor atual do usuário

## Validações

O controller `UserController.php` já aceita qualquer string para o campo área, então não foram necessárias alterações nas validações. As validações existentes continuam válidas:

```php
'area' => 'required|string|max:255'
```

## Como Usar

Ao criar ou editar um usuário administrativo, agora estão disponíveis apenas as áreas específicas da operação logística:
- Picking
- Cross
- Expedição
- Administração
- Recebimento
- Armazenagem

## Impacto

- **Usuários existentes:** Não são afetados. Usuários com áreas antigas continuam funcionando normalmente.
- **Novos usuários:** Devem ser criados com uma das novas áreas disponíveis.
- **Relatórios:** Usuários existentes com áreas antigas continuarão aparecendo nos relatórios com suas áreas originais.

## Observações

Esta mudança torna o sistema mais específico para o ambiente logístico e facilita a identificação dos gestores por área operacional.