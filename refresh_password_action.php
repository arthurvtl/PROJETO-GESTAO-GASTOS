<?php
    // Inclui o arquivo de configuração
    require_once './config.php';

    // Filtra e sanitiza os dados recebidos do formulário
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);
    $nascimento = date('Y-m-d', strtotime(filter_input(INPUT_POST, 'nascimento')));
    $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS);
    $confirmar_senha = filter_input(INPUT_POST, 'confirmar_senha', FILTER_SANITIZE_SPECIAL_CHARS);

    // Verifica se todos os campos foram preenchidos corretamente
    if($nome && $email && $nascimento && $senha && $confirmar_senha){

        // Verifica se as senhas coincidem
        if($senha === $confirmar_senha){
            // Gera um hash da nova senha
            $hash = password_hash($senha, PASSWORD_BCRYPT);
            // Atualiza a senha do usuário no banco de dados
            $sql = $pdo->prepare("UPDATE users SET senha = :senha WHERE nome = :nome AND email = :email AND nascimento = :nascimento");
            $sql->bindValue(":nome", $nome);
            $sql->bindValue(":email", $email);
            $sql->bindValue(":nascimento", $nascimento);
            $sql->bindValue(":senha", $hash);
            $sql->execute();
            $_SESSION['warning'] = '';
            // Redireciona para a página de login após a atualização da senha
            header('location: '.$base.'/login.php');
            exit;
        }else{
            // Se as senhas não coincidirem, define uma mensagem de aviso e redireciona de volta para a página de redefinição de senha
            $_SESSION['warning'] = 'Senhas não conferem!';
            header('location: '.$base.'/forgot_password.php');
            exit;
        }
        
    }else{
        // Se algum campo não foi preenchido corretamente, define uma mensagem de aviso e redireciona de volta para a página de redefinição de senha
        $_SESSION['warning'] = 'Preencha todos os campos corretamente!';
        header('location: '.$base.'/forgot_password.php');
        exit;
    }
?>
