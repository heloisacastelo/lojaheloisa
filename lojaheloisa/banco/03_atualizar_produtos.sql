-- Atualiza os produtos que já existem no banco sem apagar vendas.
-- Execute no DB Browser for SQLite: Executar SQL > abrir/colar este arquivo > Executar > Gravar alterações.

-- Remove a palavra "Castelo" dos nomes existentes.
UPDATE produto
SET nome = TRIM(REPLACE(REPLACE(nome, ' Castelo', ''), ' castelo', ''))
WHERE lower(nome) LIKE '%castelo%';

-- Aplica as imagens enviadas para os produtos correspondentes.
UPDATE produto SET imagem = 'camiseta.png' WHERE lower(nome) LIKE '%camiseta%';
UPDATE produto SET imagem = 'caneca.png' WHERE lower(nome) LIKE '%caneca%';
UPDATE produto SET imagem = 'caderno.png' WHERE lower(nome) LIKE '%caderno%';
