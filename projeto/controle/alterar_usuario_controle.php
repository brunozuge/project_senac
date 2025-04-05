<?php
session_start(); // Inicia a sessão

// Verifica se o usuário está autenticado
if (!isset($_SESSION['login_ok']) || !isset($_SESSION['controle_login'])) {
    header("Location: ../visao/login.php"); // Redireciona para a página de login
    exit;
}

// Verifica se as credenciais estão corretas
$usuario_autorizado = "bz";
$senha_autorizada = "123";


// Aqui entra o restante do código para processar a alteração do usuário
include('../modelo/conexao.php');
include('../controle/funcoes.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_POST['id_usuario'];
    $nome = $_POST['nome'];
    $turma = $_POST['turma'];
    $id = $_POST['id'];
    $cargo = $_POST['cargo'];

    // Atualizar o banco de dados
    $query = "UPDATE usuario SET nomeUsuario = ?,idCargo = ?, turmaUsuario = ? WHERE idUsuario = ?";
    $stmt = $conexao->prepare($query);
    $stmt->bind_param("sssi", $nome,$cargo, $turma, $id_usuario);

    if ($stmt->execute()) {
        header("Location: ../visao/listar_usuario.php?msg=alteracao_sucesso"); // Redireciona após sucesso
    } else {
        echo "<p>Erro ao atualizar o usuário.</p>";
    }

    $stmt->close();
    $conexao->close();
    exit;
}
?>
