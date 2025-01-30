<?php
require_once '../modelo/conexao.php'; // Garante que o arquivo conexao.php será incluído

session_start(); // Inicia a sessão

$usuario = $_POST['usuario'];
$senha = $_POST['senha'];
$senhaC = base64_encode($senha);

// Corrige a consulta SQL
$query = "Select idUsuario, admin FROM usuario WHERE usuario = '$usuario' AND senhaUsuario = '$senhaC'";
$result = mysqli_query($conexao, $query);

if (!$result) {
    die("Erro na execução da consulta: " . mysqli_error($conexao));
}

// Verifica se o usuário foi encontrado
if (mysqli_num_rows($result) > 0) {
    $dados = mysqli_fetch_assoc($result);

    // Define as variáveis de sessão
    $_SESSION['login_ok'] = true;
    $_SESSION['controle_login'] = true;
    $_SESSION['usuario_logado'] = $dados['idUsuario'];
    if ($dados['admin'] == 'S') {
        $_SESSION['admin']="S";
    }
    else {
        $_SESSION['admin']="N";
    }
    

    header("Location: ../visao/inicio.php");
    exit();
} else {
    $_SESSION['login_ok'] = false;
    unset($_SESSION['controle_login']);
    header("Location: ../visao/login.php?erro=Senha ou Usuario incorretos!");
    exit();
}
?>
