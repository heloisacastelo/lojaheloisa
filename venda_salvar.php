<?php
// SALVAR VENDA: INSERT (id = 0) ou UPDATE (id > 0)
// O valor total NÃO vem do formulário: o PHP calcula (preço x quantidade).
include_once 'conexao.php';
include_once 'funcoes.php';

$id         = (int) pegar_post('id', 0);
$cliente_id = (int) pegar_post('cliente_id', 0);
$produto_id = (int) pegar_post('produto_id', 0);
$quantidade = (int) pegar_post('quantidade', 0);
$data_venda = trim(pegar_post('data_venda'));

// Se der algum erro, voltamos para o formulário
$voltar = 'venda_form.php?erro=1';
if ($id > 0) {
    $voltar = 'venda_form.php?erro=1&id=' . $id;
}

// Validação simples
if ($cliente_id <= 0 || $produto_id <= 0 || $quantidade <= 0) {
    redirecionar($voltar);
}
if ($data_venda == '') {
    $data_venda = date('Y-m-d');
}

// O cliente existe?
$stmt = $pdo->prepare('SELECT COUNT(*) FROM cadastro WHERE id = ?');
$stmt->execute([$cliente_id]);
if ($stmt->fetchColumn() == 0) {
    redirecionar($voltar);
}

// Buscamos o preço do produto para calcular o total
$stmt = $pdo->prepare('SELECT preco FROM produto WHERE id = ?');
$stmt->execute([$produto_id]);
$produto = $stmt->fetch();

if ($produto == false) {
    redirecionar($voltar);
}

$valor_total = $produto['preco'] * $quantidade;

if ($id > 0) {
    $sql  = 'UPDATE venda SET cliente_id = ?, produto_id = ?, quantidade = ?, valor_total = ?, data_venda = ? WHERE id = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$cliente_id, $produto_id, $quantidade, $valor_total, $data_venda, $id]);
} else {
    $sql  = 'INSERT INTO venda (cliente_id, produto_id, quantidade, valor_total, data_venda) VALUES (?, ?, ?, ?, ?)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$cliente_id, $produto_id, $quantidade, $valor_total, $data_venda]);
}

redirecionar('vendas.php?msg=salvo');
