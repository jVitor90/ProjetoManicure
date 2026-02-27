<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    http_response_code(401);
    echo json_encode(['erro' => 'Não autorizado']);
    exit();
}

require_once('../classes/calendario_class.php');
header('Content-Type: application/json');

try {
    $calendario = new Calendario();
    echo json_encode($calendario->ListarTodosHorariosAdmin());
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['erro' => 'Erro ao buscar horários']);
}