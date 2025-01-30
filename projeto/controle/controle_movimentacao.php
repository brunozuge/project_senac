<?php

session_start();
date_default_timezone_set('America/Sao_Paulo');

include_once('../modelo/conexao.php');

ini_set('display_errors', 0);
error_reporting(E_ERROR);

$ativo = $_POST['idAtivo'];
$tipoMovimentacao = $_POST['tipoMovimentacao'];
$quantidadeMov = $_POST['quantidadeMov'];
$localOrigem = $_POST['localOrigem'];
$localDestino = $_POST['localDestino'];
$descricaoMovimentacao = $_POST['descricaoMovimentacao'];

$user = $_SESSION['idUsuario'];

// Corrigindo o nome da variável usada na query
$sqlTotal = "
    SELECT 
        quantidadeAtivo
    FROM 
        ativo 
    WHERE 
        idAtivo = $ativo
";

$result = mysqli_query($conexao, $sqlTotal) or die("Erro na consulta do ativo: " . mysqli_error($conexao));
$ativosTotal = $result->fetch_assoc();

$quantidadeTotal = $ativosTotal['quantidadeAtivo'];

$sqlUso = "
    SELECT 
      COALESCE(SUM(quantidadeUso), 0) as quantidadeUso
    FROM 
      movimentacao
    WHERE 
      idAtivo = $ativo
    AND 
      statusMov = 'S'
";

$resultUso = mysqli_query($conexao, $sqlUso);
if (!$resultUso) {
  die("Erro na consulta de ativos em uso: " . mysqli_error($conexao));
}

$ativosUso = mysqli_fetch_assoc($resultUso);
$quantidadeUso = $ativosUso['quantidadeUso'];

if ($tipoMovimentacao == 'Adicionar') {
  $total = $quantidadeMov + $quantidadeUso;
  if ($quantidadeTotal < $total) {
    echo "Não é permitido realizar a movimentação. Quantidade de ativos em uso mais a quantidade selecionada ultrapassa o total de ativos cadastrados.";
    exit();
  }
} else if ($tipoMovimentacao == 'Remover') {
  if ($quantidadeUso - $quantidadeMov < 0) {
    echo "Não é permitido realizar a movimentação. Quantidade de ativos a ser removida é maior que a quantidade em uso.";
    exit();
  }
  $total = $quantidadeUso - $quantidadeMov;
} else { // Para realocação
  if ($quantidadeUso - $quantidadeMov < 0) {
    echo "Não é permitido realizar a movimentação. Quantidade de ativos a ser realocada é maior que a quantidade em uso.";
    exit();
  }
  $total = $quantidadeUso;
}

// Removendo a aspas extra no início da query
$queryUpdate = "
    UPDATE
      movimentacao
    SET 
      statusMov = 'N'
    WHERE 
      idAtivo = $ativo
    AND 
      statusMov = 'S'
";

$resultUpdate = mysqli_query($conexao, $queryUpdate);
if (!$resultUpdate) {
  die("Erro ao atualizar movimentação anterior: " . mysqli_error($conexao));
}

// Query de inserção corrigida
$queryInsert = "
    INSERT INTO movimentacao (
        idUsuario,
        idAtivo,
        localOrigem,
        localDestino,
        dataMovimentacao,
        descricaoMovimentacao,
        quantidadeUso,
        quantidadeMov,
        statusMov,
        tipoMov
    ) VALUES (
        '$user',
        '$ativo',
        '$localOrigem',
        '$localDestino',
        NOW(),
        '$descricaoMovimentacao',
        '$total',
        '$quantidadeMov',
        'S',
        '$tipoMovimentacao'
    )
";

$resultInsert = mysqli_query($conexao, $queryInsert);
if ($resultInsert) {
  echo "sucesso";
} else {
  echo "Erro ao registrar movimentação: " . mysqli_error($conexao);
}

?>
