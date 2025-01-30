<?php
include_once("../modelo/conexao.php");

$id = $_GET['id'];
$query = "SELECT * FROM ativo WHERE idAtivo = $id";
$result = mysqli_query($conexao, $query);

if ($result) {
    echo json_encode(mysqli_fetch_assoc($result));
} else {
    echo json_encode(["error" => "Erro ao buscar ativo."]);
}
?>
