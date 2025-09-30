# 🐧 COMO EXECUTAR O PROJETO NO LINUX

## ✅ Pré-requisitos Instalados
- ✅ PHP 8.3.6 (com extensões necessárias)
- ✅ SQLite 3.45.1
- ✅ Composer 2.7.1 (global)
- ✅ Node.js 18.19.1
- ✅ NPM 9.2.0
- ✅ Build tools (gcc, make, etc.)

## 🚀 Execução do Servidor

### Método 1: Comando Direto
```bash
cd /root/projeto_manager/laravel-project
php artisan serve --host=127.0.0.1 --port=8000
```

### Método 2: Via Script (RECOMENDADO)
```bash
cd /root/projeto_manager/laravel-project
./start-server.sh
```

### Método 3: Via NPM (Desenvolvimento)
```bash
cd /root/projeto_manager/laravel-project
npm run dev
# Em outro terminal:
php artisan serve --host=0.0.0.0 --port=8000
```

## 🌐 Acesso ao Sistema
- **URL:** http://127.0.0.1:8000
- **Usuário:** admin
- **Senha:** password

## 📊 Status do Ambiente

### ✅ Configurado
- Arquivo `.env` criado e configurado
- Dependências do Composer instaladas
- Banco SQLite criado e migrado
- Usuário administrador criado
- Cache limpo e otimizado

### 🗄️ Banco de Dados
- **Tipo:** SQLite
- **Localização:** `/root/projeto_manager/laravel-project/database/database.sqlite`
- **Tabelas:** 16 tabelas criadas

### 👤 Usuário Padrão
- **Nome:** Administrador
- **Username:** admin
- **Senha:** password (hash bcrypt)
- **Tipo:** super_admin

## 🔧 Comandos Úteis

### Verificar Status
```bash
php artisan migrate:status
php artisan --version
```

### Limpar Cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### Recriar Cache
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 🛠️ Resolução de Problemas

### Se o servidor não iniciar:
1. Verifique se a porta 8000 está disponível: `netstat -tulpn | grep :8000`
2. Use porta alternativa: `php artisan serve --port=8080`

### Se houver problemas de permissão:
```bash
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

### Para verificar logs:
```bash
tail -f storage/logs/laravel.log
```

## 📱 Funcionalidades Disponíveis
- Sistema de login administrativo
- Gestão de colaboradores
- Controle de presença
- Registro de quase acidentes
- Relatórios e auditorias

## 🔒 Segurança
- Debug desabilitado em produção
- Senhas com hash bcrypt
- Validação CSRF ativa
- Sanitização de inputs