<?php

require_once './config.php';

// Obtém os dados do POST e aplica a sanitização e validação
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);
$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS);

if($email && $senha){
    // Prepara a consulta para buscar o usuário pelo email
    $findByEmail = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $findByEmail->bindValue(":email", $email);
    $findByEmail->execute();

    // Verifica se o usuário foi encontrado
    if($findByEmail->rowCount() > 0){
        // Obtém os dados do usuário
        $user = $findByEmail->fetch(PDO::FETCH_ASSOC);

        // Verifica se a senha está correta
        if(password_verify($senha, $user['senha'])){
            $_SESSION['login'] = $user;
            $_SESSION['warning'] = '';
            header('location: '.$base);
            exit;
        } else {
            $_SESSION['warning'] = 'Email e/ou senha incorretas!';
            $_SESSION['login'] = '';
            header('location: '.$base.'/login.php');
            exit;
        }
    } else {
        $_SESSION['warning'] = 'Email e/ou senha incorretas!';
        $_SESSION['login'] = '';
        header('location: '.$base.'/login.php');
        exit;
    }
}

// Se os campos não estiverem preenchidos corretamente
$_SESSION['warning'] = 'Preencha todos os campos corretamente!';
header('location: '.$base.'/login.php');
exit;
?>
