<?php

// Mensagem de sucesso
$msg = [
    "usuario_cadastrado" => "Usuário cadastrado com sucesso!",

];

// Mensagem de erro
$err = [
    "erro_cadastro" => "Erro ao cadastrar usuário. Tente novamente.",
    "usuario_cadastro_falha" => "Erro ao cadastrar usuário. Tente novamente.",
    'usuario_sessao_invaliada' => 'Sessão inválida. Por favor, faça login novamente.',
    "usuario_login_falha" => "E-mail e/ou senha inválidos. Verifique suas credenciais.",  
    "email_vazio" => "O e-mail não foi informado.",
    "senha_vazia" => "A senha não foi informada."
];
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    //Exibição de mensagem de alerta do SweetAlert2:
    <?php
    // Verificar se existe uma mensagem de sucesso na URL:
        if(isset($_GET['msg']) && array_key_exists($_GET['msg'],$msg)){
            $mensagem = $msg[$_GET['msg']];
            echo "Swal.fire({
                icon: 'success',
                title: 'Sucesso',
                text: '$mensagem',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });";
        }
    ?>
    <?php
    // Verifica se existe uma mensagem de erro na URL:
        if(isset($_GET['err']) && array_key_exists($_GET['err'], $err)){
            $mensagem = $err[$_GET['err']];
            echo "Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: '$mensagem',
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK'
            });";
        }
        // Remover a mensagem da URL para evitar reaparecimento:
     echo "if (history.replaceState) {
        const url = new URL(window.location);
        url.searchParams.delete('err');
        window.history.replaceState({}, document.title, url.toString());
    }";
    ?>
</script>