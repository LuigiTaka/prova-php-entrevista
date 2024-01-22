<?php

spl_autoload_register(function ($classe) {
    $prefixo = 'TestePratico\\';
    $diretorio = __DIR__ . '/src/';

    $tamanhoPrefixo = strlen($prefixo);

    if (strncmp($prefixo, $classe, $tamanhoPrefixo) !== 0) {
        return;
    }

    $nomeRelativo = substr($classe, $tamanhoPrefixo);
    $arquivo = $diretorio . str_replace('\\', '/', $nomeRelativo) . '.php';

    if (file_exists($arquivo)) {
        require $arquivo;
    }
});