<?php
session_start(); // Inicia a sessão

// Verifica se o usuário está autenticado
if (!isset($_SESSION['usuario']) || !isset($_SESSION['senha'])) {
    header("Location: ../login.php"); // Redireciona para a página de login
    exit;
}

// Verifica se as credenciais estão corretas
$usuario_autorizado = "bz";
$senha_autorizada = "123";

if ($_SESSION['usuario'] !== $usuario_autorizado || $_SESSION['senha'] !== $senha_autorizada) {
    echo "<p>Acesso negado. Apenas usuários autorizados podem alterar informações.</p>";
    exit;
}

// Aqui entra o restante do código para processar a alteração do usuário
include('../modelo/conexao.php');
include('../controle/funcoes.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_POST['id_usuario'];
    $nome = $_POST['nome'];
    $turma = $_POST['turma'];

    // Atualizar o banco de dados
    $query = "UPDATE usuario SET nomeUsuario = ?, turmaUsuario = ? WHERE idUsuario = ?";
    $stmt = $conexao->prepare($query);
    $stmt->bind_param("ssi", $nome, $turma, $id_usuario);

    if ($stmt->execute()) {
        header("Location: ../listar_usuario.php?msg=alteracao_sucesso"); // Redireciona após sucesso
    } else {
        echo "<p>Erro ao atualizar o usuário.</p>";
    }

    $stmt->close();
    $conexao->close();
    exit;
}
?>
