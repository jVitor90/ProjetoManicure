<?php
require_once('banco_class.php');

class Calendario
{
    public $id;
    public $data;
    public $horario;

    function ListarHorariosPorData($data)
    {
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
    // Inserir horário
    function InserirHorario($data, $horario)
    {
        $sql = "INSERT IGNORE INTO calendario (data, horario) VALUES (?, ?)";
        $banco = Banco::conectar();
        $comando = $banco->prepare($sql);
        $comando->execute([$data, $horario]);
        Banco::desconectar();
        return $comando->rowCount();
    }

    // Remover todos os horários de uma data
    function RemoverPorData($data)
    {
        $sql = "DELETE FROM calendario WHERE data = ?";
        $banco = Banco::conectar();
        $comando = $banco->prepare($sql);
        $comando->execute([$data]);
        Banco::desconectar();
    }

    // Listar todos os dias que têm horários cadastrados
    function ListarDiasComHorarios()
    {
        $sql = "SELECT DISTINCT data FROM calendario WHERE data >= CURDATE() ORDER BY data ASC";
        $banco = Banco::conectar();
        $comando = $banco->prepare($sql);
        $comando->execute();
        $resultado = $comando->fetchAll(PDO::FETCH_COLUMN);
        Banco::desconectar();
        return $resultado;
    }
}
