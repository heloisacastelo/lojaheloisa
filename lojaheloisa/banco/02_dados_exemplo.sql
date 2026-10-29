-- Dados de exemplo da loja
-- No DB Browser: aba "Executar SQL" > cole este texto > clique em Executar > "Gravar alterações".
-- Rode só UMA vez (senão os dados se repetem).

-- Clientes (a Ana e a Carla moram na mesma cidade: serve para o SELF JOIN)
-- O Diego não tem nenhuma compra: serve para ver a diferença entre INNER e LEFT JOIN
INSERT INTO cadastro (nome, email, telefone, cidade) VALUES
    ('Ana Souza',    'ana@email.com',    '(11) 91111-1111', 'São Paulo'),
    ('Bruno Lima',   'bruno@email.com',  '(21) 92222-2222', 'Rio de Janeiro'),
    ('Carla Mendes', 'carla@email.com',  '(11) 93333-3333', 'São Paulo'),
    ('Diego Castro', 'diego@email.com',  '(31) 94444-4444', 'Belo Horizonte');

-- Produtos: a coluna imagem guarda o link completo da imagem (Fluent Emoji 3D).
-- Se preferir, pode trocar cada URL por um nome de arquivo salvo em assets/imagens/.
-- O "Caderno" nunca foi vendido: serve para ver a diferença entre INNER e RIGHT JOIN
INSERT INTO produto (nome, descricao, preco, imagem) VALUES
    ('Camiseta',           'Camiseta de algodão',                         49.90,  'camiseta.png'),
    ('Caneca',             'Caneca de cerâmica 300 ml',                29.50,  'caneca.png'),
    ('Mochila',            'Mochila resistente com 3 divisórias',      159.00, 'https://raw.githubusercontent.com/microsoft/fluentui-emoji/main/assets/Backpack/3D/backpack_3d.png'),
    ('Caderno',            'Caderno universitário 200 folhas',         24.90,  'caderno.png');

-- Vendas (valor_total = preço x quantidade)
INSERT INTO venda (cliente_id, produto_id, quantidade, valor_total, data_venda) VALUES
    (1, 1, 2,  99.80, '2026-10-20'),
    (2, 2, 1,  29.50, '2026-10-22'),
    (3, 3, 1, 159.00, '2026-10-25'),
    (1, 2, 3,  88.50, '2026-10-26');
