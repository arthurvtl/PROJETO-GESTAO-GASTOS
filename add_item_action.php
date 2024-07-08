<?php
require_once './config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);
$tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_SPECIAL_CHARS);
$data = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_SPECIAL_CHARS); 
$data = date('Y-m-d', strtotime(str_replace('/', '-', $data))); 
$valor = filter_input(INPUT_POST, 'valor', FILTER_SANITIZE_SPECIAL_CHARS);
$valor = str_replace(['.', ','], ['.', ','], $valor); 

if ($titulo && $tipo && $data && $valor) {
    $sql = $pdo->prepare("INSERT INTO item (id_user, titulo, tipo, data, valor) VALUES (:id_user, :titulo, :tipo, :data, :valor)");
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
