<?php
ini_set('display_errors', 1);
error_reporting(E_ERROR);
include_once("../modelo/conexao.php");
include_once("controle_session.php");


$marca = $_POST['marca'];
$idMarca = $_POST['idMarca'];

$statusMarca = $_POST['status'];
$acao = $_POST['acao'];



$user = $_SESSION['usuario_logado'];
if ($acao == 'inserir') {
  $querry = "
  insert into marca (
                           descricaoMarca ,
                         statusMarca,
                          
                          
                           dataCadastro,
                          usuarioCadastro
                          )values(
                            '" . $marca . "',
                           
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
  $sql = "Update marca set statusMarca = '$statusMarca' where idMarca = $idMarca";
  
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
      idMarca,     
      descricaoMarca
    from
        marca
    where
        idMarca= $idMarca  
";

  $result = mysqli_query($conexao, $sql) or die(false);
  $marca = mysqli_fetch_all($result, MYSQLI_ASSOC);

  echo json_encode($marca);

  exit();
}

if ($acao == 'update') {
  $sql = "Update marca set
    descricaoMarca = '$marca'

    where 
    
    idMarca = $idMarca
    ";

  $result = mysqli_query($conexao, $sql) or die(false);

  if ($result) {
    echo "Informações alteradas";
  } else {
    echo "Informações não alteradas";
  }
}
