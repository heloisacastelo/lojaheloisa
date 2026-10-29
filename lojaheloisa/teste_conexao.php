<?php
// Teste da conexão com o banco (pode apagar depois)
require_once __DIR__ . '/conexao.php';

echo '<h1>Teste de conexão</h1>';
echo '<p>Conectado ao banco: <code>' . htmlspecialchars($caminho) . '</code></p>';

foreach (['cadastro', 'produto', 'venda'] as $tabela) {
    $total = $pdo->query("SELECT COUNT(*) FROM $tabela")->fetchColumn();
    echo "<p>Tabela <strong>$tabela</strong>: $total registro(s)</p>";
}
