<?php
include_once('../controle/controle_session.php');
include_once('../modelo/conexao.php');
include_once('../controle/funcoes.php');
$title = "Movimentações";
include_once('navbar.php');
include_once('senac.html');
$admin = $_SESSION['admin'];
$ativos = busca_info_bd($conexao, 'ativo', 'statusAtivo', 'S');
?>
<script src="../js/movimentacoes.js"></script>

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

<div class="d-flex justify-content-center mt-4">
    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" id="modal">Cadastrar Movimentação</button>
</div>
<?php include_once('modal_movimentacoes.php'); ?>
<!-- Inclua o script no final do <body> -->
<script src="theme.js"></script>
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

<div class=" mt-5">
    <h2 class="mt-4">Lista de Movimentações</h2>
    <!-- Tabela com as movimentações -->
    <table class="table table-striped mt-4" id="tabelaMovimentacoes">
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
                        <!-- Ações podem ser adicionadas aqui -->
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <input type="hidden" id="idMovimentacao" value="">
</div>

<!-- Script para inicializar o DataTables com botões -->
<script>
    $(document).ready(function () {
        $('#tabelaMovimentacoes').DataTable({
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
<!-- Inclua o script de tema -->
<script src="../js/theme.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?php  include_once('tabelaOculta.php') ;

    exit();
?>



<div class="mt-5">
    <h2 class="mt-4">Estatísticas de Movimentações</h2>
    <div class="d-flex justify-content-center mb-3">
        <button id="btnCarregarGraficos" class="btn btn-warning">Carregar Estatísticas</button>
    </div>
    <div id="containerGraficos" style="display: none;">
        <div class="row">
            <!-- Gráfico 1: Tipo de Movimentação -->
            <div class="col-md-4">
                <canvas id="graficoTipoMov" width="300" height="300"></canvas>
                <p class="text-center mt-2">Distribuição por Tipo de Movimentação</p>
            </div>

            <!-- Gráfico 2: Usuários -->
            <div class="col-md-4">
                <canvas id="graficoUsuarios" width="300" height="300"></canvas>
                <p class="text-center mt-2">Distribuição por Usuário</p>
            </div>

            <!-- Gráfico 3: Ativos -->
            <div class="col-md-4">
                <canvas id="graficoAtivos" width="300" height="300"></canvas>
                <p class="text-center mt-2">Distribuição por Ativo</p>
            </div>
        </div>
    </div>
</div>



<script>
    document.addEventListener("DOMContentLoaded", function () {
        const btnCarregarGraficos = document.getElementById('btnCarregarGraficos');
        const containerGraficos = document.getElementById('containerGraficos');

        // Função para criar os gráficos
        function criarGraficos() {
            // Selecionar a tabela e extrair os dados
            const table = document.getElementById('tabelaMovimentacoes');
            const rows = Array.from(table.querySelectorAll('tbody tr'));

            // Estruturas para armazenar os dados
            const tipoMovCount = {};
            const usuarioCount = {};
            const ativoCount = {};

            // Iterar sobre as linhas da tabela
            rows.forEach(row => {
                const tipoMov = row.cells[6].innerText.trim(); // Coluna "Tipo"
                const usuario = row.cells[8].innerText.trim(); // Coluna "Usuário"
                const ativo = row.cells[1].innerText.trim();   // Coluna "Ativo"

                // Contagem por tipo de movimentação
                if (!tipoMovCount[tipoMov]) {
                    tipoMovCount[tipoMov] = 0;
                }
                tipoMovCount[tipoMov]++;

                // Contagem por usuário
                if (!usuarioCount[usuario]) {
                    usuarioCount[usuario] = 0;
                }
                usuarioCount[usuario]++;

                // Contagem por ativo
                if (!ativoCount[ativo]) {
                    ativoCount[ativo] = 0;
                }
                ativoCount[ativo]++;
            });

            // Função auxiliar para criar gráficos de pizza
            function criarGraficoPizza(canvasId, labels, data, titulo) {
                const ctx = document.getElementById(canvasId).getContext('2d');
                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: titulo,
                            data: data,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.6)',
                                'rgba(54, 162, 235, 0.6)',
                                'rgba(255, 206, 86, 0.6)',
                                'rgba(75, 192, 192, 0.6)',
                                'rgba(153, 102, 255, 0.6)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: titulo
                            }
                        }
                    }
                });
            }

            // Preparar os dados para os gráficos
            const labelsTipoMov = Object.keys(tipoMovCount);
            const dataTipoMov = Object.values(tipoMovCount);

            const labelsUsuarios = Object.keys(usuarioCount);
            const dataUsuarios = Object.values(usuarioCount);

            const labelsAtivos = Object.keys(ativoCount);
            const dataAtivos = Object.values(ativoCount);

            // Criar os gráficos
            criarGraficoPizza('graficoTipoMov', labelsTipoMov, dataTipoMov, 'Tipo de Movimentação');
            criarGraficoPizza('graficoUsuarios', labelsUsuarios, dataUsuarios, 'Usuários');
            criarGraficoPizza('graficoAtivos', labelsAtivos, dataAtivos, 'Ativos');
        }

        // Evento de clique no botão
        btnCarregarGraficos.addEventListener('click', function () {
            // Exibir o container de gráficos
            containerGraficos.style.display = 'block';

            // Criar os gráficos
            criarGraficos();

            // Desabilitar o botão após o clique
            btnCarregarGraficos.disabled = true;
        });
    });
</script>