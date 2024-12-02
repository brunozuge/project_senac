<?php
include_once("../controle/funcoes.php");
include_once("../modelo/conexao.php");
include_once("../controle/controle_session.php");
include_once("navbar.php");
include_once("senac.html");

// Consulta para buscar todos os ativos cadastrados
$query = "
SELECT
     a.idAtivo,
     a.descricaoAtivo,
     a.quantidadeAtivo,
     a.statusAtivo,
     a.observacaoAtivo, 
     (SELECT descricaoMarca FROM marca m WHERE m.idMarca = a.idMarca) AS nomeMarca,
     (SELECT descricaoTipo FROM tipo t WHERE t.idTipo = a.idTipo) AS descricaoTipo,
     (SELECT usuario FROM usuario u WHERE u.idUsuario = a.idUsuario) AS nomeUsuario,
     a.dataCadastro
FROM ativo a";

$result = mysqli_query($conexao, $query);

if (!$result) {
    die("Erro na consulta: " . mysqli_error($conexao));
}
$marcas = busca_info_bd($conexao, 'marca');
$tipos = busca_info_bd($conexao, 'tipo');
?>

<script src="../js/ativos.js"> </script>
<div class="container mt-5">
    <h2 class="form-title">Cadastrar Ativos</h2>

    <div class="d-flex justify-content-center">
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Abrir Modal</button>
    </div>
</div>

<?php 
include_once('modal_ativo.php');
?>

<div class="container mt-5">
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
                    <td><?php echo $row['descricaoTipo']; ?></td>
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
