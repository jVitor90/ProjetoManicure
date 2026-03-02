<?php
require_once "../classes/agendamento_class.php";

// Processa o clique em concluir
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir_id'])){
    $id = (int)$_POST['excluir_id'];

    $agendamento = new Agendamento();
    $excluir = $agendamento->Excluir($id_agendamento);

    header("Location: " .$_SERVER['PHP_SELF']);
    exit;
}
?>