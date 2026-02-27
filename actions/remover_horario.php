<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Não autorizado']);
    exit;
}

require_once '../classes/calendario_class.php';

$dados   = json_decode(file_get_contents('php://input'), true);
$acao    = $dados['acao']    ?? '';
$data    = $dados['data']    ?? '';
$horario = $dados['horario'] ?? '';

try {
    $calendario = new Calendario();

    if ($acao === 'limpar_tudo') {
        if (!$data) {
            echo json_encode(['sucesso' => false, 'mensagem' => 'Data inválida']);
            exit;
        }
        $calendario->LimparPorData($data);
    } elseif ($acao === 'remover_um') {
        if (!$data || !$horario) {
            echo json_encode(['sucesso' => false, 'mensagem' => 'Dados inválidos']);
            exit;
        }
        $calendario->RemoverHorario($data, $horario);
    } else {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Ação inválida']);
        exit;
    }

    echo json_encode(['sucesso' => true]);
} catch (Exception $e) {
    echo json_encode(['sucesso' => false, 'mensagem' => $e->getMessage()]);
}
