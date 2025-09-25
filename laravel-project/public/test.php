<?php
echo "<h1>Teste PHP Funcionando</h1>";
echo "<p>Data/Hora: " . date('Y-m-d H:i:s') . "</p>";
echo "<p>Diretório: " . __DIR__ . "</p>";
echo "<p>PHP Version: " . PHP_VERSION . "</p>";
?>
<script>
setTimeout(() => {
    window.location.href = '/login';
}, 3000);
</script>
<p>Redirecionando para login em 3 segundos...</p>