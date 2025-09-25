# Sistema de Painel Administrativo Responsivo

Este é um sistema completo de painel administrativo desenvolvido em PHP com Laravel, totalmente responsivo para dispositivos móveis.

## 🚀 Funcionalidades

- ✅ **Login administrativo único** - Sistema de autenticação seguro
- ✅ **Painel responsivo** - Adaptado para desktop, tablet e mobile
- ✅ **Gerenciamento de usuários** - Criar, editar, visualizar e excluir usuários (apenas Super Admin)
- ✅ **Sistema de áreas** - Categorização por departamentos
- ✅ **Ativação/Desativação** - Controle de status dos usuários
- ✅ **Cartão de Ponto** - Sistema completo de controle de horários
- ✅ **Interface moderna** - Design clean com Bootstrap 5
- ✅ **Notificações** - Feedback visual para todas as ações

## 🏗️ Tecnologias Utilizadas

- **PHP 7.4+**
- **Laravel 8.x**
- **SQLite** (banco de dados)
- **Bootstrap 5** (framework CSS responsivo)
- **Font Awesome** (ícones)
- **JavaScript** (interatividade)

## 📱 Design Responsivo

O sistema foi desenvolvido com foco em responsividade:

- **Desktop**: Layout completo com sidebar fixa
- **Tablet**: Layout adaptado com navegação otimizada
- **Mobile**: Sidebar colapsável com menu hambúrguer

## 🔐 Credenciais de Acesso

**Super Administrador (Acesso Total):**
- **Usuário:** `admin`
- **Senha:** `123456`
- **Permissões:** Acesso completo ao sistema, incluindo gerenciamento de usuários

**Usuário Teste (Acesso Limitado):**
- **Usuário:** `joao`
- **Senha:** `123456`
- **Permissões:** Acesso apenas ao dashboard, sem permissão para gerenciar usuários

## 🛡️ Sistema de Permissões

### Super Administrador
- ✅ Acesso ao dashboard
- ✅ **Gerenciar usuários** (criar, editar, ativar/desativar, excluir)
- ✅ **Criar novos administradores**
- ✅ **Cartão de Ponto** - Controle completo de horários
- ✅ Todas as funcionalidades do sistema

### Administrador Regular
- ✅ Acesso ao dashboard
- ✅ **Cartão de Ponto** - Controle completo de horários
- ❌ **Não pode** gerenciar usuários
- ❌ **Não pode** criar novos usuários
- ❌ **Não pode** acessar o módulo de usuários

### Proteções Implementadas
- 🔒 **Middleware personalizado** (`super.admin`) protege todas as rotas de usuários
- 🔒 **Menu condicional** - Opção "Gerenciar Usuários" aparece apenas para super admin
- 🔒 **Dashboard adaptativo** - Botões e informações variam conforme o tipo de usuário
- 🔒 **Redirecionamento automático** - Usuários regulares são redirecionados com mensagem de erro ao tentar acessar áreas restritas

## 🎯 Fluxo de Uso

### 1. Login Inicial
- Acesse o sistema com as credenciais do super administrador
- O login é único e seguro

### 2. Dashboard
- Visão geral do sistema
- Estatísticas de usuários
- Ações rápidas

### 3. Gerenciar Usuários
- **Criar:** Cadastre novos gestores com nome, área e credenciais
- **Visualizar:** Veja todos os detalhes de um usuário
- **Editar:** Modifique informações e senhas
- **Ativar/Desativar:** Controle o acesso sem excluir
- **Excluir:** Remova usuários (exceto super admin)

## 📋 Campos de Cadastro

Ao criar um novo usuário, você precisa preencher:

- **Nome Completo** - Nome do gestor
- **Nome de Usuário** - Login único para acesso
- **Área de Trabalho** - Departamento/setor
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
- **Senha** - Mínimo 6 caracteres
- **Confirmação de Senha**

## 🛠️ Configuração Técnica

### Estrutura do Projeto
```
projeto_manager/
├── laravel-project/          # Aplicação Laravel
│   ├── app/
│   │   ├── Http/Controllers/ # Controllers do sistema
│   │   └── Models/          # Models (AdminUser)
│   ├── database/
│   │   ├── migrations/      # Estrutura do banco
│   │   └── database.sqlite  # Banco de dados SQLite
│   ├── resources/views/     # Views (templates)
│   │   ├── auth/           # Telas de login
│   │   ├── admin/          # Painel administrativo
│   │   └── layouts/        # Layout principal
│   └── routes/web.php      # Rotas do sistema
└── composer.phar           # Gerenciador de dependências
```

### Banco de Dados
- **Tipo:** SQLite (arquivo local)
- **Localização:** `database/database.sqlite`
- **Tabela principal:** `admin_users`

### Funcionalidades de Segurança
- ✅ Senhas criptografadas (Hash)
- ✅ Autenticação com guard personalizado
- ✅ Proteção CSRF
- ✅ Validação de formulários
- ✅ Controle de acesso por rotas

## 🌐 Como Executar

### 1. Iniciar o Servidor
```bash
cd c:\projeto_manager\laravel-project
php artisan serve
```

### 2. Acessar o Sistema
Abra o navegador e vá para: `http://localhost:8000`

### 3. Fazer Login
Use as credenciais:
- Usuário: `admin`
- Senha: `123456`

## 📱 Recursos Mobile

- **Menu Hambúrguer** - Navegação otimizada para telas pequenas
- **Cards Responsivos** - Informações organizadas em cards adaptativos
- **Tabelas Responsivas** - Scroll horizontal quando necessário
- **Botões Touch-Friendly** - Tamanhos adequados para toque
- **Formulários Otimizados** - Labels e campos bem espaçados

## 🎨 Interface

### Cores do Sistema
- **Primária:** Gradiente azul/roxo (#667eea → #764ba2)
- **Sucesso:** Verde (#28a745)
- **Aviso:** Amarelo (#ffc107)
- **Perigo:** Vermelho (#dc3545)
- **Info:** Azul claro (#17a2b8)

### Componentes
- **Cards com sombra** - Visual moderno
- **Botões gradiente** - Efeitos visuais atraentes
- **Ícones Font Awesome** - Clareza visual
- **Animações CSS** - Transições suaves

## 🔧 Manutenção

### Backup do Banco
O arquivo `database/database.sqlite` contém todos os dados. Faça backup regularmente.

### Logs do Sistema
Os logs ficam em `storage/logs/laravel.log`

### Atualizações
Para atualizações futuras, execute:
```bash
composer update
php artisan migrate
```

## 📞 Suporte

Este sistema foi desenvolvido para ser intuitivo e fácil de usar. Todas as ações têm confirmações de segurança e feedback visual.

### Funcionalidades Principais:
1. **Dashboard** - Visão geral
2. **Criar Usuário** - Cadastro de novos gestores (Apenas Super Admin)
3. **Listar Usuários** - Visualização de todos os usuários (Apenas Super Admin)
4. **Editar Usuário** - Modificação de dados (Apenas Super Admin)
5. **Controle de Status** - Ativar/Desativar usuários (Apenas Super Admin)
6. **Cartão de Ponto** - Sistema completo de controle de horários (Todos os usuários)

## ⏰ Sistema de Cartão de Ponto

### Funcionalidades do Cartão de Ponto:
- 🕒 **Relógio Digital** - Exibição em tempo real
- ✅ **Registrar Entrada** - Marcar chegada ao trabalho
- ✅ **Registrar Saída** - Marcar saída do trabalho
- ☕ **Controle de Intervalo** - Início e fim do intervalo
- 📝 **Observações** - Notas sobre o dia de trabalho
- 📊 **Cálculo Automático** - Total de horas trabalhadas
- 📅 **Histórico** - Últimos 7 dias de registros
- 📱 **Interface Responsiva** - Funciona perfeitamente em mobile

### Como Usar o Cartão de Ponto:
1. **Chegada ao Trabalho:** Clique em "Registrar Entrada"
2. **Início do Intervalo:** Clique em "Iniciar Intervalo"
3. **Volta do Intervalo:** Clique em "Finalizar Intervalo"
4. **Saída do Trabalho:** Clique em "Registrar Saída"
5. **Observações:** Adicione notas sobre seu dia

### Recursos Avançados:
- ⚡ **Status Visual** - Ícones coloridos mostram o status atual
- 🔒 **Controle Sequencial** - Impede registros fora de ordem
- 📱 **Mobile First** - Interface otimizada para smartphones
- 🎯 **Um Registro por Dia** - Sistema inteligente de controle

---

**Sistema desenvolvido com foco em usabilidade, segurança e responsividade mobile! 📱💻**