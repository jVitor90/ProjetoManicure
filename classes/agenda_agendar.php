<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once('../classes/agendamento_class.php');
 
    // Inicia a sessão para verificar usuário logado
    session_start();
    $agendamento = new Agendamento();
    $agendamento->id_usuario_agenda = $_SESSION['usuario']['id'];
    $agendamento->id_calendario = strip_tags($_POST['horario']);
    $agendamento->id_servico = strip_tags($_POST['servico_id']);
 
 
    // Captura os dados do POST
    $servico_id = strip_tags($_POST['servico_id']);
    $horario_id = strip_tags($_POST['horario']);
 
    // Validações
    if (empty($servico_id)) {
        header('Location: ../Agendamento/index.php?err=servico_nao_selecionado');
        exit;
    } else if (empty($horario_id)) {
        header('Location: ../Agendamento/index.php?err=horario_nao_selecionado');
        exit;
    } else {
        // Verifica se o usuário está logado
        if (!isset($_SESSION['usuario']['id'])) {
            header('Location: ../login.php?err=usuario_nao_logado&redirect=agendamento');
            exit;
        }
    }
    $agendamento->Agendar();
    // Redireciona para a página de sucesso
    header('Location: ../Agendamento/index.php');
} else {
    echo "Essa página deve ser carregada por POST.";
}
?>