<?php
require_once './config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$novo_titulo = filter_input(INPUT_POST, 'novo_titulo', FILTER_SANITIZE_SPECIAL_CHARS);
$novo_tipo = filter_input(INPUT_POST, 'novo_tipo', FILTER_SANITIZE_SPECIAL_CHARS);
$newData = filter_input(INPUT_POST, 'newData', FILTER_SANITIZE_SPECIAL_CHARS);
$newValor = filter_input(INPUT_POST, 'newValor', FILTER_SANITIZE_SPECIAL_CHARS);

$newData = date('Y-m-d', strtotime(str_replace('/', '-', $newData)));
$newValor = str_replace(',', '.', $newValor);

if ($id && $novo_titulo && $novo_tipo && $newData && $newValor) {
    $sql = $pdo->prepare("UPDATE item SET titulo = :novo_titulo, tipo = :novo_tipo, data = :newData, valor = :newValor WHERE id = :id");
    $sql->bindValue(':id', $id);
    $sql->bindValue(':novo_titulo', $novo_titulo);
    $sql->bindValue(':novo_tipo', $novo_tipo);
    $sql->bindValue(':newData', $newData);
    $sql->bindValue(':newValor', $newValor);
    $sql->execute();
}

header('Location: index.php');
exit;
?>
