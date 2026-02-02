<?php
//faça o adicionar serviço
require_once('banco_class.php');

class Servicos{
    public $nome;
    public $valor;
    public $duracao;
    public $descricao;
    public $id;
 
    //adicionar serviço
    public function AdicionarServico(){
        $sql = "INSERT INTO servicos (nome, preco, duracao, descricao)
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
    //listar serviços
    public function ListarServicos(){
        $sql = "SELECT * FROM servicos";
        $banco = Banco::conectar();
        $comando = $banco->prepare($sql);
        $comando->execute();
        $result = $comando->fetchAll(PDO::FETCH_ASSOC);
        Banco::desconectar();
        return $result;
    }
    //remover serviço
    public function RemoverServico(){
        $sql = "DELETE FROM servicos WHERE id = ?";
        $banco = Banco::conectar();
        $comando = $banco->prepare($sql);
        $comando->execute([$this->id]);
        Banco::desconectar();
        return $comando->rowCount();
    }
    //editar serviço
    public function EditarServico(){
        $sql = "UPDATE servicos SET nome = ?, preco = ?, duracao = ?, descricao = ? WHERE id = ?";
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
 
}