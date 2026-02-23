<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once('../classes/agendamento_class.php');
    require_once('../classes/usuario_class.php');
    require_once('../classes/banco_class.php');

    // Inicia a sessão para verificar usuário logado
    session_start();

    // Captura os dados do POST
    $cliente_nome = isset($_POST['cliente_nome']) ? strip_tags(trim($_POST['cliente_nome'])) : '';
    $servico_id = isset($_POST['servico_id']) ? strip_tags($_POST['servico_id']) : '';
    $horario_id = isset($_POST['horario']) ? strip_tags($_POST['horario']) : '';
    $data = isset($_POST['data']) ? strip_tags($_POST['data']) : '';

    // Validações
    if (empty($cliente_nome)) {
        header('Location: ../Dashboard/index.php?err=cliente_nao_selecionado');
        exit;
    } else if (empty($servico_id)) {
        header('Location: ../Dashboard/index.php?err=servico_nao_selecionado');
        exit;
    } else if (empty($horario_id)) {
        header('Location: ../Dashboard/index.php?err=horario_nao_selecionado');
        exit;
    } else if (empty($data)) {
        header('Location: ../Dashboard/index.php?err=data_nao_selecionada');
        exit;
    }

    // Verifica se o usuário admin está logado
    if (!isset($_SESSION['usuario']['id'])) {
        header('Location: ../login.php?err=usuario_nao_logado&redirect=dashboard');
        exit;
    }

    // Busca o usuário cliente pelo nome
    $sql = "SELECT id FROM usuarios WHERE (nome = ? OR CONCAT(nome, ' ', sobrenome) = ?) AND id_tipo = 2";
    $banco = Banco::conectar();
    $comando = $banco->prepare($sql);
    $comando->execute([$cliente_nome, $cliente_nome]);
    $usuario = $comando->fetch(PDO::FETCH_ASSOC);
    Banco::desconectar();

    if (!$usuario) {
        header('Location: ../Dashboard/index.php?err=cliente_nao_encontrado');
        exit;
    }

    $usuario_id = $usuario['id'];

    // Cria o agendamento
    $agendamento = new Agendamento();
    $agendamento->id_usuario_agenda = $usuario_id;
    $agendamento->id_calendario = $horario_id;
    $agendamento->id_servico = $servico_id;

    $resultado = $agendamento->Agendar();

    if ($resultado > 0) {
        header('Location: ../Dashboard/index.php?msg=agendamento_realizado');
    } else {
        header('Location: ../Dashboard/index.php?err=agendamento_falhou');
    }
    exit;
} else {
    echo "Essa página deve ser carregada por POST.";
}
?>
