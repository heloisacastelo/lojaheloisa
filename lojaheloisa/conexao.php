<?php
// CONEXÃO COM O BANCO SQLITE
$caminho = __DIR__ . '/banco/loja.db';

try {
    $pdo = new PDO('sqlite:' . $caminho);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Cria as tabelas caso o banco esteja vazio. Não apaga dados existentes.
    $pdo->exec("CREATE TABLE IF NOT EXISTS cadastro (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nome TEXT NOT NULL,
        email TEXT,
        telefone TEXT,
        cidade TEXT
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS produto (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nome TEXT NOT NULL,
        descricao TEXT,
        preco REAL NOT NULL,
        imagem TEXT NOT NULL
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS venda (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        cliente_id INTEGER NOT NULL,
        produto_id INTEGER NOT NULL,
        quantidade INTEGER NOT NULL,
        valor_total REAL NOT NULL,
        data_venda TEXT NOT NULL,
        FOREIGN KEY (cliente_id) REFERENCES cadastro (id),
        FOREIGN KEY (produto_id) REFERENCES produto (id)
    )");

} catch (PDOException $erro) {
    die('Não foi possível abrir o banco: ' . $erro->getMessage());
}
