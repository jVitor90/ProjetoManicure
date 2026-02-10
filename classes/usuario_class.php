<?php
require_once('banco_class.php');

class Usuario
{
    public $nome;
    public $sobrenome;
    public $email;
    public $telefone;
    public $senha;
    public $id_tipo;
    public $id;

    public function Cadastrar()
    {
        $sql = "INSERT INTO usuarios (nome, sobrenome, email, telefone, senha, id_tipo)
        VALUES (?, ?, ?, ?, ?, 1)";
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

    public function Logar()
    {
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


    public function EditarUsuario()
    {
        $campos = [];
        $valores = [];

        if (!empty($this->nome)) {
            $campos[] = "nome = ?";
            $valores[] = $this->nome;
        }

        if (!empty($this->email)) {
            $campos[] = "email = ?";
            $valores[] = $this->email;
        }

        if (!empty($this->senha)) {
            $campos[] = "senha = ?";
            $valores[] = hash('sha256', $this->senha);
        }

        if (!empty($this->telefone)) {
            $campos[] = "telefone = ?";
            $valores[] = $this->telefone;
        }

        if (empty($campos)) {
            return 0; // nada para atualizar
        }

        $sql = "UPDATE usuarios SET " . implode(', ', $campos) . " WHERE id = ?";
        $valores[] = $this->id;

        $banco = Banco::conectar();
        $comando = $banco->prepare($sql);
        $comando->execute($valores);

        Banco::desconectar();
        return $comando->rowCount();
    }

    //listar todos os usuarios
    public function ListarTodosUsuarios()
    {
        $sql = "SELECT 
        u.id,
        u.nome,
        u.sobrenome,
        u.email,
        u.telefone,
        u.senha,
        u.id_tipo,
        MAX(c.data) AS data_ultimo_agendamento
        FROM 
        usuarios u
        LEFT JOIN 
        agendamento a ON u.id = a.id_usuario_agenda
        LEFT JOIN 
        calendario c ON a.id_calendario = c.id
        GROUP BY 
        u.id, u.nome, u.sobrenome, u.email, u.telefone, u.senha, u.id_tipo
        ORDER BY 
        u.id;";
        $banco = Banco::conectar();
        $comando = $banco->prepare($sql);
        $comando->execute();
        $usuarios = $comando->fetchAll(PDO::FETCH_ASSOC);
        Banco::desconectar();
        return $usuarios;
    }

    public function ExcluirUsuario($id_usuario)
    {
        $sql = "DELETE FROM usuarios WHERE id = ?";
        $banco = Banco::conectar();
        $comando = $banco->prepare($sql);
        $comando->execute([
            $id_usuario
        ]);
        Banco::desconectar();
        return $comando->rowCount();
    }
}
