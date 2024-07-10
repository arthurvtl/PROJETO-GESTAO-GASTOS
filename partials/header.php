<?php
    // Verifica se a sessão foi iniciada
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Verifica se o usuário está logado e se 'login' é um array
    if (!isset($_SESSION['login']) || !is_array($_SESSION['login']) || !isset($_SESSION['login']['id'])) {
        header('Location: ' . $base . '/login.php');
        exit;
    }
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
    <title>Yenom</title>
</head>
<body class="bg-light">
<header class="header">
    <!-- Botão para abrir o modal -->
    <button type="button" class="openModal btn btn-light">Adicionar+</button>
    <!-- Link para retornar à página inicial -->
    <a class="logo" href="<?=$base?>"><img src="./public/imgs/logo2.png" alt="logo" /></a>
    <div class="menuArea">
        <ul class="ul">
            <!-- Nome do usuário logado com um ícone de menu -->
            <li class="menuItemPrimary"><?=explode(' ', $_SESSION['login']['nome'])[0]?><i class="fa-solid fa-bars"></i></li>
            <!-- Lista de opções do menu -->
            <ul id="ul2" class="ul2">

                <a href="<?=$base?>/graficos.php"><li id="item" class="menuItem">Gráficos</li></a>
                <!-- Opção para acessar as configurações -->
                <a href="<?=$base?>/configuracoes.php"><li id="item" class="menuItem">Configurações</li></a>
                <!-- Opção para sair da conta -->
                <a href="<?=$base?>/exit_action.php"><li id="item" style="border-radius: 0 0 5px 5px;" class="menuItem">Sair <i class="fa-solid fa-arrow-right-from-bracket"></i></li></a>
            </ul>
        </ul>
    </div>
</header>
<script>
    // Event listener para o ícone de menu
    let buttonMenu = document.querySelector(".fa-bars");

    buttonMenu.addEventListener("click", ()=>{
        // Adiciona ou remove a classe 'show' ao ul2 para exibir ou ocultar as opções do menu
        document.getElementById("ul2").classList.toggle("show");
    })
</script>
