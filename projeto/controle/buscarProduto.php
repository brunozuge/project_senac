<?php
// Inclui o arquivo senac.html
include_once("../visao/senac.html");
if (isset($_GET['busca'])) {
    $termo = urlencode($_GET['busca']);
    $url = "https://api.mercadolibre.com/sites/MLB/search?q=$termo";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    $resultados = json_decode($response, true);

    if (!empty($resultados['results'])) {
        echo "<div class='produtos-container'>";
        foreach ($resultados['results'] as $produto) {
            echo "<div class='produto-card'>";
            echo "<img src='" . htmlspecialchars($produto['thumbnail']) . "' alt='Imagem do Produto' class='produto-imagem'>";
            echo "<h3 class='produto-titulo'>" . htmlspecialchars($produto['title']) . "</h3>";
            echo "<p class='produto-preco'>Preço: R$" . number_format($produto['price'], 2, ',', '.') . "</p>";
            echo "<a href='" . htmlspecialchars($produto['permalink']) . "' target='_blank' class='produto-link'>Ver no Mercado Livre</a>";
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "<p class='mensagem-vazio'>Nenhum produto encontrado.</p>";
    }
}
?>