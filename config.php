<?php
    // Inicia a sessão
    session_start();

    // URL base do projeto
    $base = 'http://localhost:8000';

    // Define o fuso horário padrão para 'America/Sao_Paulo'
    date_default_timezone_set('America/Sao_Paulo');

    // Conexão com o banco de dados MySQL usando PDO
    $pdo = new PDO('mysql:host=localhost;dbname=yenom', 'root', 'serra');
?>
