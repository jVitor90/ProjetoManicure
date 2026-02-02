<?php
require_once('banco_class.php');

class Calendario{
    public $id;
    public $data;
    public $horario;

    function ListarHorariosPorData($data){
        $sql = "SELECT c.* 
        FROM calendario c
        LEFT JOIN agendamento a ON c.id = a.id_calendario 
        WHERE c.data = ? AND a.id IS NULL
        ORDER BY c.horario ASC";
        $banco = Banco::conectar();
        $comando = $banco->prepare($sql);
        $comando->execute([
            $data
        ]);
        $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
        Banco::desconectar();
        return $resultado;
    }

    


}

?>