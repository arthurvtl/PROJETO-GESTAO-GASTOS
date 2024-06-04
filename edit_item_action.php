<?php
    // Inclui o arquivo de configuração
    require_once './config.php';

    // Filtra e sanitiza os dados recebidos do formulário
    $titulo = filter_input(INPUT_POST, 'novo_titulo', FILTER_SANITIZE_SPECIAL_CHARS);
    $tipo = filter_input(INPUT_POST, 'novo_tipo', FILTER_SANITIZE_SPECIAL_CHARS);
    $data = date('Y-m-d', strtotime(filter_input(INPUT_POST, 'newDate'))); // Converte a data para o formato YYYY-MM-DD
    $valor = filter_input(INPUT_POST, 'newValor', FILTER_SANITIZE_SPECIAL_CHARS);
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $date = [];

    // Verifica se todos os campos foram preenchidos corretamente
    if($titulo && $tipo && $data && $valor && $id){
        // Atualiza os dados do item no banco de dados
        $sql = $pdo->prepare("UPDATE item SET titulo = :titulo, tipo = :tipo, data = :data, valor = :valor WHERE id = :id AND id_user = :id_user");
        $sql->bindValue(":id_user", $_SESSION['login']['id']); // Adiciona o ID do usuário à cláusula WHERE para evitar que um usuário modifique itens de outros usuários
        $sql->bindValue(":titulo", $titulo);
        $sql->bindValue(":tipo", $tipo);
        $sql->bindValue(":data", $data);
        $sql->bindValue(":valor", $valor);
        $sql->bindValue(":id", $id);
        $sql->execute(); // Executa a consulta SQL para atualizar o item no banco de dados
    }

    // Redireciona o usuário de volta para a página inicial após a atualização
    header('location: '.$base);
    exit; // Encerra o script PHP
?>
