<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../classes/servicos_class.php';
    $servico = new Servicos();

    // Pega o ID do serviço a ser excluído
    $id = !empty($_POST['id']) ? (int)$_POST['id'] : null;

    if ($id === null || $id <= 0) {
        header('Location: ../DashBoard/index.php?error=id_invalido');
        exit;
    }

    $servico->id = $id;
    $resultado = $servico->RemoverServico();
    if ($resultado == 1) {
        header('Location: ../DashBoard/index.php?success=servico_excluido');
        exit;
    } else {
        header('Location: ../DashBoard/index.php?error=servico_exclusao_falha');
        exit;
    }
} else {
    echo "Essa página deve ser carregada por POST.";
    exit;
}