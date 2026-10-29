<?php
// RELATÓRIOS: um exemplo de cada tipo de JOIN
//
// JOIN = "juntar". Usamos quando a informação está em tabelas diferentes
// e queremos ver tudo junto, numa tabela só.
//
// Nossas tabelas:
//   cadastro (clientes)  --  venda  --  produto
//   A tabela venda liga as outras duas: cliente_id e produto_id.
//
// Cada exemplo abaixo mostra: o que faz, o SQL e o resultado.
$titulo = 'Relatórios';
include 'topo.php';

// Esta função executa um SQL e mostra o resultado numa tabela.
// $colunas = lista de colunas que queremos mostrar.
function mostrar_exemplo($pdo, $nome, $explicacao, $sql, $colunas)
{
    echo '<section class="exemplo">';
    echo '<h2>' . h($nome) . '</h2>';
    echo '<p>' . $explicacao . '</p>';
    echo '<pre>' . h($sql) . '</pre>';

    // try/catch: se esta versão do SQLite não conhecer o comando, mostramos um aviso
    try {
        $linhas = $pdo->query($sql)->fetchAll();
    } catch (PDOException $erro) {
        echo '<div class="aviso">Seu SQLite não aceita este comando: ' . h($erro->getMessage()) . '</div>';
        echo '</section>';
        return;
    }

    if (count($linhas) == 0) {
        echo '<p class="vazio">Nenhum resultado.</p>';
    } else {
        echo '<table><tr>';
        foreach ($colunas as $coluna) {
            echo '<th>' . h($coluna) . '</th>';
        }
        echo '</tr>';
        foreach ($linhas as $linha) {
            echo '<tr>';
            foreach ($colunas as $coluna) {
                // Se o valor for vazio (NULL), mostramos um traço
                if ($linha[$coluna] === null) {
                    echo '<td>-</td>';
                } else {
                    echo '<td>' . h($linha[$coluna]) . '</td>';
                }
            }
            echo '</tr>';
        }
        echo '</table>';
    }
    echo '</section>';
}
?>
<h1>Relatórios com JOIN</h1>
<p>Cada bloco abaixo usa um tipo de JOIN. Compare os resultados!</p>
<br>

<?php
// 1) JOIN (é o mesmo que INNER JOIN)
mostrar_exemplo(
    $pdo,
    '1) JOIN',
    'Escrever só <b>JOIN</b> é igual a <b>INNER JOIN</b>. Mostra cada venda com o nome do cliente.',
    'SELECT venda.id, cadastro.nome AS cliente, venda.valor_total
FROM venda
JOIN cadastro ON cadastro.id = venda.cliente_id',
    ['id', 'cliente', 'valor_total']
);

// 2) INNER JOIN
mostrar_exemplo(
    $pdo,
    '2) INNER JOIN',
    'Traz só o que tem par nas <b>duas</b> tabelas. Clientes que nunca compraram <b>não aparecem</b>.',
    'SELECT cadastro.nome AS cliente, produto.nome AS produto, venda.quantidade
FROM venda
INNER JOIN cadastro ON cadastro.id = venda.cliente_id
INNER JOIN produto  ON produto.id  = venda.produto_id',
    ['cliente', 'produto', 'quantidade']
);

// 3) LEFT JOIN
mostrar_exemplo(
    $pdo,
    '3) LEFT JOIN',
    'Traz <b>todos os clientes</b> (tabela da esquerda), mesmo os que nunca compraram. Quem não comprou fica com "-" no produto.',
    'SELECT cadastro.nome AS cliente, venda.id AS venda, venda.valor_total
FROM cadastro
LEFT JOIN venda ON venda.cliente_id = cadastro.id',
    ['cliente', 'venda', 'valor_total']
);

// 4) RIGHT JOIN
mostrar_exemplo(
    $pdo,
    '4) RIGHT JOIN',
    'Traz <b>todos os produtos</b> (tabela da direita), mesmo os que nunca foram vendidos. É o contrário do LEFT JOIN.',
    'SELECT produto.nome AS produto, venda.id AS venda, venda.quantidade
FROM venda
RIGHT JOIN produto ON produto.id = venda.produto_id',
    ['produto', 'venda', 'quantidade']
);

// 5) FULL OUTER JOIN
mostrar_exemplo(
    $pdo,
    '5) FULL OUTER JOIN',
    'Traz <b>tudo dos dois lados</b>: clientes sem compra e vendas sem cliente aparecem. Onde não há par, fica "-".',
    'SELECT cadastro.nome AS cliente, venda.id AS venda
FROM cadastro
FULL OUTER JOIN venda ON venda.cliente_id = cadastro.id',
    ['cliente', 'venda']
);

// 6) CROSS JOIN
mostrar_exemplo(
    $pdo,
    '6) CROSS JOIN',
    'Combina <b>cada cliente com cada produto</b> (sem ON). Com 3 clientes e 4 produtos dá 12 linhas. Útil para listar todas as possibilidades.',
    'SELECT cadastro.nome AS cliente, produto.nome AS produto
FROM cadastro
CROSS JOIN produto',
    ['cliente', 'produto']
);

// 7) SELF JOIN
mostrar_exemplo(
    $pdo,
    '7) SELF JOIN',
    'A tabela é juntada com <b>ela mesma</b>. Aqui achamos pares de clientes que moram na mesma cidade. Usamos dois apelidos: a e b.',
    'SELECT a.nome AS cliente_1, b.nome AS cliente_2, a.cidade AS cidade
FROM cadastro a
INNER JOIN cadastro b ON a.cidade = b.cidade AND a.id < b.id',
    ['cliente_1', 'cliente_2', 'cidade']
);

// 8) NATURAL JOIN
mostrar_exemplo(
    $pdo,
    '8) NATURAL JOIN',
    'Junta sozinho pelas colunas que têm <b>o mesmo nome</b> nas duas tabelas (sem ON). Aqui a coluna em comum é <i>produto_id</i>.',
    'SELECT produtos.produto, venda.quantidade, venda.valor_total
FROM (SELECT id AS produto_id, nome AS produto FROM produto) AS produtos
NATURAL JOIN venda',
    ['produto', 'quantidade', 'valor_total']
);

// 9) Relatório útil: quanto cada cliente já gastou (LEFT JOIN + SUM + GROUP BY)
mostrar_exemplo(
    $pdo,
    '9) Extra: quanto cada cliente já gastou',
    'LEFT JOIN com <b>SUM</b> (somar) e <b>GROUP BY</b> (agrupar por cliente). Clientes sem compra ficam com 0.',
    'SELECT cadastro.nome AS cliente,
       COUNT(venda.id) AS compras,
       COALESCE(SUM(venda.valor_total), 0) AS total_gasto
FROM cadastro
LEFT JOIN venda ON venda.cliente_id = cadastro.id
GROUP BY cadastro.id
ORDER BY total_gasto DESC',
    ['cliente', 'compras', 'total_gasto']
);
?>

<?php include 'rodape.php'; ?>
