<?php
// EXCLUIR CLIENTE  (D = Delete = DELETE)
// 1) Ao abrir a página, mostramos a pergunta "Tem certeza?"
// 2) Quando o usuário confirma (botão), o formulário envia e aí sim apagamos.
include_once 'conexao.php';
include_once 'funcoes.php';

// ---------- PASSO 2: o usuário confirmou ----------
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int) pegar_post('id', 0);

    // Não deixamos apagar quem já tem vendas
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM venda WHERE cliente_id = ?');
    $stmt->execute([$id]);
    $total_vendas = $stmt->fetchColumn();

    if ($total_vendas > 0) {
        redirecionar('clientes.php?msg=comvendas');
    }

    $stmt = $pdo->prepare('DELETE FROM cadastro WHERE id = ?');
    $stmt->execute([$id]);
    redirecionar('clientes.php?msg=excluido');
}

// ---------- PASSO 1: mostrar a pergunta ----------
$id = (int) pegar_get('id', 0);

$stmt = $pdo->prepare('SELECT * FROM cadastro WHERE id = ?');
$stmt->execute([$id]);
$cliente = $stmt->fetch();

$titulo = 'Excluir cliente';
include 'topo.php';

if ($cliente == false) {
    echo '<div class="aviso erro">Cliente não encontrado.</div>';
    include 'rodape.php';
    exit;
}
?>
<h1>Excluir cliente</h1>

<form class="formulario" method="post">
    <p>Tem certeza que deseja excluir <strong><?php echo h($cliente['nome']); ?></strong>?</p>
    <input type="hidden" name="id" value="<?php echo $cliente['id']; ?>">
    <div class="botoes">
        <button class="botao perigo" type="submit">Sim, excluir</button>
        <a class="botao cinza" href="clientes.php">Cancelar</a>
    </div>
</form>

<?php include 'rodape.php'; ?>
