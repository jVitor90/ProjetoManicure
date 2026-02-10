<?php
require_once('banco_class.php');
 
class Servicos {
    public $nome;
    public $categoria;
    public $valor;
    public $duracao;
    public $descricao;
    public $id;
 
    // Adicionar serviço
    public function AdicionarServico() {
        $sql = "INSERT INTO servicos (nome, valor, duracao, descricao)
        VALUES (?, ?, ?, ?)";
        $banco = Banco::conectar();
        $comando = $banco->prepare($sql);
        $comando->execute([
            $this->nome,
         
            $this->valor,
            $this->duracao,
            $this->descricao
        ]);
        Banco::desconectar();
        return $comando->rowCount();
    }
   
    // Listar serviços
    public function ListarServicos() {
        $sql = "SELECT * FROM servicos ORDER BY nome ASC";
        $banco = Banco::conectar();
        $comando = $banco->prepare($sql);
        $comando->execute();
        $result = $comando->fetchAll(PDO::FETCH_ASSOC);
        Banco::desconectar();
        return $result;
    }
   
    // Remover serviço
    public function RemoverServico() {
        $sql = "DELETE FROM servicos WHERE id = ?";
        $banco = Banco::conectar();
        $comando = $banco->prepare($sql);
        $comando->execute([$this->id]);
        Banco::desconectar();
        return $comando->rowCount();
    }
   
    // Editar serviço
    public function EditarServico() {
        $sql = "UPDATE servicos SET nome = ?, valor = ?, duracao = ?, descricao = ? WHERE id = ?";
        $banco = Banco::conectar();
        $comando = $banco->prepare($sql);
        $comando->execute([
            $this->nome,
 
            $this->valor,
            $this->duracao,
            $this->descricao,
            $this->id
        ]);
        Banco::desconectar();
        return $comando->rowCount();
    }
   
    // Buscar serviço por ID (útil para o modal de edição)
    public function BuscarServicoPorId() {
        $sql = "SELECT * FROM servicos WHERE id = ?";
        $banco = Banco::conectar();
        $comando = $banco->prepare($sql);
        $comando->execute([$this->id]);
        $result = $comando->fetch(PDO::FETCH_ASSOC);
        Banco::desconectar();
        return $result;
    }
}