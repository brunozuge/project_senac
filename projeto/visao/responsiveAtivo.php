<?php
include_once('navbar.php');
include_once('../modelo/conexao.php');

// Pega todos os ativos do banco de dados
$sql = "SELECT a.*, m.nomeMarca, t.descricaoTipo 
        FROM ativo a
        JOIN marca m ON a.idMarca = m.idMarca
        JOIN tipo t ON a.idTipo = t.idTipo";
$result = mysqli_query($conexao, $sql); // <-- Correção aqui
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Ativos - Modal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-4">
    <h2 class="text-center mb-4">Lista de Ativos</h2>

    <?php while ($row = mysqli_fetch_assoc($result)) { 
        $alerta = ($row['quantidadeAtivo'] <= $row['quantidadeMinAtivo'] + 1) ? 'border-warning' : '';
    ?>
    <div class="card mb-3 border <?php echo $alerta; ?>">
        <div class="card-body">
            <h5 class="card-title"><?php echo $row['descricaoAtivo']; ?></h5>
            <p><strong>ID:</strong> <?php echo $row['idAtivo']; ?></p>
            <p><strong>Marca:</strong> <?php echo $row['nomeMarca']; ?></p>
            <p><strong>Tipo:</strong> <?php echo $row['descricaoTipo']; ?></p>
            <p><strong>Quantidade:</strong> <?php echo $row['quantidadeAtivo']; ?></p>
            <p><strong>Observações:</strong> <?php echo htmlspecialchars($row['observacaoAtivo']); ?></p>
            <p>
                <strong>Imagem:</strong><br>
                <?php if (!empty($row['urlImg'])) { ?>
                    <img src="<?php echo $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].':'. $_SERVER['SERVER_PORT'].'/'.$row['urlImg']; ?>" 
                        alt="Imagem do Ativo" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                <?php } else { ?>
                    <span>Sem imagem</span>
                <?php } ?>
            </p>

            <div class="d-flex flex-wrap gap-2 mt-2">
                <a href="responsiveAtivo.php" class="btn btn-success btn-sm">Ir para Página</a>

                <?php if ($row['statusAtivo'] == 'S') { ?>
                    <div class="text-success" role="button" onclick="verificaEstoqueAntesDeMudar('N', '<?php echo $row['idAtivo']; ?>', <?php echo $row['quantidadeAtivo']; ?>, <?php echo $row['quantidadeMinAtivo']; ?>, '<?php echo htmlspecialchars($row['descricaoAtivo']); ?>')">
                        <i class="bi bi-toggle-on fs-4"></i>
                    </div>
                <?php } else { ?>
                    <div class="text-secondary" role="button" onclick="verificaEstoqueAntesDeMudar('S', '<?php echo $row['idAtivo']; ?>', <?php echo $row['quantidadeAtivo']; ?>, <?php echo $row['quantidadeMinAtivo']; ?>, '<?php echo htmlspecialchars($row['descricaoAtivo']); ?>')">
                        <i class="bi bi-toggle-off fs-4"></i>
                    </div>
                <?php } ?>

                <div class="text-primary" role="button" onclick="edita(<?php echo $row['idAtivo']; ?>)">
                    <i class="bi bi-pencil-square fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
