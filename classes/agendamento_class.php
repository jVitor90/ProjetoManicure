<?php

use function PHPSTORM_META\sql_injection_subst;

require_once('banco_class.php');

class Agendamento
{
    public $id_calendario;
    public $id_usuario_agenda;
    public $id_servico;
    public $status;
    public $id;

    public function Agendar()
    {
        $sql = "INSERT INTO agendamento (id_calendario, id_usuario_agenda, id_servico)
        VALUES (?, ?, ?)";
        $banco = Banco::conectar();
        $comando = $banco->prepare($sql);
        $comando->execute([
            $this->id_calendario,
            $this->id_usuario_agenda,
            $this->id_servico,
        ]);
        Banco::desconectar();
        return $comando->rowCount();
    }

    //editar agendamento
    public function Editar($id_agendamento)
    {
        $sql = "UPDATE agendamento SET id_calendario = ?, id_usuario_agenda = ?, id_servico = ?, status = ? WHERE id = ?";
        $banco = Banco::conectar();
        $comando = $banco->prepare($sql);
        $comando->execute([
            $this->id_calendario,
            $this->id_usuario_agenda,
            $this->id_servico,
            $this->status,
            $id_agendamento
        ]);
        Banco::desconectar();
        return $comando->rowCount();
    }

    public function Excluir($id_agendamento)
    {
        $sql = "DELETE FROM agendamento WHERE id = ?";
        $banco = Banco::conectar();
        $comando = $banco->prepare($sql);
        $comando->execute([
            $id_agendamento
        ]);
        Banco::desconectar();
        return $comando->rowCount();
    }

    // Listar agendamentos por data
    public function ListarPorData($data)
    {
        $sql = "SELECT a.*, 
                       c.data, c.horario,
                       s.nome as servico_nome, s.valor, s.duracao,
                       u.nome as usuario_nome, u.sobrenome as usuario_sobrenome
                FROM agendamento a
                INNER JOIN calendario c ON a.id_calendario = c.id
                INNER JOIN servicos s ON a.id_servico = s.id
                INNER JOIN usuarios u ON a.id_usuario_agenda = u.id
                WHERE c.data = ? AND a.status = 1
                ORDER BY c.horario ASC";

        $banco = Banco::conectar();
        $comando = $banco->prepare($sql);
        $comando->execute([$data]);
        $agendamentos = $comando->fetchAll(PDO::FETCH_ASSOC);
        Banco::desconectar();

        return $agendamentos;
    }
    public function AtualizarAgendamento($id_agendamento){
        $sql = "UPDATE agendamento SET status = 0 WHERE id = ?";
        $banco = Banco::conectar();
        $comando = $banco->prepare($sql);
        $comando->execute([
            $id_agendamento
        ]);
        Banco::desconectar();
        return $comando->rowCount();
    }
    public function TotalAgendamentos()
    {
        $sql = "SELECT COUNT(*) as total FROM agendamento a
                INNER JOIN calendario c ON a.id_calendario = c.id
                WHERE a.status = 1 and DATE(c.data) = CURDATE() ";
 
        $banco = Banco::conectar();
        $comando = $banco->prepare($sql);
        $comando->execute();
        $total = $comando->fetch(PDO::FETCH_ASSOC)['total'];
        Banco::desconectar();
 
        return $total;
    }

}
