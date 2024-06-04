<?php
    // Inclui o arquivo de configuração, onde podem estar as configurações de conexão com o banco de dados ou constantes globais
    require_once './config.php';

    // Filtra e sanitiza os dados enviados pelo formulário
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);
    $nascimento = date('Y-m-d', strtotime(filter_input(INPUT_POST, 'nascimento')));
    $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS);
    $confirma_senha = filter_input(INPUT_POST, 'confirma_senha', FILTER_SANITIZE_SPECIAL_CHARS);
    $date = []; // Variável não utilizada no código

    // Verifica se todos os campos obrigatórios foram preenchidos
    if($nome && $email && $nascimento && $senha && $confirma_senha){
        // Verifica se as senhas coincidem
        if($senha === $confirma_senha){
            // Prepara uma consulta para verificar se o email já está cadastrado no banco de dados
            $findByEmail = $pdo->prepare("SELECT * FROM users WHERE email = :email ");
            $findByEmail->bindValue(":email", $email);
            $findByEmail->execute();

            // Se o email já estiver cadastrado, redireciona para a página de cadastro com uma mensagem de aviso
            if($findByEmail->rowCount() > 0){
                $_SESSION['login'] = '';
                $_SESSION['warning'] = 'Conta com email já existente!';
                header('location: '.$base.'/signup.php');
                exit;
            }

            // Gera um hash da senha usando o algoritmo bcrypt
            $hash = password_hash($senha, PASSWORD_BCRYPT);
            // Prepara uma consulta para inserir o novo usuário no banco de dados
            $sql = $pdo->prepare("INSERT INTO users (nome, email, senha, nascimento) VALUES (:nome, :email, :senha, :nascimento)");
            $sql->bindValue(":nome", $nome);
            $sql->bindValue(":email", $email);
            $sql->bindValue(":senha", $hash);
            $sql->bindValue(":nascimento", $nascimento);
            $sql->execute();

            // Prepara uma consulta para buscar o usuário recém-criado no banco de dados
            $sqlUser = $pdo->prepare("SELECT * FROM users WHERE email = :email AND senha = :senha");
            $sqlUser->bindValue(":email", $email);
            $sqlUser->bindValue(":senha", $hash);
            $sqlUser->execute();
            $dataUser = $sqlUser->fetch(PDO::FETCH_ASSOC);

            // Limpa qualquer mensagem de aviso e salva os dados do usuário na sessão
            $_SESSION['warning'] = '';
            $_SESSION['login'] = $dataUser;
            // Redireciona o usuário para a página inicial
            header('location: '.$base);
            exit;
        } else {
            // Se as senhas não coincidirem, redireciona para a página de cadastro com uma mensagem de aviso
            $_SESSION['warning'] = 'Senhas não conferem!';
            header('location: '.$base.'/signup.php');
            exit;
        }
    } else {
        // Se algum campo obrigatório não for preenchido, redireciona para a página de cadastro com uma mensagem de aviso
        $_SESSION['warning'] = 'Preencha todos os campos corretamente!';
        header('location: '.$base);
        exit;
    }
?>
