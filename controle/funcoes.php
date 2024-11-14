<?php
function busca_info_bd($conexao,$tabela,$coluna_where= false,$valor_where=false){
    $sql="select * from ".$tabela;
if($coluna_where!=false ){

    $sql .=" where $coluna_where = '".$valor_where."'";
}

$result = mysqli_query($conexao,$sql)or die (false);
$dados =mysqli_fetch_all($result,MYSQLI_ASSOC);
return $dados;

}




?>