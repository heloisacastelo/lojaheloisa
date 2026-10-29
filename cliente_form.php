<?php
// Carregamos a conexão e as funções ANTES de usar pegar_get()
include_once 'conexao.php';
include_once 'funcoes.php';

// FORMULÁRIO DE CLIENTE
// Serve para NOVO (sem id na URL) e para EDITAR (com id na URL: cliente_form.php?id=3)
$id = (int) pegar_get('id', 0);

// Começamos com os campos vazios (cliente novo)
$cliente = [
    'id'       => 0,
    'nome'     => '',
    'email'    => '',
    'telefone' => '',
    'cidade'   => '',
];

if ($id > 0) {
    $titulo = 'Editar cliente';
} else {
    $titulo = 'Novo cliente';
}
include 'topo.php';

// Se tem id, buscamos o cliente no banco para preencher o formulário
if ($id > 0) {
    $stmt = $pdo->prepare('SELECT * FROM cadastro WHERE id = ?');
    $stmt->execute([$id]);
    $encontrado = $stmt->fetch();

    if ($encontrado == false) {
        echo '<div class="aviso erro">Cliente não encontrado.</div>';
        include 'rodape.php';
        exit;
    }
    $cliente = $encontrado;
}
?>
<h1><?php echo h($titulo); ?></h1>

<?php if (pegar_get('erro') != '') { ?>
    <div class="aviso erro">Informe o nome do cliente.</div>
<?php } ?>

<form class="formulario" action="cliente_salvar.php" method="post">
    <input type="hidden" name="id" value="<?php echo $cliente['id']; ?>">

    <div class="campo">
        <label for="nome">Nome *</label>
        <input type="text" id="nome" name="nome" value="<?php echo h($cliente['nome']); ?>" required>
    </div>

    <div class="campo">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" value="<?php echo h($cliente['email']); ?>">
    </div>

    <div class="campo">
        <label for="telefone">Telefone</label>
        <input type="text" id="telefone" name="telefone" value="<?php echo h($cliente['telefone']); ?>">
    </div>

    <div class="campo">
        <label for="cidade">Cidade</label>
        <input type="text" id="cidade" name="cidade" value="<?php echo h($cliente['cidade']); ?>">
    </div>

    <div class="botoes">
        <button class="botao" type="submit">Salvar</button>
        <a class="botao cinza" href="clientes.php">Cancelar</a>
    </div>
</form>

<?php include 'rodape.php'; ?>
