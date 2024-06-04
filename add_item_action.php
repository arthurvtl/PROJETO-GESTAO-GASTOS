<?php
    require_once './config.php';

    $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);
    $tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_SPECIAL_CHARS);
    $data = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_SPECIAL_CHARS); // Primeiro sanitiza como string
    $data = date('Y-m-d', strtotime(str_replace('/', '-', $data))); // Depois converte para Y-m-d
    $valor = filter_input(INPUT_POST, 'valor', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($titulo && $tipo && $data && $valor) {
        $sql = $pdo->prepare("INSERT INTO item
        (id_user, titulo, tipo, data, valor) VALUES
        (:id_user, :titulo, :tipo, :data, :valor)");
        $sql->bindValue(":id_user", $_SESSION['login']['id']);
        $sql->bindValue(":titulo", $titulo);
        $sql->bindValue(":tipo", $tipo);
        $sql->bindValue(":data", $data);
        $sql->bindValue(":valor", $valor);
        $sql->execute();
    }

    header('Location: ' . $base);
    exit;
?>