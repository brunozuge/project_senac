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

$user = $_SESSION['usuario_logado'];

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
  echo "Movimentação realizada com sucesso";
} else {
  echo "Erro ao registrar movimentação: " . mysqli_error($conexao);
}






function obter_estatisticas_movimentacoes($conexao) {
  $estatisticas = [];

  // Total de movimentações
  $query_total = "SELECT COUNT(*) AS total FROM movimentacao WHERE statusMov = 'S'";
  $result_total = mysqli_query($conexao, $query_total);
  $estatisticas['total'] = mysqli_fetch_assoc($result_total)['total'];

  // Distribuição por tipo de movimentação
  $query_tipo = "
      SELECT tipoMov, COUNT(*) AS quantidade
      FROM movimentacao
      WHERE statusMov = 'S'
      GROUP BY tipoMov
  ";
  $result_tipo = mysqli_query($conexao, $query_tipo);
  $estatisticas['tipoMov'] = [];
  while ($row = mysqli_fetch_assoc($result_tipo)) {
      $estatisticas['tipoMov'][$row['tipoMov']] = $row['quantidade'];
  }

  // Movimentações por usuário
  $query_usuario = "
      SELECT u.usuario, COUNT(*) AS quantidade
      FROM movimentacao m
      JOIN usuario u ON m.idUsuario = u.idUsuario
      WHERE m.statusMov = 'S'
      GROUP BY u.usuario
  ";
  $result_usuario = mysqli_query($conexao, $query_usuario);
  $estatisticas['usuarios'] = [];
  while ($row = mysqli_fetch_assoc($result_usuario)) {
      $estatisticas['usuarios'][$row['usuario']] = $row['quantidade'];
  }

  // Movimentações por ativo
  $query_ativo = "
      SELECT a.descricaoAtivo, COUNT(*) AS quantidade
      FROM movimentacao m
      JOIN ativo a ON m.idAtivo = a.idAtivo
      WHERE m.statusMov = 'S'
      GROUP BY a.descricaoAtivo
  ";
  $result_ativo = mysqli_query($conexao, $query_ativo);
  $estatisticas['ativos'] = [];
  while ($row = mysqli_fetch_assoc($result_ativo)) {
      $estatisticas['ativos'][$row['descricaoAtivo']] = $row['quantidade'];
  }

  return $estatisticas;
}
?>
