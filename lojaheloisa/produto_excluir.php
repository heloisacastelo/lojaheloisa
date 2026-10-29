<?php
// EXCLUIR PRODUTO (pergunta primeiro, apaga depois)
include_once 'conexao.php';
include_once 'funcoes.php';

// ---------- PASSO 2: o usuário confirmou ----------
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int) pegar_post('id', 0);

    // Não deixamos apagar produto que já foi vendido
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM venda WHERE produto_id = ?');
    $stmt->execute([$id]);
    $total_vendas = $stmt->fetchColumn();

    if ($total_vendas > 0) {
        redirecionar('produtos.php?msg=comvendas');
    }

    $stmt = $pdo->prepare('DELETE FROM produto WHERE id = ?');
    $stmt->execute([$id]);
    redirecionar('produtos.php?msg=excluido');
}

// ---------- PASSO 1: mostrar a pergunta ----------
$id = (int) pegar_get('id', 0);

$stmt = $pdo->prepare('SELECT * FROM produto WHERE id = ?');
$stmt->execute([$id]);
$produto = $stmt->fetch();

$titulo = 'Excluir produto';
include 'topo.php';

if ($produto == false) {
    echo '<div class="aviso erro">Produto não encontrado.</div>';
    include 'rodape.php';
    exit;
}
?>
<h1>Excluir produto</h1>

<form class="formulario" method="post">
    <p>Tem certeza que deseja excluir <strong><?php echo h($produto['nome']); ?></strong>?</p>
    <input type="hidden" name="id" value="<?php echo $produto['id']; ?>">
    <div class="botoes">
        <button class="botao perigo" type="submit">Sim, excluir</button>
        <a class="botao cinza" href="produtos.php">Cancelar</a>
    </div>
</form>

<?php include 'rodape.php'; ?>
