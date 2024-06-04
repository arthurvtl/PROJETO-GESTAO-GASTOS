<?php
    // Inclui o arquivo de configuração
    require_once './config.php';

    // Limpa a sessão de login, efetivamente fazendo logout do usuário
    $_SESSION['login'] = '';

    // Redireciona o usuário para a página inicial
    header('location: '.$base);
    exit; // Encerra o script PHP
?>
