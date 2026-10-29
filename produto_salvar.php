<?php
// SALVAR PRODUTO: INSERT (id = 0) ou UPDATE (id > 0)
include_once 'conexao.php';
include_once 'funcoes.php';

$id        = (int) pegar_post('id', 0);
$nome      = trim(pegar_post('nome'));
$descricao = trim(pegar_post('descricao'));
$preco     = trim(pegar_post('preco'));
$imagem    = trim(pegar_post('imagem'));

// Links da internet ficam completos; nomes de arquivos locais ficam só com o nome do arquivo.
if (!preg_match('~^https?://~i', $imagem)) {
    $imagem = basename($imagem);
}

// Aceita vírgula no preço (10,50 vira 10.50)
$preco = str_replace(',', '.', $preco);

// A coluna "imagem" não aceita vazio, então usamos uma imagem padrão
if ($imagem == '') {
    $imagem = 'icone-produtos.png';
}

// Validação: nome preenchido e preço numérico
if ($nome == '' || !is_numeric($preco) || $preco < 0) {
    if ($id > 0) {
        redirecionar('produto_form.php?erro=1&id=' . $id);
    }
    redirecionar('produto_form.php?erro=1');
}

if ($id > 0) {
    $sql  = 'UPDATE produto SET nome = ?, descricao = ?, preco = ?, imagem = ? WHERE id = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $descricao, $preco, $imagem, $id]);
} else {
    $sql  = 'INSERT INTO produto (nome, descricao, preco, imagem) VALUES (?, ?, ?, ?)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $descricao, $preco, $imagem]);
}

redirecionar('produtos.php?msg=salvo');
