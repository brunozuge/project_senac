<?php
//valor para salários 
$valor_compra = 4000.90;

if ($valor_compra <= 1412) {
    $percentual_desconto = 7.5;
} elseif ($valor_compra >= 1412.01 && $valor_compra<=2666.68) {
    $percentual_desconto = 9;
} elseif ($valor_compra >=2666.69 && $valor_compra<=4000.03){
    $percentual_desconto = 12;
}
elseif ($valor_compra>=4000.04 && $valor_compra<=7786.02){
    $percentual_desconto = 14;
}

$valor_desconto = ($valor_compra * $percentual_desconto) / 100;
$preco_final = $valor_compra - $valor_desconto;

echo "Valor do salário: R$ " . number_format($valor_compra, 2, ',', '.') . "<br>";
echo "Percentual de desconto: $percentual_desconto% <br>";
echo "Valor do desconto: R$ " . number_format($valor_desconto, 2, ',', '.') . "<br>";
echo "Valor final do salário: R$ " . number_format($preco_final, 2, ',', '.') . "<br>";
//Valor para compras
$valor_compra = 250.99;

switch (true) {
    case ($valor_compra <= 100):
        $percentual_desconto = 5;
        break;
    case ($valor_compra <= 200):
        $percentual_desconto = 10;
        break;
    default:
        $percentual_desconto = 15;
        break;
}

$valor_desconto = ($valor_compra * $percentual_desconto) / 100;
$preco_final = $valor_compra - $valor_desconto;

echo "<br>Valor do produto: R$ " . number_format($valor_compra, 2, ',', '.') . "<br>";
echo "Percentual de desconto: $percentual_desconto% <br>";
echo "Valor do desconto: R$ " . number_format($valor_desconto, 2, ',', '.') . "<br>";
echo "Preço final do produto: R$ " . number_format($preco_final, 2, ',', '.') . "<br>";
?>
