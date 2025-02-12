<?php

include_once('../controle/controle_session.php');
include_once('../modelo/conexao.php');
include_once('../controle/funcoes.php');

$title = "Movimentações";
include_once('navbar.php');
include_once('senac.html');

$ativos = busca_info_bd($conexao, 'ativo', 'statusAtivo', 'S');

?>

<script src="../js/movimentacoes.js"></script>

<div class="d-flex justify-content-center mt-4">
    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" id="modal">Cadastrar Movimentação</button>
</div>

<?php include_once('modal_movimentacoes.php'); ?>

<?php
// Consulta para buscar todas as movimentações
$query = "
SELECT
    m.idMovimentacao,
    m.localOrigem,
    m.localDestino,
    m.dataMovimentacao,
    m.descricaoMovimentacao,
    m.quantidadeUso,
    m.tipoMov,
    m.quantidadeMov,
    (SELECT descricaoAtivo FROM ativo a WHERE a.idAtivo = m.idAtivo) AS ativo,
    (SELECT usuario FROM usuario u WHERE u.idUsuario = m.idUsuario) AS nomeUsuario
FROM movimentacao m
WHERE m.statusMov = 'S'";

$result = mysqli_query($conexao, $query);

if (!$result) {
    die("Erro na consulta: " . mysqli_error($conexao));
}
?>

<div class="container mt-5">
    <h2 class="mt-4">Lista de Movimentações</h2>

    <!-- Tabela com as movimentações -->
    <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Ativo</th>
                <th scope="col">Origem</th>
                <th scope="col">Destino</th>
                <th scope="col">Data</th>
                <th scope="col">Descrição</th>
                <th scope="col">Tipo</th>
                <th scope="col">Quantidade</th>
                <th scope="col">Usuário</th>
                <th style="text-align:center;">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['idMovimentacao']; ?></td>
                    <td><?php echo $row['ativo']; ?></td>
                    <td><?php echo $row['localOrigem']; ?></td>
                    <td><?php echo $row['localDestino']; ?></td>
                    <td><?php echo date("d/m/Y H:i:s", strtotime($row['dataMovimentacao'])); ?></td>
                    <td><?php echo $row['descricaoMovimentacao']; ?></td>
                    <td><?php echo $row['tipoMov']; ?></td>
                    <td><?php echo $row['quantidadeMov']; ?></td>
                    <td><?php echo $row['nomeUsuario']; ?></td>
                    <td>
                      
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <input type="hidden" id="idMovimentacao" value="">
</div>
