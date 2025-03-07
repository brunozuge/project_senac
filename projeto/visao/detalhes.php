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
     a.quantidadeMinAtivo,
     a.statusAtivo,
     a.observacaoAtivo, 
     a.obsQuantiAtivo,
     a.urlImg, -- Certifique-se de que essa coluna existe no banco de dados
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

<!-- Botão de voltar -->
<a href="ativos.php" class="btn btn-warning" id="voltarBtn">Voltar</a>

<!-- Estilo CSS para o botão -->
<style>
    #voltarBtn {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000; /* Garante que o botão fique visível sobre outros elementos */
    }

    /* Adicionando um espaço extra para empurrar as informações para baixo */
    .content-wrapper {
        margin-top: 50px; /* Ajusta a distância do topo */
    }
</style>

<!-- Inclua as bibliotecas DataTables e Buttons -->
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
<script src="../js/ativos.js"></script>

<!-- Inclua o script no final do <body> -->
<?php include_once('modal_ativo.php'); ?>

<!-- Conteúdo da tabela com margens ajustadas -->
<div class="content-wrapper">
    <script>$(document).ready(function () {
        $("#toggleTabela").click(function () {
            $("#tabelaResumida").toggle();
            $("#tabelaCompleta").toggle();
            var btnText = $("#tabelaCompleta").is(":visible") ? "Ver Menos" : "Ver Mais";
            $("#toggleTabela").text(btnText);
        });
    });
    </script>

    <!-- Tabela Simples (Visível por padrão) -->
    <table id="tabelaAtivos" class="table table-striped mt-4">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Descrição do Ativo</th>
                <th scope="col">Marca</th>
                <th scope="col">Tipo</th>
                <th scope="col">Quantidade</th>
                <th scope="col">Quantidade Mínima</th>
                <th scope="col">Imagem</th>
                <th scope="col">Observações</th>
                <th scope="col">Data de Cadastro</th>
                <th scope="col">Obs Quantidade Ativo</th>
                <th scope="col">Usuário</th>
                <th style="text-align:center;">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { 
                $quantidade = (int) $row['quantidadeAtivo'];
                $quantidadeMinima = (int) $row['quantidadeMinAtivo'];
                $alerta = ($quantidade <= $quantidadeMinima + 2) ? '<span class="badge bg-danger">⚠️ Estoque Baixo</span>' : '';
            ?>
            <tr>
                <td><?php echo htmlspecialchars($row['idAtivo']); ?></td>
                <td><?php echo htmlspecialchars($row['descricaoAtivo']); ?></td>
                <td><?php echo htmlspecialchars($row['nomeMarca']); ?></td>
                <td><?php echo htmlspecialchars($row['descricaoTipo']); ?></td>
                <td>
                    <?php echo htmlspecialchars($quantidade); ?>
                    <?php echo $alerta; ?>
                </td>
                <td><?php echo htmlspecialchars($quantidadeMinima); ?></td>
                <td>
                    <?php if (!empty($row['urlImg'])) { ?>
                        <img src="<?php echo $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].':'. $_SERVER['SERVER_PORT'].'/'.$row['urlImg']; ?>" 
                             alt="Imagem do Ativo" 
                             style="width: 50px; height: 50px; object-fit: cover;">
                    <?php } else { ?>
                        <span>Sem imagem</span>
                    <?php } ?>
                </td>
                <td><?php echo htmlspecialchars($row['observacaoAtivo']); ?></td>
                <td><?php echo date("d/m/Y H:i:s", strtotime($row['dataCadastro'])); ?></td>
                <td><?php echo htmlspecialchars($row['obsQuantiAtivo']); ?></td>
                <td><?php echo htmlspecialchars($row['nomeUsuario']); ?></td>
                <td>
                    <div class="acoes d-flex justify-content-between">
                        <div class="muda_status">
                            <?php if ($row['statusAtivo'] == 'S') { ?>
                                <div class="inativo" onclick="muda_status('N','<?php echo $row['idAtivo']; ?>')">
                                    <i class="bi bi-toggle-on"></i>
                                </div>
                            <?php } else { ?>
                                <div class="ativo" onclick="muda_status('S','<?php echo $row['idAtivo']; ?>')">
                                    <i class="bi bi-toggle-off"></i>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="edit" onclick="edita(<?php echo $row['idAtivo']; ?>)">
                            <i class="bi bi-pencil-square"></i>
                        </div>
                    </div>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
   $(document).ready(function () {
        $('#tabelaAtivos').DataTable({
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
<script src="../js/theme.js"></script>
