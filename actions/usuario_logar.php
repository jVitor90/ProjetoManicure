<?php
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    require_once('../classes/usuario_class.php');
    $usuario = new Usuario();
    $usuario->email = strip_tags($_POST['email']);
    $usuario->senha = strip_tags($_POST['senha']);


    if(empty($usuario->email)){
        echo "O Usuario/Email não foi informado";
    }
    else if(empty($usuario->senha)){
        echo "A senha não foi informada";
    }
    else{
        $resultado = $usuario->Logar();
        if(sizeof($resultado) != 1){
            header('Location: ../html/index.html');
            exit();
            
        }
        else{
            //Iniciar sessão de 
            session_start();
            //criar sessão com os dados vindo do banco de dados
            $_SESSION['usuario'] = $resultado[0];
            //redirecionar para a área padina inicial
            header('Location: ../html/login.html');
            exit();
        }
    }
}
else{
    echo "Essa página deve ser carregada por POST.";
}
?>