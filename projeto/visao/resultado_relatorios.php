<?php 

include_once('../controle/controle_session.php');
include_once('../modelo/conexao.php');
include_once('../controle/funcoes.php');
$title = "Relatório Gerado";
include_once('senac.html');
include_once('navbar.php');

// Captura os parâmetros do formulário
$ativo = $_POST['ativo'];
$dataInicial = $_POST['data_inicial'];
$dataFinal = $_POST['data_final'];
$marca = isset($_POST['marca'])?$_POST['marca']:'';
$tipo = isset($_POST['tipo'])?$_POST['tipo']:'';

$user = $_POST['usuario'];
$tipoMov = $_POST['tipo_movimentacao'];

// Construção da consulta SQL
$sql = "
    SELECT
            (SELECT descricaoAtivo from ativo a where a.idAtivo = m.idAtivo ) as ativo ,
            (SELECT nomeUsuario from usuario u where u.idUsuario = m.idUsuario ) as usuario,
             m.idMovimentacao,
    localOrigem,
    localDestino,
    dataMovimentacao,
    descricaoMovimentacao,
    quantidadeUso,
    tipoMov,
    quantidadeMov
        FROM movimentacao m
        WHERE 
        idAtivo is not null
";

if ($ativo != null && $ativo != '') {

    $sql .= " AND m.idAtivo = $ativo"; // Adiciona condição para idAtivo
} else {
    // Condição para idMarca (subconsulta)
    if ($marca !== null && $marca != '') {
        $sql .= " AND m.idAtivo IN (SELECT idAtivo FROM ativo a WHERE a.idMarca = $marca)";
    }
    // Condição para idTipo (subconsulta)
    if ($tipo !== null && $tipo != '') {
        $sql .= " AND m.idAtivo IN (SELECT idAtivo FROM ativo a WHERE a.idTipo = $tipo)";
    }
}
// Condição para idUsuario
if ($user !== null && $user != '') {
    $sql .= " AND m.idUsuario = $user";
}
// Condição para tipoMovimentacao
if ($tipoMov !== null && $tipoMov != '') {
    $sql .= " AND m.tipoMovimentacao = $tipoMov";
}
// Condição para dataInicial
if ($dataInicial !== null && $dataInicial != '') {
    $sql .= " AND m.dataMovimentacao > $dataInicial";
}
// Condição para dataFinal
if ($dataFinal !== null && $dataFinal != '') {
    $sql .= " AND m.dataMovimentacao < $dataFinal";
}

// Executa a consulta
$result = mysqli_query($conexao, $sql);

if (!$result) {
    die("Erro na consulta: " . mysqli_error($conexao));
}
?>
<div class="container mt-5">
    <h2 class="mt-4">Lista de Relatórios</h2>
    <!-- Tabela com as movimentações -->
    <table class="table table-striped mt-4" id="tabela-relatorios">
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
                    <td><?php echo $row['usuario']; ?></td>
                    <td style="text-align:center;">
                        <!-- Ações podem ser adicionadas aqui -->
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Bibliotecas DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<!-- Script para inicializar o DataTables com botões -->
<script>
    $(document).ready(function () {
        $('#tabela-relatorios').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json', // Tradução para PT-BR
                info: "Exibindo _END_ de _TOTAL_ registros", // Personaliza a mensagem de exibição
                infoEmpty: "Nenhum registro disponível", // Mensagem quando não há dados
                infoFiltered: "(filtrado de _MAX_ registros totais)", // Mensagem de filtro
                lengthMenu: "Exibir _MENU_ registros por página", // Personaliza o seletor de registros por página
                search: "Buscar:", // Altera o texto do campo de busca
                paginate: {
                    first: "Primeira", // Botão para a primeira página
                    last: "Última", // Botão para a última página
                    next: "Próxima", // Botão para a próxima página
                    previous: "Anterior" // Botão para a página anterior
                }
            },
            dom: 'Bfrtip', // Adiciona os botões
            buttons: [
                'copy', // Copiar para a área de transferência
                'csv',  // Exportar para CSV
                'excel', // Exportar para Excel
                'pdf',   // Exportar para PDF
                'print'  // Imprimir
            ],
            pageLength: 6, // Define o número de registros por página
            lengthMenu: [6, 10, 25, 50, 100], // Opções de registros por página
            order: [[0, 'asc']] // Ordenação inicial pela coluna ID (primeira coluna)
        });
    });
</script>