<?php
require_once '../modelo/conexao.php'; // Garante que o arquivo conexao.php será incluído

session_start(); // Inicia a sessão


    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];
    $senhaC = base64_encode($senha);


    // Verifica se a conexão está ativa
    

    // Prepara e executa a consulta
    $query =  "SELECT count(*) as quantidade  FROM usuario WHERE usuario = '$usuario' and senhaUsuario='$senhaC'";
    if (!$query) {
        die("Erro na preparação da consulta: " . $conexao->error);
    }

    $result = mysqli_query($conexao,$query)or die(false);
    $dados =$result->fetch_assoc();
   

    // Verifica se o usuário foi encontrado
    if ($dados['quantidade'] > 0) {
       

        // Valida a senha
       
            $_SESSION['usuario_logado'] = $usuario;
            header("Location: ../visao/listar_usuario.php");
            exit();
        } else {
            header("Location: ../visao/login.php?erro=Senha ou Usuario incorreta!");
            exit();
        }
  

?>