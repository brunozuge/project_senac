<?php
session_start();
include_once('../modelo/conexao.php');

// Função para buscar estatísticas de movimentações por ativo
function obter_estatisticas_movimentacoes($conexao) {
    $sqlGrafico = "
        SELECT 
            a.descricaoAtivo, 
            SUM(m.quantidadeMov) as totalMovimentado
        FROM movimentacao m
        JOIN ativo a ON a.idAtivo = m.idAtivo
        WHERE m.statusMov = 'S'
        GROUP BY a.descricaoAtivo
        ORDER BY totalMovimentado DESC
        LIMIT 10;
    ";
    $result = mysqli_query($conexao, $sqlGrafico);
    if (!$result) {
        die("Erro ao buscar estatísticas: " . mysqli_error($conexao));
    }

    $estatisticas = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $estatisticas[] = $row;
    }

    return json_encode($estatisticas); // Retorna os dados em formato JSON
}

// Verifica se foi solicitado para buscar estatísticas
if (isset($_GET['action']) && $_GET['action'] === 'obter_estatisticas') {
    echo obter_estatisticas_movimentacoes($conexao);
    exit();
}
?><div class="mt-5">
<h2 class="mt-4">Estatísticas de Movimentações</h2>
<div class="d-flex justify-content-center mb-3">
    <button id="btnCarregarGraficos" class="btn btn-primary">Carregar Estatísticas</button>
</div>
<div id="containerGraficos" style="display: none;">
    <div class="row">
        <!-- Gráfico 1: Ativos Mais Movimentados -->
        <div class="col-md-12">
            <canvas id="graficoAtivos" width="600" height="300"></canvas>
            <p class="text-center mt-2">Distribuição por Ativo (Top 10)</p>
        </div>
    </div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const btnCarregarGraficos = document.getElementById('btnCarregarGraficos');
    const containerGraficos = document.getElementById('containerGraficos');

    // Função para criar gráficos
    function criarGraficos(dados) {
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
                            'rgba(153, 102, 255, 0.6)',
                            'rgba(255, 159, 64, 0.6)',
                            'rgba(199, 199, 199, 0.6)',
                            'rgba(100, 100, 255, 0.6)',
                            'rgba(255, 0, 0, 0.6)',
                            'rgba(0, 255, 0, 0.6)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(199, 199, 199, 1)',
                            'rgba(100, 100, 255, 1)',
                            'rgba(255, 0, 0, 1)',
                            'rgba(0, 255, 0, 1)'
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
        const labelsAtivos = dados.map(item => item.descricaoAtivo);
        const dataAtivos = dados.map(item => item.totalMovimentado);

        // Criar os gráficos
        criarGraficoPizza('graficoAtivos', labelsAtivos, dataAtivos, 'Distribuição por Ativo (Top 10)');
    }

    // Evento de clique no botão
    btnCarregarGraficos.addEventListener('click', function () {
        fetch('../controle/controle_movimentacao.php?action=obter_estatisticas')
            .then(response => response.json())
            .then(data => {
                // Exibir o container de gráficos
                containerGraficos.style.display = 'block';
                // Criar os gráficos com os dados recebidos
                criarGraficos(data);
                // Desabilitar o botão após o clique
                btnCarregarGraficos.disabled = true;
            })
            .catch(error => {
                console.error('Erro ao carregar estatísticas:', error);
                alert('Ocorreu um erro ao carregar as estatísticas.');
            });
    });
});
</script>