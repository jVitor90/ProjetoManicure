<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    http_response_code(401);
    echo json_encode(['erro' => 'Não autorizado']);
    exit();
}

require_once('../classes/relatorios_class.php');
header('Content-Type: application/json');

try {
    $periodo = isset($_GET['periodo']) ? $_GET['periodo'] : 'mes';
    $periodosValidos = ['semana', 'mes', 'trimestre', 'ano'];
    if (!in_array($periodo, $periodosValidos)) {
        $periodo = 'mes';
    }

    $relatorio = new relatorios();

    echo json_encode([
        'dadosPeriodo'      => $relatorio->getDadosPeriodo($periodo),
        'resumoMeses'       => $relatorio->getResumoMeses(),
        'totalHoje'         => $relatorio->TotalHoje(),
        'faturamentoSemanal'=> $relatorio->FaturamentoSemanal(),
        'nomePeriodo'       => $relatorio->getNomePeriodo($periodo),
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['erro' => 'Erro ao buscar dados do relatório']);
}