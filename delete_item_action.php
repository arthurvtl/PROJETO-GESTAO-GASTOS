<?php
    // Inclui o arquivo de configuração
    require_once './config.php';

    // Obtém o ID do item a ser excluído via parâmetro GET
    $id = filter_input(INPUT_GET, 'id');

    // Verifica se o ID foi fornecido
    if(!$id){
        // Se o ID não foi fornecido, redireciona o usuário de volta para a página inicial
        header('location: '.$base);
        exit;
    }

    // Verifica se o ID foi fornecido e se é válido
    if($id){
        // Seleciona o item com base no ID fornecido para garantir que ele exista no banco de dados
        $sql = $pdo->prepare("SELECT * FROM item WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        // Verifica se o item existe no banco de dados
        if($sql->rowCount() > 0){
            // Se o item existir, exclui-o do banco de dados
            $sql = $pdo->prepare("DELETE FROM item WHERE id = :id");
            $sql->bindValue(":id", $id);
            $sql->execute();
        }
    }
    
    // Após a exclusão, redireciona o usuário de volta para a página inicial
    header('location: '.$base);
    exit;
?>
