<?php
require_once "../classes/agendamento_class.php";

// Processa o clique em excluir
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['exclui_id'])){
    $id = (int)$_POST['exclui_id'];

    $agendamento = new Agendamento();
    $sucesso = $agendamento->Excluir($id);
    echo json_encode(['sucesso' => $sucesso]);
    exit;
}
?>