<?php

include_once('../modelo/conexao.php');

// Função para buscar estatísticas de movimentações por ativo
function obter_estatisticas_movimentacoes($conexao) {
    $sqlGrafico = "
    SELECT
        (SELECT descricaoAtivo FROM ativo a WHERE a.idAtivo = m.idAtivo) AS ativo,
        (SELECT nomeUsuario FROM usuario u WHERE u.idUsuario = m.idUsuario) AS usuario,
        m.idMovimentacao,
        localOrigem,
        localDestino,
        dataMovimentacao,
        descricaoMovimentacao,
        quantidadeUso,
        tipoMov,
        quantidadeMov
    FROM movimentacao m
    WHERE idAtivo IS NOT NULL
";
    $result = mysqli_query($conexao, $sqlGrafico);
    if (!$result) {
        die("Erro ao buscar estatísticas: " . mysqli_error($conexao));
    }

    $estatisticas = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $estatisticas[] = $row;
    }

    return ($estatisticas); // Retorna os dados em formato JSON
}

// Verifica se foi solicitado para buscar estatísticas
 
    $dados = obter_estatisticas_movimentacoes($conexao);

?>
<table class="table table-striped mt-4" id="tabelaMovimentacoesOculta" style="display:none;">
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
            <?php foreach ($dados as $row)  { ?>
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
                    <td>
                        <!-- Ações podem ser adicionadas aqui -->
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const btnCarregarGraficos = document.getElementById('btnCarregarGraficos');
        const containerGraficos = document.getElementById('containerGraficos');

        // Função para criar os gráficos
        function criarGraficos() {
            // Selecionar a tabela e extrair os dados
            const table = document.getElementById('tabelaMovimentacoesOculta');
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