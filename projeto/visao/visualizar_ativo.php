<?php
require_once "conexao.php";
include_once("senac.html");

include('navbar.php');
$idAtivo = $_GET['id'] ?? '';

if (!$idAtivo) {
    echo "Ativo não encontrado.";
    exit;
}

// Busca os dados do ativo
$query = "SELECT * FROM ativos WHERE idAtivo = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$idAtivo]);
$ativo = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$ativo) {
    echo "Ativo não encontrado.";
    exit;
}

// Busca a movimentação do ativo
$queryMov = "SELECT * FROM movimentacoes WHERE idAtivo = ? ORDER BY dataMov DESC";
$stmtMov = $pdo->prepare($queryMov);
$stmtMov->execute([$idAtivo]);
$movimentacoes = $stmtMov->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Detalhes do Ativo</h1>
<p><strong>Descrição:</strong> <?= $ativo['descricaoAtivo'] ?></p>
<p><strong>Marca:</strong> <?= $ativo['idMarca'] ?></p>
<p><strong>Quantidade:</strong> <?= $ativo['quantidadeAtivo'] ?></p>

<h2>Movimentação</h2>
<ul>
    <?php foreach ($movimentacoes as $mov) : ?>
        <li><?= $mov['dataMov'] ?> - <?= $mov['descricaoMov'] ?></li>
    <?php endforeach; ?>
</ul>
