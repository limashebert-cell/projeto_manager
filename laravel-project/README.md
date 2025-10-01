# Sistema Administrativo PHP - Cartão de Ponto

Sistema responsivo desenvolvido em Laravel 8 para gerenciamento administrativo com controle de usuários, cartão de ponto e gestão de colaboradores.

## 📋 Características

- **Interface Responsiva**: Desenvolvido com Bootstrap 5 para dispositivos móveis e desktop
- **Autenticação Segura**: Sistema de login exclusivo para administradores
- **Controle de Permissões**: Separação entre Super Admin e Usuários Regulares
- **Cartão de Ponto**: Sistema completo de controle de horários
- **Gestão de Colaboradores**: Cada usuário gerencia seus próprios colaboradores

## 🚀 Funcionalidades

### 👑 Super Admin
- ✅ Acesso completo ao sistema
- ✅ Gerenciamento de usuários (CRUD)
- ✅ Controle de status de usuários
- ✅ Acesso ao cartão de ponto
- ✅ Gestão de colaboradores próprios

### 👤 Usuário Regular  
- ✅ Acesso ao painel administrativo
- ✅ Sistema completo de cartão de ponto
- ✅ Gestão exclusiva de seus colaboradores
- ❌ Não pode gerenciar outros usuários

### ⏰ Cartão de Ponto
- ⏰ Relógio digital em tempo real
- 🕐 Registro de entrada e saída
- ☕ Controle de intervalos
- 📝 Anotações diárias
- 📊 Histórico de registros
- 📱 Interface responsiva

### 👥 Gestão de Colaboradores
- 🆔 **Prontuário único** para cada colaborador
- 👤 Cadastro completo de colaboradores
- � **Data de admissão** e **aniversário**
- 📞 Informações de contato
- 💼 **Cargos predefinidos**: Auxiliar, Conferente, Adm, Op Empilhadeira
- 🔄 Gerenciamento de status
- 🔒 **Isolamento de dados**: Cada usuário vê apenas seus colaboradores
- 📱 Interface mobile-friendly

## 🛠️ Tecnologias Utilizadas

- **Backend**: PHP 7.4 + Laravel 8
- **Frontend**: Bootstrap 5 + Font Awesome
- **Banco de Dados**: SQLite (desenvolvimento)
- **Autenticação**: Laravel Auth Guards
- **Middleware**: Controle de permissões customizado

## 📦 Instalação

### Pré-requisitos
- PHP 7.4 ou superior
- Composer

### Passos de Instalação

1. **Clone o repositório**
```bash
git clone [url-do-repositorio]
cd laravel-project
```

2. **Instale as dependências**
```bash
composer install
```

3. **Configure o ambiente**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Execute as migrações**
```bash
php artisan migrate
```

5. **Crie os usuários de teste**
```bash
php artisan db:seed --class=AdminUserSeeder
php artisan db:seed --class=TestUserSeeder
```

6. **Inicie o servidor**
```bash
php artisan serve --host=0.0.0.0 --port=8000
```

## 👤 Usuários de Teste

### Super Admin
- **Usuário**: `admin`
- **Senha**: `123456`
- **Permissões**: Acesso total ao sistema

### Usuário Regular
- **Usuário**: `joao`
- **Senha**: `123456`
- **Permissões**: Cartão de ponto e colaboradores próprios

## 🔐 Estrutura de Permissões

### Middleware SuperAdminMiddleware
- Protege rotas de gerenciamento de usuários
- Garante que apenas Super Admins acessem funcionalidades administrativas

### Guards de Autenticação
- **admin**: Guard personalizado para administradores
- Isolamento completo entre diferentes tipos de usuário

### Isolamento de Dados
- Cada usuário vê apenas seus próprios colaboradores
- Sistema de verificação de propriedade em todas as operações CRUD

## 📂 Estrutura do Projeto

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php        # Autenticação
│   │   ├── AdminController.php       # Dashboard
│   │   ├── UserController.php        # Gestão de usuários (Super Admin)
│   │   ├── TimeclockController.php   # Cartão de ponto
│   │   └── ColaboradorController.php # Gestão de colaboradores
│   └── Middleware/
│       └── SuperAdminMiddleware.php  # Controle de permissões
├── Models/
│   ├── AdminUser.php                 # Usuários administrativos
│   ├── TimeclockRecord.php          # Registros de ponto
│   └── Colaborador.php              # Colaboradores
database/
├── migrations/
│   ├── create_admin_users_table.php
│   ├── create_timeclock_records_table.php
│   └── create_colaboradores_table.php
resources/views/
├── layouts/app.blade.php             # Layout principal
├── admin/
│   ├── dashboard.blade.php
│   ├── users/                        # Views de usuários
│   ├── timeclock/                    # Views do cartão de ponto
│   └── colaboradores/                # Views de colaboradores
routes/web.php                        # Definição de rotas
```

## 🔄 Fluxo de Uso

### Para Super Admin
1. Login com credenciais de super admin
2. Acesso ao dashboard com todas as opções
3. Gerenciamento de usuários e colaboradores
4. Uso do cartão de ponto

### Para Usuário Regular
1. Login com credenciais de usuário
2. Acesso ao dashboard simplificado
3. Uso do cartão de ponto
4. Gestão exclusiva de colaboradores próprios

## 🚀 Deploy em Produção

### Configurações Recomendadas
1. Alterar `APP_ENV=production` no `.env`
2. Configurar banco MySQL/PostgreSQL
3. Configurar cache e sessões em Redis
4. Habilitar HTTPS
5. Configurar backup automático

### Segurança
- Senhas hasheadas com bcrypt
- Proteção CSRF em todos os formulários
- Middleware de autenticação em todas as rotas protegidas
- Validação rigorosa de dados de entrada

## 📱 Compatibilidade Mobile

- Interface 100% responsiva
- Componentes otimizados para touch
- Navegação intuitiva em dispositivos móveis
- Cartão de ponto funcional em smartphones

## 🤝 Contribuição

1. Fork o projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

---

**Desenvolvido com ❤️ utilizando Laravel Framework**
