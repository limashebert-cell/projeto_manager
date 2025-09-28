# 🌐 INFORMAÇÕES DE ACESSO AO SISTEMA

## 📍 **Endereços de Acesso**

### **IP Público do VPS:**
- **IPv4:** `72.60.125.120`
- **IPv6:** `2a02:4780:2d:dfcb::1`

### **URLs de Acesso:**
- **Principal:** http://72.60.125.120:8000
- **Alternativa IPv4:** http://72.60.125.120:8000
- **Local (apenas no servidor):** http://localhost:8000
- **Local (todas interfaces):** http://0.0.0.0:8000

## 🔐 **Credenciais de Login**
- **Usuário:** `admin`
- **Senha:** `password`
- **Tipo:** Super Administrador

## 🚀 **Como Iniciar o Servidor**

### **Método 1: Script Automático (Recomendado)**
```bash
cd /root/projeto_manager/laravel-project
./start-server.sh
```

### **Método 2: Manual**
```bash
cd /root/projeto_manager/laravel-project
php artisan serve --host=0.0.0.0 --port=8000
```

### **Método 3: Com IP específico**
```bash
cd /root/projeto_manager/laravel-project
php artisan serve --host=72.60.125.120 --port=8000
```

## 🔥 **Firewall e Portas**
- **Porta 8000:** Aberta para todas as interfaces
- **UFW Status:** Inativo (todas portas liberadas)
- **Rede:** Interface eth0 configurada

## 📋 **Para Verificar Status**
```bash
# Verificar se o servidor está rodando
netstat -tulpn | grep :8000

# Verificar processos do artisan
ps aux | grep artisan

# Testar conectividade local
curl -I http://localhost:8000
```

## ⚠️ **Notas Importantes**
1. O servidor Laravel roda na porta **8000**
2. Certifique-se de que a porta 8000 está liberada no firewall do provedor
3. O IP público pode mudar se o VPS for reiniciado
4. Para uso em produção, considere usar nginx/apache como proxy reverso

## 🌍 **Acesso Externo**
Para acessar externamente, use: **http://72.60.125.120:8000**

Se não conseguir acessar externamente, verifique:
1. Firewall do provedor VPS
2. Configurações de rede da Vultr/DigitalOcean
3. Se o servidor está rodando: `ps aux | grep artisan`