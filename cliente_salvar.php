<?php
// SALVAR CLIENTE
// Se id = 0  -> INSERT (cliente novo)
// Se id > 0  -> UPDATE (editar cliente que já existe)
include_once 'conexao.php';
include_once 'funcoes.php';

$id       = (int) pegar_post('id', 0);
$nome     = trim(pegar_post('nome'));
$email    = trim(pegar_post('email'));
$telefone = trim(pegar_post('telefone'));
$cidade   = trim(pegar_post('cidade'));

// O nome é obrigatório
if ($nome == '') {
    if ($id > 0) {
        redirecionar('cliente_form.php?erro=1&id=' . $id);
    }
    redirecionar('cliente_form.php?erro=1');
}

if ($id > 0) {
    // UPDATE: muda os dados do cliente que tem esse id
    $sql  = 'UPDATE cadastro SET nome = ?, email = ?, telefone = ?, cidade = ? WHERE id = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $email, $telefone, $cidade, $id]);
} else {
    // INSERT: cria um cliente novo
    $sql  = 'INSERT INTO cadastro (nome, email, telefone, cidade) VALUES (?, ?, ?, ?)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $email, $telefone, $cidade]);
}

redirecionar('clientes.php?msg=salvo');
