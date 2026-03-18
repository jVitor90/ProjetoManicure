<?php
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

    public function AtualizarAgendamento($id_agendamento)
    {
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
                WHERE DATE(c.data) = CURDATE() ";

        $banco = Banco::conectar();
        $comando = $banco->prepare($sql);
        $comando->execute();
        $total = $comando->fetch(PDO::FETCH_ASSOC)['total'];
        Banco::desconectar();

        return $total;
    }

    // Retorna a data do último agendamento de um usuário específico
    public function UltimoAgendamentoPorUsuario($id_usuario)
    {
        $sql = "SELECT MAX(c.data) AS data_ultimo_agendamento
                FROM agendamento a
                INNER JOIN calendario c ON a.id_calendario = c.id
                WHERE a.id_usuario_agenda = ?";

        $banco = Banco::conectar();
        $comando = $banco->prepare($sql);
        $comando->execute([$id_usuario]);
        $resultado = $comando->fetch(PDO::FETCH_ASSOC);
        Banco::desconectar();

        return $resultado['data_ultimo_agendamento'] ?? null;
    }


    public function ListarAgendamentos($status = '', $data = '', $servico = '')
    {
        // Mapeia os nomes legíveis para os valores numéricos do banco
        $mapaStatus = [
            'confirmado' => 0,
            'pendente'   => 1,
        ];

        $sql = "SELECT
                a.id,
                a.data,
                a.horario,
                a.status,
                CONCAT(u.nome, ' ', u.sobrenome) AS usuario_nome,
                u.telefone                        AS usuario_telefone,
                s.nome                            AS servico_nome,
                s.valor,
                s.duracao
            FROM agendamentos a
            INNER JOIN usuarios u ON u.id = a.id_usuario
            INNER JOIN servicos s ON s.id = a.id_servico
            WHERE 1=1";

        $params = [];

        // Filtro: status (somente confirmado=0 ou pendente=1)
        if ($status !== '' && array_key_exists($status, $mapaStatus)) {
            $sql .= " AND a.status = :status";
            $params[':status'] = $mapaStatus[$status];
        }

        // Filtro: data específica
        if ($data !== '') {
            $sql .= " AND a.data = :data";
            $params[':data'] = $data;
        }

        // Filtro: nome do serviço (busca parcial)
        if ($servico !== '') {
            $sql .= " AND s.nome LIKE :servico";
            $params[':servico'] = '%' . $servico . '%';
        }

        $sql .= " ORDER BY a.data ASC, a.horario ASC";

        try {
            $banco   = Banco::conectar();
            $comando = $banco->prepare($sql);

            foreach ($params as $chave => $valor) {
                $comando->bindValue($chave, $valor);
            }

            $comando->execute();
            $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
            Banco::desconectar();

            return $resultado;
        } catch (PDOException $e) {
            return false;
        }
    }
}
