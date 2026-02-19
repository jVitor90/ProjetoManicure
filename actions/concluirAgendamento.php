<?php
require_once "../classes/agendamento_class.php";

// Processa o clique em concluir
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['concluir_id'])){
    $id = (int)$_POST['concluir_id'];

    $agendamento = new Agendamento();
    $sucesso = $agendamento->ConcluirAgendamento($id);

    header("Location: " .$_SERVER['PHP_SELF']);
    exit;
}
?>