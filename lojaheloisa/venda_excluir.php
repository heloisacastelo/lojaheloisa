<?php
// EXCLUIR VENDA (pergunta primeiro, apaga depois)
include_once 'conexao.php';
include_once 'funcoes.php';

// ---------- PASSO 2: o usuário confirmou ----------
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int) pegar_post('id', 0);

    $stmt = $pdo->prepare('DELETE FROM venda WHERE id = ?');
    $stmt->execute([$id]);
    redirecionar('vendas.php?msg=excluido');
}

// ---------- PASSO 1: mostrar a pergunta ----------
$id = (int) pegar_get('id', 0);

// JOIN para mostrar o nome do cliente e do produto na pergunta
$sql = 'SELECT venda.id, venda.quantidade, venda.valor_total,
               cadastro.nome AS cliente,
               produto.nome  AS produto
        FROM venda
        INNER JOIN cadastro ON cadastro.id = venda.cliente_id
        INNER JOIN produto  ON produto.id  = venda.produto_id
        WHERE venda.id = ?';
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$venda = $stmt->fetch();

$titulo = 'Excluir venda';
include 'topo.php';

if ($venda == false) {
    echo '<div class="aviso erro">Venda não encontrada.</div>';
    include 'rodape.php';
    exit;
}
?>
<h1>Excluir venda</h1>

<form class="formulario" method="post">
    <p>
        Tem certeza que deseja excluir a venda #<?php echo $venda['id']; ?>:
        <strong><?php echo $venda['quantidade']; ?> x <?php echo h($venda['produto']); ?></strong>
        para <strong><?php echo h($venda['cliente']); ?></strong>
        (<?php echo moeda($venda['valor_total']); ?>)?
    </p>
    <input type="hidden" name="id" value="<?php echo $venda['id']; ?>">
    <div class="botoes">
        <button class="botao perigo" type="submit">Sim, excluir</button>
        <a class="botao cinza" href="vendas.php">Cancelar</a>
    </div>
</form>

<?php include 'rodape.php'; ?>
