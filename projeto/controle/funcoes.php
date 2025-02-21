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

 function busca_prod_ml ($pesquisa){
    
        $termo = urlencode($pesquisa);
        $url = "https://api.mercadolibre.com/sites/MLB/search?q=$termo";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $resultados = json_decode($response, true);
        $retorno = "";
        
        if (!empty($resultados['results'])) {
            $retorno .= "<div class='produtos-container'>";
            foreach ($resultados['results'] as $produto) {
                $retorno .= "<div class='produto-card'>";
                $retorno .= "<img src='" . htmlspecialchars($produto['thumbnail']) . "' alt='Imagem do Produto' class='produto-imagem'>";
                $retorno .= "<h3 class='produto-titulo'>" . htmlspecialchars($produto['title']) . "</h3>";
                $retorno .= "<p class='produto-preco'>Preço: R$" . number_format($produto['price'], 2, ',', '.') . "</p>";
                $retorno .= "<a href='" . htmlspecialchars($produto['permalink']) . "' target='_blank' class='produto-link'>Ver no Mercado Livre</a>";
                $retorno .= "</div>";
            }
            $retorno .= "</div>";
        } else {
            $retorno .= "<p class='mensagem-vazio'>Nenhum produto encontrado.</p>";
        }
        return $retorno;
    }
 


?>