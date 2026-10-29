<?php
// Carregamos a conexão e as funções ANTES de usar pegar_get()
include_once 'conexao.php';
include_once 'funcoes.php';

// FORMULÁRIO DE VENDA (nova e editar)
$id = (int) pegar_get('id', 0);

// Valores iniciais de uma venda nova.
// Se veio da vitrine (botão Comprar), o produto já vem escolhido na URL.
$venda = [
    'id'         => 0,
    'cliente_id' => 0,
    'produto_id' => (int) pegar_get('produto_id', 0),
    'quantidade' => 1,
    'data_venda' => date('Y-m-d'),
];

if ($id > 0) {
    $titulo = 'Editar venda';
} else {
    $titulo = 'Nova venda';
}
include 'topo.php';

if ($id > 0) {
    $stmt = $pdo->prepare('SELECT * FROM venda WHERE id = ?');
    $stmt->execute([$id]);
    $encontrada = $stmt->fetch();

    if ($encontrada == false) {
        echo '<div class="aviso erro">Venda não encontrada.</div>';
        include 'rodape.php';
        exit;
    }
    $venda = $encontrada;
}

// Listas para os campos de escolha (select)
$clientes = $pdo->query('SELECT id, nome FROM cadastro ORDER BY nome')->fetchAll();
$produtos = $pdo->query('SELECT id, nome, preco FROM produto ORDER BY nome')->fetchAll();
?>
<h1><?php echo h($titulo); ?></h1>

<?php if (pegar_get('erro') != '') { ?>
    <div class="aviso erro">Escolha o cliente, o produto e uma quantidade maior que zero.</div>
<?php } ?>

<?php if (count($clientes) == 0 || count($produtos) == 0) { ?>
    <div class="aviso">
        Para vender, cadastre antes pelo menos um
        <a href="cliente_form.php">cliente</a> e um
        <a href="produto_form.php">produto</a>.
    </div>
<?php } else { ?>
    <form class="formulario" action="venda_salvar.php" method="post">
        <input type="hidden" name="id" value="<?php echo $venda['id']; ?>">

        <div class="campo">
            <label for="cliente_id">Cliente *</label>
            <select id="cliente_id" name="cliente_id" required>
                <option value="">Selecione...</option>
                <?php foreach ($clientes as $cliente) { ?>
                    <?php
                    $marcado = '';
                    if ($cliente['id'] == $venda['cliente_id']) {
                        $marcado = 'selected';
                    }
                    ?>
                    <option value="<?php echo $cliente['id']; ?>" <?php echo $marcado; ?>>
                        <?php echo h($cliente['nome']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="campo">
            <label for="produto_id">Produto *</label>
            <select id="produto_id" name="produto_id" required>
                <option value="">Selecione...</option>
                <?php foreach ($produtos as $produto) { ?>
                    <?php
                    $marcado = '';
                    if ($produto['id'] == $venda['produto_id']) {
                        $marcado = 'selected';
                    }
                    ?>
                    <option value="<?php echo $produto['id']; ?>" <?php echo $marcado; ?>>
                        <?php echo h($produto['nome']); ?> - <?php echo moeda($produto['preco']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="campo">
            <label for="quantidade">Quantidade *</label>
            <input type="number" id="quantidade" name="quantidade" min="1" step="1"
                   value="<?php echo $venda['quantidade']; ?>" required>
        </div>

        <div class="campo">
            <label for="data_venda">Data *</label>
            <input type="date" id="data_venda" name="data_venda"
                   value="<?php echo h($venda['data_venda']); ?>" required>
        </div>

        <p>O valor total é calculado sozinho: preço do produto × quantidade.</p>

        <div class="botoes">
            <button class="botao" type="submit">Salvar</button>
            <a class="botao cinza" href="vendas.php">Cancelar</a>
        </div>
    </form>
<?php } ?>

<?php include 'rodape.php'; ?>
