<!DOCTYPE html>
<html>
<head>
    <title>Teste Presença</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h2>Teste de Presença</h2>
    
    <form action="{{ route('admin.presencas.store') }}" method="POST" id="formPresenca">
        @csrf
        <input type="hidden" name="data" value="{{ date('Y-m-d') }}">
        
        <div>
            <label>Colaborador 1:</label>
            <input type="hidden" name="presencas[0][colaborador_id]" value="1">
            <select name="presencas[0][status]" required>
                <option value="presente">Presente</option>
                <option value="falta">Falta</option>
                <option value="atestado">Atestado</option>
                <option value="banco_horas">Banco de Horas</option>
            </select>
            <textarea name="presencas[0][observacoes]" placeholder="Observações"></textarea>
        </div>
        
        <button type="submit">Salvar Presença</button>
    </form>

    <script>
        document.getElementById('formPresenca').addEventListener('submit', function(e) {
            console.log('Formulário enviado!');
            
            // Verificar dados do form
            const formData = new FormData(this);
            for (let [key, value] of formData.entries()) {
                console.log(key, value);
            }
        });
    </script>
</body>
</html>