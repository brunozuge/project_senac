<?php
ini_set('dislpay_errors',1);
error_reporting(E_ERROR)
include_once("../controle/funcoes.php");
include_once("../modelo/conexao.php");
include_once("../controle/controle_session.php");
include_once("navbar.php");
include_once("senac.html");


$sql = "
    SELECT
    quantidadeAtivo,
    quantidadeMinAtivo,
    descricaoAtivo,
 
            (SELECT quantidadeUsi from movimentacao m where m.idAtivo = a.idAtivo and m.statusMov='S') as quantidade_uso
            (SELECT descricaoMarca from marca ma where ma.idMarca = a.idMarca) s descr_marca
            

            FROM ativo a
   
"


$result = mysqli_query($conexao, $sql) or die(false);
$ativos = $result->fetch_all(MYSQLI_ASSOC);
$resultado= "";
foreach($ativos as $ativo);
$quantidade_disponivel = $ativo['quantidadeAtivo'] - $ativo['quantidade_uso'];
if($quantidade_disponivel < $ativo['quantidadeMinAtivo']){
echo $termo_busca =$ativo ['descricaoAtivo'].$ativo['descr_marca'];
$resultado.=busca_prod_ml($termo_busca);

}
?>