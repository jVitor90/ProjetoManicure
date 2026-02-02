<?php
require_once('../classes/calendario_class.php');
header('Content-Type: application/json');
// obter a data por get
$data = isset($_GET['data']) ? $_GET['data'] : '';
$calendario = new Calendario();
$resultado = $calendario->ListarHorariosPorData($data);
// retornar o resultado em formato JSON
echo json_encode($resultado);

?>