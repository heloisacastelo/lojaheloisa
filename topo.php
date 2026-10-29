<?php
// TOPO DO SITE (logo e menu)
// Cada página define a variável $titulo e depois faz: include 'topo.php';
include_once __DIR__ . '/conexao.php';
include_once __DIR__ . '/funcoes.php';

if (!isset($titulo)) {
    $titulo = 'LOJA CASTELO';
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo h($titulo); ?> - LOJA CASTELO</title>
    <link rel="stylesheet" href="estilo.css">
    <link rel="icon" href="imagens/logo.png">
</head>
<body>
<header class="topo">
    <a class="logo" href="index.php">
        <img src="imagens/logo.png" alt="Logo da loja">
        <span>LOJA CASTELO</span>
    </a>
    <nav class="menu">
        <a href="index.php">Vitrine</a>
        <a href="clientes.php"><img src="imagens/icone-clientes.png" alt="">Clientes</a>
        <a href="produtos.php"><img src="imagens/icone-produtos.png" alt="">Produtos</a>
        <a href="vendas.php"><img src="imagens/icone-vendas.png" alt="">Vendas</a>
    </nav>
</header>
<main class="conteudo">
