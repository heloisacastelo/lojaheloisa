-- Tabelas da loja (mesma estrutura que você criou no SQLite Portable)

CREATE TABLE IF NOT EXISTS cadastro (
    id       INTEGER PRIMARY KEY AUTOINCREMENT,
    nome     TEXT NOT NULL,
    email    TEXT,
    telefone TEXT,
    cidade   TEXT
);

CREATE TABLE IF NOT EXISTS produto (
    id        INTEGER PRIMARY KEY AUTOINCREMENT,
    nome      TEXT NOT NULL,
    descricao TEXT,
    preco     REAL NOT NULL,
    imagem    TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS venda (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    cliente_id  INTEGER NOT NULL,
    produto_id  INTEGER NOT NULL,
    quantidade  INTEGER NOT NULL,
    valor_total REAL NOT NULL,
    data_venda  TEXT NOT NULL,
    FOREIGN KEY (cliente_id) REFERENCES cadastro (id),
    FOREIGN KEY (produto_id) REFERENCES produto (id)
);
