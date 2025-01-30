<?php
include ('../modelo/conexao.php');

// Verifica se a variável de ID foi passada
if (isset($_GET['id_usuario'])) {
    $id_usuario = $_GET['id_usuario'];

    // Consulta SQL para excluir o usuário
    $query = "DELETE FROM usuario WHERE idUsuario = ?";
    $stmt = $conexao->prepare($query);

    if (!$stmt) {
        die("Erro na preparação da consulta: " . $conexao->error);
    }

    $stmt->bind_param("i", $id_usuario);

    if ($stmt->execute()) {
        echo "<p>Usuário excluído com sucesso!</p>";
        header("Location:../visao/listar_usuario.php");
        exit();
    } else {
        echo "<p>Erro ao excluir o usuário: " . $stmt->error . "</p>";
    }

    $stmt->close();
} else {
    echo "<p>ID do usuário não informado.</p>";
}

$conexao->close();
?>