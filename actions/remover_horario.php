<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Não autorizado']);
    exit;
}

require_once '../classes/banco_class.php';

$dados = json_decode(file_get_contents('php://input'), true);
$acao   = $dados['acao']    ?? '';
$data   = $dados['data']    ?? '';
$horario = $dados['horario'] ?? '';

try {
    $banco = Banco::conectar();

    // Limpar TODOS os horários de uma data
    if ($acao === 'limpar_tudo') {
        if (!$data) {
            echo json_encode(['sucesso' => false, 'mensagem' => 'Data inválida']);
            exit;
        }
        $stmt = $banco->prepare("DELETE FROM calendario WHERE data = :data");
        $stmt->bindParam(':data', $data);
        $stmt->execute();

    // Remover UM horário específico
    } elseif ($acao === 'remover_um') {
        if (!$data || !$horario) {
            echo json_encode(['sucesso' => false, 'mensagem' => 'Dados inválidos']);
            exit;
        }
        $stmt = $banco->prepare("DELETE FROM calendario WHERE data = :data AND horario = :horario");
        $stmt->bindParam(':data', $data);
        $stmt->bindParam(':horario', $horario);
        $stmt->execute();

    } else {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Ação inválida']);
        exit;
    }

    Banco::desconectar();
    echo json_encode(['sucesso' => true]);

} catch (Exception $e) {
    echo json_encode(['sucesso' => false, 'mensagem' => $e->getMessage()]);
}