<?php
require_once('banco_class.php');

class Servico{
    public $id;
    public $nome;
    public $valor;
    public $duracao;
    public $descricao;

    public function ListarTodos(){
        $sql = "SELECT * FROM servicos ORDER BY nome";
        $banco = Banco::conectar();
        $comando = $banco->prepare($sql);
        $comando->execute();
        $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
        Banco::desconectar();
        return $resultado;
    }

    public function BuscarPorId(){
        $sql = "SELECT * FROM servicos WHERE id = ?";
        $banco = Banco::conectar();
        $comando = $banco->prepare($sql);
        $comando->execute([$this->id]);
        $resultado = $comando->fetch(PDO::FETCH_ASSOC);
        Banco::desconectar();
        return $resultado;
    }
}
?>