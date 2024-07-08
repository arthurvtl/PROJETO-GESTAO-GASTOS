<?php
// graficos_action.php

require_once './config.php';

// Verifica se a sessão está ativa e se o índice 'login' está definido
if (isset($_SESSION['login']) && isset($_SESSION['login']['id'])) {
    $user_id = $_SESSION['login']['id'];
} else {
    header('Location: login.php');
    exit;
}

// Buscar dados do banco de dados
$sql = "
    SELECT 
        DATE_FORMAT(data, '%Y-%m') AS mes,
        SUM(CASE WHEN tipo = 'Entrada' THEN CAST(REPLACE(valor, ',', '.') AS DECIMAL(10, 2)) ELSE 0 END) AS total_entradas,
        SUM(CASE WHEN tipo = 'Saída' THEN CAST(REPLACE(valor, ',', '.') AS DECIMAL(10, 2)) ELSE 0 END) AS total_saidas
    FROM item
    WHERE id_user = :id_user
    GROUP BY DATE_FORMAT(data, '%Y-%m')
    ORDER BY DATE_FORMAT(data, '%Y-%m')";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_user', $user_id, PDO::PARAM_INT);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$data = [
    'meses' => [],
    'entradas' => [],
    'saidas' => []
];

foreach ($results as $row) {
    $data['meses'][] = $row['mes'];
    $data['entradas'][] = $row['total_entradas'];
    $data['saidas'][] = $row['total_saidas'];
}

header('Content-Type: application/json');
echo json_encode($data);
?>
