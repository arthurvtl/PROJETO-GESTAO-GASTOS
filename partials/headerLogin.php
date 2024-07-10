<?php
    // Inclui o arquivo de configuração
    require_once './config.php';
?>

<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Importa o arquivo CSS de estilo -->
    <link rel="stylesheet" href="./public/css/style.css" />
    <!-- Importa o framework Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Importa os ícones do Font Awesome -->
    <script src="https://kit.fontawesome.com/b5afd26a30.js" crossorigin="anonymous"></script>
    <!-- Importa os ícones do Boxicons -->
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Define o ícone da página -->
    <link rel="icon" href="./public/imgs/logo_icon.png" />
    <!-- Título da página -->
    <title>Yenom</title>
</head>
<body class="bg-light">
    <header class="header">
        <!-- Link para sair da aplicação -->
        <a class="logo" href="<?=$base?>/exit_action.php"><img src="./public/imgs/logo2.png" alt="logo" /></a>
    </header>
