<?php
// LISTA DE VENDAS  (R = Read = SELECT com INNER JOIN)
$titulo = 'Vendas';
include 'topo.php';

// A tabela "venda" guarda só números (cliente_id e produto_id).
// Para mostrar os NOMES, juntamos as 3 tabelas com INNER JOIN.
//
//   venda.cliente_id  --->  cadastro.id   (de quem é a venda)
//   venda.produto_id  --->  produto.id    (o que foi vendido)
//
// INNER JOIN = traz só as linhas que têm par nas duas tabelas.
$sql = 'SELECT venda.id,
               venda.quantidade,
               venda.valor_total,
               venda.data_venda,
               cadastro.nome AS cliente,
               produto.nome  AS produto
        FROM venda
        INNER JOIN cadastro ON cadastro.id = venda.cliente_id
        INNER JOIN produto  ON produto.id  = venda.produto_id
        ORDER BY venda.data_venda DESC, venda.id DESC';
$vendas = $pdo->query($sql)->fetchAll();

// Somamos o total de todas as vendas
$total_geral = 0;
foreach ($vendas as $venda) {
    $total_geral = $total_geral + $venda['valor_total'];
}

$msg = pegar_get('msg');
?>
<div class="barra">
    <h1>Vendas</h1>
    <a class="botao" href="venda_form.php">+ Nova venda</a>
</div>

<?php if ($msg == 'salvo') { ?>
    <div class="aviso ok">Venda salva com sucesso.</div>
<?php } ?>
<?php if ($msg == 'excluido') { ?>
    <div class="aviso ok">Venda excluída.</div>
<?php } ?>

<?php if (count($vendas) == 0) { ?>
    <p class="vazio">Nenhuma venda registrada.</p>
<?php } else { ?>
    <table>
        <tr>
            <th>#</th>
            <th>Data</th>
            <th>Cliente</th>
            <th>Produto</th>
            <th>Qtd.</th>
            <th>Total</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($vendas as $venda) { ?>
            <tr>
                <td><?php echo $venda['id']; ?></td>
                <td><?php echo data_br($venda['data_venda']); ?></td>
                <td><?php echo h($venda['cliente']); ?></td>
                <td><?php echo h($venda['produto']); ?></td>
                <td><?php echo $venda['quantidade']; ?></td>
                <td><?php echo moeda($venda['valor_total']); ?></td>
                <td class="acoes">
                    <a class="botao pequeno" href="venda_form.php?id=<?php echo $venda['id']; ?>">Editar</a>
                    <a class="botao pequeno perigo" href="venda_excluir.php?id=<?php echo $venda['id']; ?>">Excluir</a>
                </td>
            </tr>
        <?php } ?>
        <tr>
            <td colspan="5"><strong>Total geral</strong></td>
            <td colspan="2"><strong><?php echo moeda($total_geral); ?></strong></td>
        </tr>
    </table>
<?php } ?>

<?php include 'rodape.php'; ?>
