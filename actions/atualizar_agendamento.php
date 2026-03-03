<?php
require_once "../classes/agendamento_class.php";

// Processa o clique em concluir
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['atualizar_id'])){
    $id = (int)$_POST['atualizar_id'];

    $agendamento = new Agendamento();
    $sucesso = $agendamento->AtualizarAgendamento($id);
    echo json_encode(['sucesso' => $sucesso]);
    //header("Location: " .$_SERVER['PHP_SELF']);
    exit;
}
?>