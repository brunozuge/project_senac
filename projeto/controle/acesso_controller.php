<?php

include_once('../controle/controle_session.php');
include_once('../modelo/conexao.php');

$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

$cargo = $data['cargo'];

$sql = "SELECT 
            idCargo,
            idOpcao,
            idAcesso,
            statusAcesso
        FROM 
            acesso
        WHERE 
            idCargo = '$cargo' ";

echo $sql;

$result = mysqli_query($conexao, $sql) or die(false);
$acessos = $result->fetch_all(MYSQLI_ASSOC);

var_dump($data['acessos']);

foreach($data['acessos'] as $infoAcesso) {
    $array_acessos_selecionados[$infoAcesso['idOpcao']] = $infoAcesso['acesso'];
}



$sql="";
if(!empty($acessos)){
    foreach($acessos as $acesso_bd){

    }if(array_key_exists($acesso_bd['idOpcao'],$array_acessos_selecionados)){
        $sql.= "update acesso set statusAcesso='".$array_acessos_selecionados[$acesso_bd['idOpcao']]."';";
    }
}else{
 $sql .="update acesso se statusAcesso='N' where idAcesso ='".$acesso_bd['idAcesso']."';";

}
unset ($array_acessos_selecionados)

foreach ($array_acessos_selecionados as $sidOpcao => $sacesso_new) {
    $sql .= "INSERT INTO acesso (
        idCargo,
        idOpcao,
        statusAcesso,
        IdUsuario,
        dataCadastro
    ) VALUES (
        '$sidOpcao',
        '$scargo',
        '1',
        '$IdUsuario',
        NOW()
    ),";
}

// Remover a última vírgula
$sql = substr($sql, 0, -1);

// Executar a query
$result = mysqli_multi_query($conexao, $sql) or die(json_encode(false));

if ($result) {
    echo json_encode("Cadastro realizado");
    exit;
}

if ($sacao == "busca_acesso") {
    $sql = "SELECT idCargo, idOpcao, idAcesso, statusAcesso FROM acesso WHERE idCargo = '$scargo'";
    echo $sql;
}
 

?>