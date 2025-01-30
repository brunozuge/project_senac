<?php
ini_set('display_errors', 1);
error_reporting(E_ERROR);
include_once("../modelo/conexao.php");
include_once("controle_session.php");


$tipo = $_POST['tipo'];
$idTipo = $_POST['idTipo'];

$statusTipo= $_POST['status'];
$acao = $_POST['acao'];



$user = $_SESSION['usuario_logado'];
if ($acao == 'inserir') {
  $querry = "
  insert into tipo (
                           descricaoTipo ,
                         statusTipo,
                          
                          
                           dataCadastro,
                          usuarioCadastro
                          )values(
                            '" . $tipo . "',
                           
                            'S',
                           
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

if ($acao == 'alterar_status') {
  $sql = "Update tipo set statusTipo = '$statusTipo' where idTipo = $idTipo";
  
  $result = mysqli_query($conexao, $sql) or die(false);

  if ($result) {
    echo "Status alterado";
  } else {
    echo "Status não alterardo";
  }
}



if ($acao == 'salvar') {
  $sql = "
    Select     
      idTipo,     
      descricaoTipo
    from
        tipo
    where
        idTipo= $idTipo  
";

  $result = mysqli_query($conexao, $sql) or die(false);
  $tipo = mysqli_fetch_all($result, MYSQLI_ASSOC);

  echo json_encode($tipo);

  exit();
}

if ($acao == 'update') {
  $sql = "Update tipo set
    descricaoTipo = '$tipo'

    where 
    
    idTipo = $idTipo
    ";

  $result = mysqli_query($conexao, $sql) or die(false);

  if ($result) {
    echo "Informações alteradas";
  } else {
    echo "Informações não alteradas";
  }
}
