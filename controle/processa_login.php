<?php
session_start();
include('../modelo/conexao.php'); // Verifique se o caminho está correto para o arquivo de conexão
include('../controle/funcoes.php'); // Verifique se o caminho está correto para as funções

// Verifica se os dados foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebe os dados do formulário e faz a sanitização
    $usuario = trim($_POST['usuario']);
    $senha = trim($_POST['senha']);

    // Verifica se os campos não estão vazios
    if (empty($usuario) || empty($senha)) {
        echo "<script>alert('Por favor, preencha todos os campos.'); window.location.href='../visao/login.php';</script>";
        exit();
    }

    // Consulta o banco de dados para verificar o usuário
    $query = "SELECT * FROM usuario WHERE usuario = ?";  // Corrigido: estamos buscando pelo usuário, não pela senha
    $stmt = $conexao->prepare($query);

    // Verifica se a consulta foi preparada com sucesso
    if ($stmt === false) {
        die('Erro na preparação da consulta.');
    }

    $stmt->bind_param("s", $usuario);  // Apenas o nome de usuário é necessário aqui
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se o usuário existe
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Decodifica a senha armazenada em Base64
        $senhaCodificada = base64_decode($user['senhaUsuario']);
        
        // Compara a senha fornecida com a senha decodificada
        if ($senha === $senhaCodificada) {
            // Login bem-sucedido: armazena o usuário na sessão
            $_SESSION['usuario'] = $usuario;
            
            // Exibe o alert de login bem-sucedido antes de redirecionar
            echo "<script>alert('Login bem-sucedido!'); window.location.href='../visao/listar_usuario.php';</script>";
            exit();
        } else {
            // Senha incorreta
            echo "<script>alert('Usuário ou senha inválidos.'); window.location.href='../visao/login.php';</script>";
        }
    } else {
        // Usuário não encontrado
        echo "<script>alert('Usuário ou senha inválidos.'); window.location.href='../visao/login.php';</script>";
    }

    $stmt->close();
} else {
    // Se não for um POST, redireciona para a página de login
    header("Location: ../visao/login.php");
    exit();
}

$conexao->close();
?>
