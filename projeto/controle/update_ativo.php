<?php
include_once("../modelo/conexao.php");

$id = $_POST['idAtivo'];
$descricao = $_POST['descricaoAtivo'];
$idMarca = $_POST['idMarca'];
$idTipo = $_POST['idTipo'];
$quantidade = $_POST['quantidadeAtivo'];
$observacao = $_POST['observacaoAtivo'];

$query = "
    UPDATE ativo 
    SET 
        descricaoAtivo = '$descricao',
        idMarca = $idMarca,
        idTipo = $idTipo,
        quantidadeAtivo = $quantidade,
        observacaoAtivo = '$observacao'
    WHERE idAtivo = $id";

if (mysqli_query($conexao, $query)) {
    echo "Ativo atualizado com sucesso.";
} else {
    echo "Erro ao atualizar ativo: " . mysqli_error($conexao);
}
?>
