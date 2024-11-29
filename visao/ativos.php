<?php
include_once("../modelo/conexao.php");
include_once("../controle/controle_session.php");

// Consulta para buscar todos os ativos cadastrados
$query = "
    SELECT a.idAtivo, a.descricaoAtivo, a.quantidadeAtivo, a.statusAtivo, a.observacaoAtivo, 
           m.nomeMarca, t.nomeTipo, a.dataCadastro, u.nomeUsuario 
    FROM ativo a
    JOIN marca m ON a.idMarca = m.idMarca
    JOIN tipo t ON a.idTipo = t.idTipo
    JOIN usuario u ON a.idUsuario = u.idUsuario
    ORDER BY a.dataCadastro DESC
";

$result = mysqli_query($conexao, $query);

if (!$result) {
    die("Erro na consulta: " . mysqli_error($conexao));
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Ativos</title>
    <!-- Adicionando CSS do Bootstrap para o design da tabela -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <a class="navbar-brand" href="#">Sistema de Ativos</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Página Inicial</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ativos.php">Ativos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="sobre.php">Sobre</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Sair</a>
                    </li>
                </ul>
            </div>
        </nav>

        <h2 class="mt-4">Lista de Ativos Cadastrados</h2>

        <!-- Tabela com os ativos -->
        <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Descrição do Ativo</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Quantidade</th>
                    <th scope="col">Status</th>
                    <th scope="col">Observações</th>
                    <th scope="col">Data de Cadastro</th>
                    <th scope="col">Usuário</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['idAtivo']; ?></td>
                        <td><?php echo $row['descricaoAtivo']; ?></td>
                        <td><?php echo $row['nomeMarca']; ?></td>
                        <td><?php echo $row['nomeTipo']; ?></td>
                        <td><?php echo $row['quantidadeAtivo']; ?></td>
                        <td><?php echo ($row['statusAtivo'] == 'S') ? 'Ativo' : 'Inativo'; ?></td>
                        <td><?php echo $row['observacaoAtivo']; ?></td>
                        <td><?php echo date("d/m/Y H:i:s", strtotime($row['dataCadastro'])); ?></td>
                        <td><?php echo $row['nomeUsuario']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- JS do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
