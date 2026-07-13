<?php
spl_autoload_register(function ($namespace) {

    $caminhoRelativo = str_replace('App\\', '', $namespace);
    
    $partes = explode('\\', $caminhoRelativo);
    
    $partes[0] = strtolower($partes[0]);
    
    $arquivo = __DIR__ . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $partes) . ".php";
    
    if (file_exists($arquivo)) {
        require_once $arquivo;
    }
});