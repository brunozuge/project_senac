<?php
ini_set('display_errors', 0);
error_reporting(E_ERROR);
include_once("../modelo/conexao.php");
include_once("controle_session.php");

$ativo = $_POST['ativo'];
$marca = $_POST['marca'];
$tipo = $_POST['tipo'];
$quantidade = $_POST['quantidade'];
$observacao = $_POST['observacao'];

$acao = $_POST['acao'];
$idAtivo= $_POST['idAtivo'];
$statusAtivo= $_POST['status'];

$user = $_SESSION['usuario_logado'];
if ($acao== 'inserir') {
  $querry = "
  insert into ativo (
                           descricaoAtivo ,
                           quantidadeAtivo ,
                           
                           observacaoAtivo,
                           idMarca,
                           idTipo  ,
                           dataCadastro,
                          idUsuario 
                          )values(
                            '" . $ativo . "',
                            '" . $quantidade . "',
                            'S',
                            '" . $observacao . "',
                            
                            '" . $marca . "',
                            '" . $tipo . "',
                            NOW(),
                            '" . $user . "'
                          )
                            ";
                            //echo $querry; exit;

$result = mysqli_query($conexao, $querry) or die(false);

if ($result) {
echo "Cadastro realizado";
} else {
echo "Cadastro não realizado";
}
}


 


if ($acao == 'alterar_status'){
  $sql = "
      Update ativo set statusAtivo ='$statusAtivo' where idAtivo=$idAtivo
  ";

$result = mysqli_query($conexao,$sql)or die(false);

if ($result) {
  echo 'Status Alterado!';

} else {
  echo 'Status Não Alterado!';
}
}

?>