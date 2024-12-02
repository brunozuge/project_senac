<?php

include_once("../modelo/conexao.php");
include_once("controle_session.php");

$ativo = $_POST['ativo'];
$marca = $_POST['marca'];
$tipo = $_POST['tipo'];
$quantidade = $_POST['quantidade'];
$observacao = $_POST['observacao'];
$user = $_SESSION['usuario_logado'];

 $querry = "
            insert into ativo (
                                     descricaoAtivo ,
                                     quantidadeAtivo ,
                                     statusAtivo ,
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
?>