<?php
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        require_once('../classes/usuario_class.php');
        $usuario = new Usuario();

        $usuario->nome = strip_tags($_POST['nome']);
        $usuario->email = strip_tags($_POST['email']);
        $usuario->senha = strip_tags($_POST['senha']);

        if(empty($usuario->nome)){
            echo "O nome não foi informado";
        }
        else if(empty($usuario->email)){
            echo "O Email não foi informado";
        }
        else if(empty($usuario->senha)){
            echo "A senha não foi informado";
        }
        else{
            if($usuario->Cadastrar() == 1){
                header('Location: ../login.php?msg=usuario_cadastrado');
                // print_r('Cadastro realizado com sucesso!');
            }
            else{
                // print_r('Erro ao cadastrar usuário.');
                header('Location: ./login.php?err=usuario_cadastro_falha');
            }
        }
    }
    else{  
        echo "Essa página deve ser carregada por POST.";
        
    }

?>