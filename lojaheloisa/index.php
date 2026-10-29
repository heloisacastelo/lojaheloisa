<?php
// PÁGINA INICIAL (vitrine)
$titulo = 'Vitrine';
include 'topo.php';

// Contamos quantos registros existem em cada tabela
$total_clientes = $pdo->query('SELECT COUNT(*) FROM cadastro')->fetchColumn();
$total_produtos = $pdo->query('SELECT COUNT(*) FROM produto')->fetchColumn();
$total_vendas   = $pdo->query('SELECT COUNT(*) FROM venda')->fetchColumn();
$soma_vendas    = $pdo->query('SELECT SUM(valor_total) FROM venda')->fetchColumn();

// Buscamos todos os produtos para a vitrine
$produtos = $pdo->query('SELECT * FROM produto ORDER BY nome')->fetchAll();
?>
<h1>Bem-vindo à LOJA CASTELO</h1>

<div class="painel">
    <a href="clientes.php">
        <img src="https://raw.githubusercontent.com/microsoft/fluentui-emoji/main/assets/Busts%20in%20silhouette/3D/busts_in_silhouette_3d.png" alt="">
        <strong><?php echo $total_clientes; ?></strong>
        Clientes
    </a>
    <a href="produtos.php">
        <img src="https://raw.githubusercontent.com/microsoft/fluentui-emoji/main/assets/Package/3D/package_3d.png" alt="">
        <strong><?php echo $total_produtos; ?></strong>
        Produtos
    </a>
    <a href="vendas.php">
        <img src="https://raw.githubusercontent.com/microsoft/fluentui-emoji/main/assets/Receipt/3D/receipt_3d.png" alt="">
        <strong><?php echo $total_vendas; ?></strong>
        Vendas (<?php echo moeda($soma_vendas); ?>)
    </a>
</div>

<h2>Nossos produtos</h2>
<br>

<?php if (count($produtos) == 0) { ?>
    <p class="vazio">Nenhum produto cadastrado ainda.
        <a href="produto_form.php">Cadastrar o primeiro</a>.</p>
<?php } else { ?>
    <div class="vitrine">
        <?php foreach ($produtos as $produto) { ?>
            <div class="card">
                <img src="<?php echo h(preg_match('~^https?://~i', $produto['imagem']) ? $produto['imagem'] : 'imagens/' . rawurlencode($produto['imagem'])); ?>" alt="">
                <h3><?php echo h($produto['nome']); ?></h3>
                <p><?php echo h($produto['descricao']); ?></p>
                <span class="preco"><?php echo moeda($produto['preco']); ?></span>
                <a class="botao" href="venda_form.php?produto_id=<?php echo $produto['id']; ?>">Comprar</a>
            </div>
        <?php } ?>
    </div>
<?php } ?>

<?php include 'rodape.php'; ?>
