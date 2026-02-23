<?php

// Bloqueia acesso direto via GET
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Essa página deve ser carregada via POST.');
}

session_start();

if (!isset($_SESSION['usuario']['id'])) {
    header('Location: ../login.php?err=usuario_nao_logado&redirect=agendamento');
    exit;
}

require_once('../classes/agendamento_class.php');

$servico_id = strip_tags(trim($_POST['servico_id'] ?? ''));
$horario_id = strip_tags(trim($_POST['horario']    ?? ''));

if (empty($servico_id)) {
    header('Location: ../Agendamento/index.php?err=servico_nao_selecionado');
    exit;
}

if (empty($horario_id)) {
    header('Location: ../Agendamento/index.php?err=horario_nao_selecionado');
    exit;
}

try {
    $agendamento = new Agendamento();
    $agendamento->id_usuario_agenda = $_SESSION['usuario']['id'];
    $agendamento->id_calendario     = $horario_id;
    $agendamento->id_servico        = $servico_id;

    $agendamento->Agendar();

    header('Location: ../Agendamento/index.php?msg=sucesso');
    exit;

} catch (Exception $e) {
    header('Location: ../Agendamento/index.php?err=erro_ao_agendar');
    exit;
}