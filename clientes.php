<?php
// LISTA DE CLIENTES  (R = Read = SELECT)
$titulo = 'Clientes';
include 'topo.php';

// Busca todos os clientes, em ordem alfabética
$clientes = $pdo->query('SELECT * FROM cadastro ORDER BY nome')->fetchAll();

// Mensagem que vem na URL (ex.: clientes.php?msg=salvo)
$msg = pegar_get('msg');
?>
<div class="barra">
    <h1>Clientes</h1>
    <a class="botao" href="cliente_form.php">+ Novo cliente</a>
</div>

<?php if ($msg == 'salvo') { ?>
    <div class="aviso ok">Cliente salvo com sucesso.</div>
<?php } ?>
<?php if ($msg == 'excluido') { ?>
    <div class="aviso ok">Cliente excluído.</div>
<?php } ?>
<?php if ($msg == 'comvendas') { ?>
    <div class="aviso erro">Este cliente tem vendas. Exclua as vendas dele primeiro.</div>
<?php } ?>

<?php if (count($clientes) == 0) { ?>
    <p class="vazio">Nenhum cliente cadastrado.</p>
<?php } else { ?>
    <table>
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Telefone</th>
            <th>Cidade</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($clientes as $cliente) { ?>
            <tr>
                <td><?php echo $cliente['id']; ?></td>
                <td><?php echo h($cliente['nome']); ?></td>
                <td><?php echo h($cliente['email']); ?></td>
                <td><?php echo h($cliente['telefone']); ?></td>
                <td><?php echo h($cliente['cidade']); ?></td>
                <td class="acoes">
                    <a class="botao pequeno" href="cliente_form.php?id=<?php echo $cliente['id']; ?>">Editar</a>
                    <a class="botao pequeno perigo" href="cliente_excluir.php?id=<?php echo $cliente['id']; ?>">Excluir</a>
                </td>
            </tr>
        <?php } ?>
    </table>
<?php } ?>

<?php include 'rodape.php'; ?>
