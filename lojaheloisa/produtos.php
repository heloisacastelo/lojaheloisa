<?php
// LISTA DE PRODUTOS  (R = Read = SELECT)
$titulo = 'Produtos';
include 'topo.php';

$produtos = $pdo->query('SELECT * FROM produto ORDER BY nome')->fetchAll();
$msg = pegar_get('msg');
?>
<div class="barra">
    <h1>Produtos</h1>
    <a class="botao" href="produto_form.php">+ Novo produto</a>
</div>

<?php if ($msg == 'salvo') { ?>
    <div class="aviso ok">Produto salvo com sucesso.</div>
<?php } ?>
<?php if ($msg == 'excluido') { ?>
    <div class="aviso ok">Produto excluído.</div>
<?php } ?>
<?php if ($msg == 'comvendas') { ?>
    <div class="aviso erro">Este produto tem vendas. Exclua as vendas dele primeiro.</div>
<?php } ?>

<?php if (count($produtos) == 0) { ?>
    <p class="vazio">Nenhum produto cadastrado.</p>
<?php } else { ?>
    <table>
        <tr>
            <th>#</th>
            <th>Imagem</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Preço</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($produtos as $produto) { ?>
            <tr>
                <td><?php echo $produto['id']; ?></td>
                <td><img class="mini" src="<?php echo h(preg_match('~^https?://~i', $produto['imagem']) ? $produto['imagem'] : 'imagens/' . rawurlencode($produto['imagem'])); ?>" alt=""></td>
                <td><?php echo h($produto['nome']); ?></td>
                <td><?php echo h($produto['descricao']); ?></td>
                <td><?php echo moeda($produto['preco']); ?></td>
                <td class="acoes">
                    <a class="botao pequeno" href="produto_form.php?id=<?php echo $produto['id']; ?>">Editar</a>
                    <a class="botao pequeno perigo" href="produto_excluir.php?id=<?php echo $produto['id']; ?>">Excluir</a>
                </td>
            </tr>
        <?php } ?>
    </table>
<?php } ?>

<?php include 'rodape.php'; ?>
