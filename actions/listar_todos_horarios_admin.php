<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    http_response_code(401);
    echo json_encode(['erro' => 'Não autorizado']);
    exit();
}

require_once('../classes/banco_class.php');
header('Content-Type: application/json');

try {
    $banco = Banco::conectar();
    // Busca todos os horários a partir de hoje, agrupados por data
    $sql = "SELECT data, horario FROM calendario WHERE data >= CURDATE() ORDER BY data ASC, horario ASC";
    $cmd = $banco->prepare($sql);
    $cmd->execute();
    $rows = $cmd->fetchAll(PDO::FETCH_ASSOC);
    Banco::desconectar();

    $result = [];
    foreach ($rows as $row) {
        $data   = $row['data'];
        $horario = substr($row['horario'], 0, 5); // Garante formato HH:MM
        if (!isset($result[$data])) {
            $result[$data] = [];
        }
        $result[$data][] = $horario;
    }

    echo json_encode($result);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['erro' => 'Erro ao buscar horários']);
}