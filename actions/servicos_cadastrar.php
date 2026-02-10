<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../classes/servicos_class.php';
    $servico = new Servicos();

    // Pega o ID (se vier, é edição; se não vier ou vazio, é novo)
    $id = !empty($_POST['id']) ? (int)$_POST['id'] : null;

    // Campos comuns
    $servico->nome       = strip_tags($_POST['nomeServico'] ?? '');
    $servico->valor      = str_replace(',', '.', trim($_POST['preco'] ?? '0'));
    $servico->duracao    = (int)($_POST['duracao'] ?? 0);
    $servico->descricao  = strip_tags($_POST['descricao'] ?? '');

     // Garante que tenha no máximo 2 casas decimais
    $servico->valor = number_format((float)$servico->valor, 2, '.', '');


    // Converte duração para minutos
    $unidade = $_POST['unidadeDuracao'] ?? 'minutos';
    if ($unidade === 'horas') {
        $servico->duracao *= 60;
    }

    // Validações
    if (empty($servico->nome)) {
        echo "O nome do serviço não foi informado";
        exit;
    }
    if (empty($servico->valor) || $servico->valor <= 0) {
        echo "O preço deve ser informado e maior que zero";
        exit;
    }
    if ($servico->duracao < 1) {
        echo "A duração deve ser maior que zero";
        exit;
    }

    // Decide: novo ou edição
    if ($id === null || $id <= 0) {
        // Novo serviço
        $resultado = $servico->AdicionarServico();
         if ($resultado == 1) {
            header('Location: ../DashBoard/index.php?success=novo_servico');
            exit;
        } else {
            header('Location: ../DashBoard/index.php?error=falha_cadastro');
            exit;
        }
    } else {
        // Edição
        $servico->id = $id;
        $resultado = $servico->EditarServico();
       if ($resultado == 1) {
            header('Location: ../DashBoard/index.php?success=servico_editado');
            exit;
        } else {
            header('Location: ../DashBoard/index.php?error=falha_edicao');
            exit;
        }
    }
} else {
    echo "Essa página deve ser carregada por POST.";
    exit;
}