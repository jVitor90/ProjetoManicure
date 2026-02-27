<?php
session_start();


header('Content-Type: application/json; charset=utf-8');



$raw  = file_get_contents('php://input');
$dados = json_decode($raw, true);

if (!$dados || !isset($dados['horarios'])) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Dados inválidos.']);
    exit;
}

require_once('../classes/calendario_class.php');

$cal = new Calendario();

foreach ($dados['horarios'] as $data => $horarios) {
    // Valida formato da data
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data)) continue;

    // Remove todos os horários dessa data antes de inserir
    $cal->RemoverPorData($data);

    // Insere os novos
    foreach ($horarios as $horario) {
        if (!preg_match('/^\d{2}:\d{2}$/', $horario)) continue;
        $cal->InserirHorario($data, $horario . ':00');
    }
}

echo json_encode(['sucesso' => true]);