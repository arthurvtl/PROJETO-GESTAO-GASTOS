<?php
    // Inclui o arquivo de configuração
    require_once './config.php';

    // Filtra e sanitiza os dados recebidos do formulário
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);
    $nascimento = filter_input(INPUT_POST, 'nascimento', FILTER_SANITIZE_SPECIAL_CHARS);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS);
    $confirmar_senha = filter_input(INPUT_POST, 'confirmar_senha', FILTER_SANITIZE_SPECIAL_CHARS);

    $nascimento = date('Y-m-d', strtotime(str_replace('/', '-', $nascimento)));


    // Verifica se o nome, email e data de nascimento foram preenchidos corretamente
    if($nome && $email && $nascimento){

        // Atualiza os dados do usuário no banco de dados
        $sql = $pdo->prepare("UPDATE users SET nome = :nome, email = :email, nascimento = :nascimento WHERE id = :id");
        $sql->bindValue(":id", $_SESSION['login']['id']); // Usa o ID do usuário logado
        $sql->bindValue(":nome", $nome);
        $sql->bindValue(":email", $email);
        $sql->bindValue(":nascimento", $nascimento);
        $sql->execute();
        $_SESSION['warning'] = '';

        // Verifica se a senha e a confirmação de senha foram fornecidas
        if($senha && $confirmar_senha){
            $hash = password_hash($senha, PASSWORD_BCRYPT); // Gera um hash da nova senha

            // Verifica se as senhas fornecidas coincidem
            if($senha === $confirmar_senha){
                // Atualiza a senha do usuário no banco de dados
                $dataUSer = $pdo->prepare("UPDATE users SET senha = :senha WHERE id = :id");
                $dataUSer->bindValue(":id", $_SESSION['login']['id']); // Usa o ID do usuário logado
                $dataUSer->bindValue(":senha", $hash);
                $dataUSer->execute();

                $_SESSION['warning'] = '';
                header('location: '.$base); // Redireciona para a página inicial
                exit;
            }else{
                $_SESSION['warning'] = 'Senhas não conferem!'; // Senhas não coincidem
                header('location: '.$base.'/configuracoes.php'); // Redireciona de volta para a página de configurações
                exit;
            }
        }

        header('location: '.$base); // Redireciona para a página inicial se não houver necessidade de atualizar a senha
        exit;
        
    }else{
        $_SESSION['warning'] = 'Preencha todos os campos corretamente!'; // Mensagem se algum campo não foi preenchido corretamente
        header('location: '.$base.'/configuracoes.php'); // Redireciona de volta para a página de configurações
        exit;
    }
?>
