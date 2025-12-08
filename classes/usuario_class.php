<?php
require_once('banco_class.php');

class Usuario{
    public $nome;
    public $email;
    public $senha;
    public $id_tipo;
    public $id;

    public function Cadastrar(){
        $sql = "INSERT INTO usuarios (nome, email, senha,)
        VALUES (?, ?, ?, ?)";
        $banco = Banco::conectar();
        $comando = $banco->prepare($sql);
        $comando->execite([
            $this->nome,
            $this->email,
            hash('sha256', $this->senha),
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
        $resultado = $comando->fetch(PDO::FETCH_ASSOC);
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