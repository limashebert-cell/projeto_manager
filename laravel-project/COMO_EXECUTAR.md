## 🚀 COMO EXECUTAR O SERVIDOR LARAVEL

### MÉTODO 1: Script Automático (RECOMENDADO)
1. Abra o **Explorador de Arquivos**
2. Navegue até: `c:\projeto_manager\laravel-project`
3. **Duplo clique** no arquivo: `ultra_fix.bat`
4. Uma janela preta vai aparecer e executar automaticamente
5. Aguarde até aparecer "PROCESSO COMPLETO"
6. O navegador abrirá automaticamente

### MÉTODO 2: Via PowerShell
1. Pressione `Windows + R`
2. Digite: `powershell`
3. Cole e execute:
```
cd "c:\projeto_manager\laravel-project"
cmd /c ultra_fix.bat
```

### MÉTODO 3: Via CMD
1. Pressione `Windows + R`
2. Digite: `cmd`
3. Cole e execute:
```
cd c:\projeto_manager\laravel-project
ultra_fix.bat
```

### MÉTODO 4: Manual (Se outros falharem)
1. Abra PowerShell como Administrador
2. Execute cada comando:
```
cd c:\projeto_manager\laravel-project
php artisan serve --host=127.0.0.1 --port=8000
```
3. Abra navegador em: http://127.0.0.1:8000

---

## 🔑 CREDENCIAIS DE LOGIN
- **Usuário:** admin
- **Senha:** 123456

## 🌐 URL DE ACESSO
- **Principal:** http://127.0.0.1:8000
- **Alternativa:** http://127.0.0.1:8080

## ❗ SE DER ERRO
1. Execute novamente o `ultra_fix.bat`
2. Ou use o MÉTODO 4 (Manual)
3. Verifique se o PHP está instalado

## 📞 PROBLEMAS?
- Certifique-se de estar na pasta correta
- Execute como Administrador se necessário
- Verifique se a porta 8000 não está ocupada