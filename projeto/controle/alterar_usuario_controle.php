<?php
include ('../modelo/conexao.php');

if (isset($_POST['id_usuario']) && isset($_POST['nome']) && isset($_POST['turma'])) {
    $id_usuario = $_POST['id_usuario'];
    $nome = $_POST['nome'];
    $turma = $_POST['turma'];

    $query = "UPDATE usuario SET nomeUsuario = ?, turmaUsuario = ? WHERE idUsuario = ?";
    $stmt = $conexao->prepare($query);

    if (!$stmt) {
        die("Erro na preparação da consulta: " . $conexao->error);
    }

    $stmt->bind_param("ssi", $nome, $turma, $id_usuario);

    if ($stmt->execute()) {
        echo "<p>Usuário atualizado com sucesso!</p>";
        header("Location:../visao/listar_usuario.php");
        exit();
    } else {
        echo "<p>Erro ao atualizar o usuário: " . $stmt->error . "</p>";
    }

    $stmt->close();
} else {
    echo "<p>Dados incompletos. Por favor, verifique o formulário.</p>";
}

$conexao->close();
?>