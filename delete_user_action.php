<?php
    // Inclui o arquivo de configuração
    require_once './config.php';

    // Obtém o ID do usuário da sessão
    $id = $_SESSION['login']['id'];

    // Filtra e obtém a senha digitada pelo usuário para confirmar a exclusão da conta
    $senha = filter_input(INPUT_POST, 'senhaDelete');

    // Verifica se o ID do usuário está presente na sessão
    if(!$id){
        // Se o ID não estiver presente, redireciona o usuário de volta para a página inicial
        header('location: '.$base);
        exit;
    }

    // Verifica se a senha digitada pelo usuário corresponde à senha armazenada na sessão
    if(password_verify($senha, $_SESSION['login']['senha'])){
        // Se as senhas coincidirem, continua com o processo de exclusão
        if($id){
            // Seleciona o usuário com base no ID para garantir que ele exista
            $sql = $pdo->prepare("SELECT * FROM users WHERE id = :id");
            $sql->bindValue(":id", $id);
            $sql->execute();
    
            // Verifica se o usuário existe no banco de dados
            if($sql->rowCount() > 0){
                // Se o usuário existir, exclui todos os itens associados a ele
                $sqlItems = $pdo->prepare("DELETE FROM item WHERE id_user = :id_user");
                $sqlItems->bindValue(":id_user", $id);
                $sqlItems->execute();
    
                // Exclui o próprio usuário
                $sqlUser = $pdo->prepare("DELETE FROM users WHERE id = :id");
                $sqlUser->bindValue(":id", $id);
                $sqlUser->execute();
    
                // Limpa a sessão de login e a mensagem de aviso
                $_SESSION['login'] = '';
                $_SESSION['warning'] = '';
                
                // Redireciona o usuário de volta para a página inicial
                header('location: '.$base);
                exit;
            }
        }
    }else{
        // Se a senha estiver incorreta, define uma mensagem de aviso e redireciona o usuário de volta para a página de configurações
        $_SESSION['warning'] = 'Senha incorreta!';
        header('location: '.$base.'/configuracoes.php');
        exit;
    }
?>
