<?php 

include_once('../modelo/conexao.php');

$ativo = $_POST['ativo'];
$marca = $_POST['marca'];
$tipo = $_POST['tipo'];
$quantidade = $_POST['quantidade'];
$observacao = $_POST['observacao'];

echo $ativo;
echo $marca;
echo $tipo;
echo $quantidade;
echo $observacao;

?>