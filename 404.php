<?php require_once './config.php'; ?> <!-- Inclui o arquivo de configuração -->

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="stylesheet" href="./public/css/error.css" /> <!-- Inclui o arquivo CSS para estilizar a página de erro -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Página não encontrada!</title> <!-- Título da página -->
    </head>
    <body>
        <section class="sectionError">
            <img src="./public/imgs/error.png" alt="404" /> <!-- Imagem de erro -->
            <a href="<?=$base?>"><button>Voltar ao início</button></a> <!-- Botão para retornar à página inicial -->
        </section>
    </body>
</html>
