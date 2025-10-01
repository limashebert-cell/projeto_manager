<?php
// Script para testar autenticação
session_start();

echo "<h1>Teste de Autenticação</h1>";
echo "<pre>";
echo "Session ID: " . session_id() . "\n";
echo "Session data:\n";
print_r($_SESSION);
echo "\nCookies:\n";
print_r($_COOKIE);
echo "</pre>";

echo "<h2>Links de Teste</h2>";
echo '<a href="/login">Ir para Login</a><br>';
echo '<a href="/admin">Ir para Admin</a><br>';
echo '<a href="/admin/colaboradores">Ir para Colaboradores</a><br>';
echo '<a href="/admin/colaboradores/download-template">Download Template</a><br>';
?>