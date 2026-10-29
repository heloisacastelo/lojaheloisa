<?php
// FUNÇÕES DE APOIO
// Uma função é um pedaço de código com nome, que podemos usar várias vezes.

// h() deixa o texto seguro para mostrar na tela (evita código malicioso)
function h($texto)
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

// moeda() transforma 1234.5 em "R$ 1.234,50"
function moeda($valor)
{
    return 'R$ ' . number_format($valor, 2, ',', '.');
}

// data_br() transforma "2026-10-27" em "27/10/2026"
function data_br($data)
{
    return date('d/m/Y', strtotime($data));
}

// redirecionar() leva o usuário para outra página
function redirecionar($pagina)
{
    header('Location: ' . $pagina);
    exit;
}

// pegar_get() lê um valor da URL (ex.: pagina.php?id=3). Se não existir, devolve o padrão
function pegar_get($nome, $padrao = '')
{
    if (isset($_GET[$nome])) {
        return $_GET[$nome];
    }
    return $padrao;
}

// pegar_post() lê um valor enviado por um formulário. Se não existir, devolve o padrão
function pegar_post($nome, $padrao = '')
{
    if (isset($_POST[$nome])) {
        return $_POST[$nome];
    }
    return $padrao;
}

// listar_imagens() devolve os nomes dos arquivos da pasta imagens
function listar_imagens()
{
    $pasta = __DIR__ . '/imagens';
    $lista = [];

    if (!is_dir($pasta)) {
        return $lista;
    }

    foreach (scandir($pasta) as $arquivo) {
        if ($arquivo === '.' || $arquivo === '..') {
            continue;
        }
        $extensao = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION));
        if (in_array($extensao, ['png', 'jpg', 'jpeg', 'gif', 'webp'], true)) {
            $lista[] = $arquivo;
        }
    }

    sort($lista);
    return $lista;
}
