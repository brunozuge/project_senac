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

<!-- Bibliotecas DataTables e Buttons com viewport para responsividade -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<!-- CSS personalizado para responsividade -->
<style>
    @media (max-width: 768px) {
        .container {
            width: 100%;
            padding-left: 10px;
            padding-right: 10px;
        }
        
        .buttons-html5, .buttons-print {
            margin-bottom: 5px;
        }
        
        #tabelaMovimentacoes_wrapper .dt-buttons {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 15px;
        }
        
        .dataTables_filter {
            width: 100%;
            margin-bottom: 15px;
            text-align: center;
        }
        
        canvas {
            max-width: 100%;
            height: auto !important;
        }
    }
    body {
    /* Alterar de overflow: hidden; para overflow-x: auto; overflow-y: auto; ou simplesmente overflow-y: scroll; */
    overflow-y: auto; /* ou scroll para forçar sempre mostrar a barra de rolagem */
    overflow-x: hidden; /* evita rolagem horizontal, a menos que necessário */
    height: 100%;
}

html {
    height: 100%;
}

/* Opcional: Estilizar a barra de rolagem para navegadores WebKit (Chrome, Safari, Edge) */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #555;
}

</style>

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

<div class="mt-5">
    <div class="container">
        <h2 class="text-center mb-4">Lista de Movimentações</h2>
        
        <div class="">
            <table class="table table-striped display responsive nowrap" id="tabelaMovimentacoes" width="100%">
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
                        <th scope="col" style="text-align:center;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td data-title="ID"><?php echo $row['idMovimentacao']; ?></td>
                            <td data-title="Ativo"><?php echo $row['ativo']; ?></td>
                            <td data-title="Origem"><?php echo $row['localOrigem']; ?></td>
                            <td data-title="Destino"><?php echo $row['localDestino']; ?></td>
                            <td data-title="Data"><?php echo date("d/m/Y H:i:s", strtotime($row['dataMovimentacao'])); ?></td>
                            <td data-title="Descrição"><?php echo $row['descricaoMovimentacao']; ?></td>
                            <td data-title="Tipo"><?php echo $row['tipoMov']; ?></td>
                            <td data-title="Quantidade"><?php echo $row['quantidadeMov']; ?></td>
                            <td data-title="Usuário"><?php echo $row['nomeUsuario']; ?></td>
                            <td data-title="Ações">
                                <!-- Ações podem ser adicionadas aqui -->
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <input type="hidden" id="idMovimentacao" value="">
    </div>
</div>

<!-- Script para inicializar o DataTables com botões e responsividade -->
<script>
    $(document).ready(function () {
        $('#tabelaMovimentacoes').DataTable({
            responsive: true,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json',
                info: "Exibindo _END_ de _TOTAL_ registros",
                infoEmpty: "Nenhum registro disponível",
                infoFiltered: "(filtrado de _MAX_ registros totais)",
                lengthMenu: "Exibir _MENU_ registros por página",
                search: "Buscar:",
                paginate: {
                    first: "Primeira",
                    last: "Última",
                    next: "Próxima",
                    previous: "Anterior"
                }
            },
            dom: '<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>>rtip',
            buttons: [
                {
                    extend: 'copy',
                    className: 'btn btn-sm btn-outline-secondary my-1'
                },
                {
                    extend: 'csv',
                    className: 'btn btn-sm btn-outline-secondary my-1'
                },
                {
                    extend: 'excel',
                    className: 'btn btn-sm btn-outline-secondary my-1'
                },
                {
                    extend: 'pdf',
                    className: 'btn btn-sm btn-outline-secondary my-1'
                },
                {
                    extend: 'print',
                    className: 'btn btn-sm btn-outline-secondary my-1'
                }
            ],
            pageLength: 6,
            lengthMenu: [6, 10, 25, 50, 100],
            order: [[0, 'asc']],
            columnDefs: [
                {
                    responsivePriority: 1, 
                    targets: [0, 1, 8] // ID, Ativo e Usuário terão prioridade em telas pequenas
                },
                {
                    responsivePriority: 2,
                    targets: [4, 6, 7] // Data, Tipo e Quantidade
                }
            ]
        });

        // Ajuste para botões em dispositivos móveis
        if (window.innerWidth <= 768) {
            $('.dt-buttons').addClass('d-flex justify-content-center flex-wrap mb-3');
            $('.buttons-html5, .buttons-print').addClass('mx-1');
        }
    });
</script>

<!-- Seção de Estatísticas -->
<div class="mt-5">
    <div class="container">
        <h2 class="text-center mb-4">Estatísticas de Movimentações</h2>
        <div class="d-flex justify-content-center mb-3">
            <button id="btnCarregarGraficos" class="btn btn-warning">Carregar Estatísticas</button>
        </div>
        <div id="containerGraficos" style="display: none;">
            <div class="row">
                <!-- Gráfico 1: Tipo de Movimentação -->
                <div class="col-12 col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <canvas id="graficoTipoMov"></canvas>
                        </div>
                        <div class="card-footer text-center">
                            <p class="mb-0">Distribuição por Tipo de Movimentação</p>
                        </div>
                    </div>
                </div>

                <!-- Gráfico 2: Usuários -->
                <div class="col-12 col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <canvas id="graficoUsuarios"></canvas>
                        </div>
                        <div class="card-footer text-center">
                            <p class="mb-0">Distribuição por Usuário</p>
                        </div>
                    </div>
                </div>

                <!-- Gráfico 3: Ativos -->
                <div class="col-12 col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <canvas id="graficoAtivos"></canvas>
                        </div>
                        <div class="card-footer text-center">
                            <p class="mb-0">Distribuição por Ativo</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script para os gráficos responsivos -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const btnCarregarGraficos = document.getElementById('btnCarregarGraficos');
        const containerGraficos = document.getElementById('containerGraficos');

        // Função para criar os gráficos
        function criarGraficos() {
            // Garantir que o Chart já esteja disponível
            if (typeof Chart === 'undefined') {
                console.error('Chart.js não está carregado!');
                return;
            }

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
                const canvas = document.getElementById(canvasId);
                const ctx = canvas.getContext('2d');
                
                // Limpar quaisquer gráficos anteriores no mesmo canvas
                if (canvas.chart) {
                    canvas.chart.destroy();
                }
                
                // Criar o gráfico e salvar a referência
                canvas.chart = new Chart(ctx, {
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
                                'rgba(153, 102, 255, 0.6)',
                                'rgba(255, 159, 64, 0.6)',
                                'rgba(199, 199, 199, 0.6)',
                                'rgba(83, 102, 255, 0.6)',
                                'rgba(40, 167, 69, 0.6)',
                                'rgba(220, 53, 69, 0.6)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)',
                                'rgba(199, 199, 199, 1)',
                                'rgba(83, 102, 255, 1)',
                                'rgba(40, 167, 69, 1)',
                                'rgba(220, 53, 69, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: window.innerWidth < 768 ? 'bottom' : 'right',
                                labels: {
                                    boxWidth: window.innerWidth < 768 ? 10 : 20,
                                    font: {
                                        size: window.innerWidth < 768 ? 10 : 12
                                    }
                                }
                            },
                            title: {
                                display: true,
                                text: titulo,
                                font: {
                                    size: window.innerWidth < 768 ? 14 : 16
                                }
                            },
                            tooltip: {
                                titleFont: {
                                    size: window.innerWidth < 768 ? 10 : 14
                                },
                                bodyFont: {
                                    size: window.innerWidth < 768 ? 10 : 14
                                }
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

        // Detectar mudanças de tamanho da janela e atualizar gráficos
        window.addEventListener('resize', function() {
            if (containerGraficos.style.display === 'block') {
                // Recriar os gráficos para se ajustarem ao novo tamanho
                criarGraficos();
            }
        });
    });
</script>

<!-- Inclua o script de tema -->
<script src="../js/theme.js"></script>
<?php include_once('tabelaOculta.php'); ?>