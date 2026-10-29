<?php
// Carregamos a conexão e as funções ANTES de usar pegar_get()
include_once 'conexao.php';
include_once 'funcoes.php';

// FORMULÁRIO DE PRODUTO (novo e editar)
$id = (int) pegar_get('id', 0);

$produto = [
    'id'        => 0,
    'nome'      => '',
    'descricao' => '',
    'preco'     => '',
    'imagem'    => 'icone-produtos.png',
];

if ($id > 0) {
    $titulo = 'Editar produto';
} else {
    $titulo = 'Novo produto';
}
include 'topo.php';

if ($id > 0) {
    $stmt = $pdo->prepare('SELECT * FROM produto WHERE id = ?');
    $stmt->execute([$id]);
    $encontrado = $stmt->fetch();

    if ($encontrado == false) {
        echo '<div class="aviso erro">Produto não encontrado.</div>';
        include 'rodape.php';
        exit;
    }
    $produto = $encontrado;
}

// Lista de imagens da pasta "imagens" para o usuário escolher
$imagens = listar_imagens();
?>
<h1><?php echo h($titulo); ?></h1>

<?php if (pegar_get('erro') != '') { ?>
    <div class="aviso erro">Informe o nome e um preço válido (zero ou mais).</div>
<?php } ?>

<form class="formulario" action="produto_salvar.php" method="post">
    <input type="hidden" name="id" value="<?php echo $produto['id']; ?>">

    <div class="campo">
        <label for="nome">Nome *</label>
        <input type="text" id="nome" name="nome" value="<?php echo h($produto['nome']); ?>" required>
    </div>

    <div class="campo">
        <label for="descricao">Descrição</label>
        <textarea id="descricao" name="descricao" rows="3"><?php echo h($produto['descricao']); ?></textarea>
    </div>

    <div class="campo">
        <label for="preco">Preço (R$) *</label>
        <input type="number" id="preco" name="preco" step="0.01" min="0"
               value="<?php echo h($produto['preco']); ?>" required>
    </div>

    <div class="campo">
        <label for="imagem">Imagem (link da internet ou arquivo)</label>
        <input type="text" id="imagem" name="imagem"
               value="<?php echo h($produto['imagem']); ?>"
               placeholder="https://.../imagem.png ou logo.png">
        <small>Use um link iniciado por https:// ou o nome de um arquivo salvo em imagens/.</small>
        <?php if (count($imagens) > 0) { ?>
            <small>Arquivos locais disponíveis: <?php echo h(implode(', ', $imagens)); ?></small>
        <?php } ?>
    </div>

    <div class="botoes">
        <button class="botao" type="submit">Salvar</button>
        <a class="botao cinza" href="produtos.php">Cancelar</a>
    </div>
</form>

<?php include 'rodape.php'; ?>
