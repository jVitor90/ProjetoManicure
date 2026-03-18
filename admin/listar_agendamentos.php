<?php
/* =============================================================
 *  ACTION: Listar Agendamentos
 * ============================================================= */
session_start();
require_once '../classes/agendamento_class.php';


// Apenas admins autenticados
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['id_tipo'] != 1) {
    http_response_code(403);
    echo json_encode(['erro' => 'Acesso negado']);
    exit;
}

// Sanitização dos parâmetros
$nivel   = trim(filter_input(INPUT_GET, 'nivel',   FILTER_SANITIZE_SPECIAL_CHARS) ?? 'todos');
$data    = trim(filter_input(INPUT_GET, 'data',    FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
$servico = trim(filter_input(INPUT_GET, 'servico', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');

// Valida nível — somente valores aceitos
if (!in_array($nivel, ['todos', 'confirmado', 'pendente'])) {
    $nivel = 'todos';
}

// Valida formato da data
if ($data !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $data)) {
    $data = '';
}

// todos = sem filtro de status
$status = ($nivel !== 'todos') ? $nivel : '';

// Executa via classe
$agendamento  = new Agendamento();
$agendamentos = $agendamento->ListarAgendamentos($status, $data, $servico);

if ($agendamentos === false) {
    http_response_code(500);
    echo json_encode(['erro' => 'Erro ao buscar agendamentos']);
    exit;
}

echo json_encode(['agendamentos' => $agendamentos]);
exit;