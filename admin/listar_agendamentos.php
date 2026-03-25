<?php
session_start();
require_once '../classes/agendamento_class.php';

header('Content-Type: application/json; charset=utf-8');

// Apenas admins autenticados
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['id_tipo'] != 1) {
    http_response_code(403);
    echo json_encode(['erro' => 'Acesso negado']);
    exit;
}

$nivel   = trim($_GET['nivel']   ?? 'todos');
$data    = trim($_GET['data']    ?? '');
$servico = trim($_GET['servico'] ?? '');

// Valida nível
if (!in_array($nivel, ['todos', 'confirmado', 'pendente'])) {
    $nivel = 'todos';
}

// Status para a classe ('' = todos)
$status = ($nivel !== 'todos') ? $nivel : '';

// Valida data (aceita YYYY-MM-DD ou vazio)
if ($data !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $data)) {
    $data = ''; // data inválida será ignorada
}

$agendamento = new Agendamento();

try {
    $agendamentos = $agendamento->ListarAgendamentos($status, $data, $servico);

    if ($agendamentos === false) {
        throw new Exception('Método ListarAgendamentos retornou false');
    }

    echo json_encode([
        'agendamentos' => $agendamentos ?? [],
        'debug'        => [
            'status'  => $status,
            'data'    => $data,
            'servico' => $servico,
            'total'   => count($agendamentos ?? [])
        ]
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'erro'    => 'Erro ao buscar agendamentos',
        'mensagem' => $e->getMessage(),
        'debug'   => [
            'status'  => $status,
            'data'    => $data,
            'servico' => $servico
        ]
    ]);
}

exit;