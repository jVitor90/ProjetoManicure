<?php
require_once('banco_class.php');

class Usuario{
    public $nome;
    public $sobrenome;
    public $email;
    public $telefone;
    public $senha;
    public $id_tipo;
    public $id;

    public function Cadastrar(){
        $sql = "INSERT INTO usuarios (nome, sobrenome, email, telefone, senha)
        VALUES (?, ?, ?, ?, ?, 2)";
        $banco = Banco::conectar();
        $comando = $banco->prepare($sql);
        $comando->execute([
            $this->nome,
            $this->sobrenome,
            $this->email,
            $this->telefone,
            hash('sha256', $this->senha)
        ]);
        Banco::desconectar();
        return $comando->rowCount();
    }

    public function Logar(){
        $sql = "SELECT * FROM usuarios WHERE email = ? AND senha = ?";
        $banco = Banco::conectar();
        $comando = $banco->prepare($sql);
        $comando->execute([
            $this->email,
            hash('sha256', $this->senha)
        ]);
        $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
        Banco::desconectar();
        return $resultado;

    }

    public function TrocarSenha(){
        $sql = "UPDATE usuarios SET senha = ? WHERE id = ?";
        $banco = Banco::conectar();
        $comando = $banco->prepare($sql);
        $comando->execute([
            hash('sha256', $this->senha),
            $this->id
        ]);
        Banco::desconectar();
        return $comando->rowCount();
    }
}
?>