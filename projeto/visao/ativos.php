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

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Ativos</title>
    
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
    
    <style>
        /* Estilos para o alerta personalizado */
        .custom-alert-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .custom-alert-box {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            padding: 20px;
            width: 90%;
            max-width: 400px;
            text-align: center;
            animation: alertPopIn 0.3s ease-out;
        }

        @keyframes alertPopIn {
            0% { transform: scale(0.8); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }

        .custom-alert-icon {
            font-size: 48px;
            color: #ffc107;
            margin-bottom: 15px;
        }

        .custom-alert-icon.info {
            color: #0d6efd;
        }

        .custom-alert-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }

        .custom-alert-message {
            margin-bottom: 20px;
            color: #555;
        }

        .custom-alert-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .custom-alert-btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            transition: background-color 0.2s;
        }

        .custom-alert-btn-cancel {
            background-color: #f1f1f1;
            color: #333;
        }

        .custom-alert-btn-cancel:hover {
            background-color: #e1e1e1;
        }

        .custom-alert-btn-confirm {
            background-color: #0d6efd;
            color: white;
        }

        .custom-alert-btn-confirm:hover {
            background-color: #0b5ed7;
        }

        /* Suporte para tema escuro */
        .dark-mode .custom-alert-box {
            background-color: #2d2d2d;
            color: #fff;
        }

        .dark-mode .custom-alert-title {
            color: #fff;
        }

        .dark-mode .custom-alert-message {
            color: #ddd;
        }

        .dark-mode .custom-alert-btn-cancel {
            background-color: #444;
            color: #fff;
        }

        .dark-mode .custom-alert-btn-cancel:hover {
            background-color: #555;
        }
        
        /* Aplica o tema escuro imediatamente se a preferência for salva */
        body {
            transition: none !important; /* Remove a transição para evitar o efeito */
        }

        /* Caso o tema escuro tenha sido selecionado no localStorage, aplica imediatamente */
        .dark-mode {
            background-color: #121212; /* Cor do fundo para o tema escuro */
            color: #fff; /* Cor do texto para o tema escuro */
        }

        .oculta_mobile{
            display: block;
        }
        @media  (max-width:991px){
            .oculta_mobile{
                 display: none!important;
            }
        }
    </style>
</head>
<body>
    <div class="d-flex justify-content-center mt-4">
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" id="modal" onclick="limpar_modal()">Cadastrar Ativo</button>
    </div>

    <form method="GET" action="../controle/buscarProduto.php" class="form-busca d-flex mt-3">
        <input type="text" name="busca" class="form-control me-2" placeholder="Buscar produto no Mercado Livre" required>
        <button type="submit" class="btn btn-warning shadow">Buscar</button>
    </form>

    <?php include_once('modal_ativo.php'); ?>

    <div class="d-flex justify-content-center mt-4">
        <a href="detalhes.php" class="btn btn-dark shadow" id="verMaisBtn">Ver Mais</a>
    </div>

    <script>
        $(document).ready(function () {
            $("#toggleTabela").click(function () {
                $("#tabelaResumida").toggle();
                $("#tabelaCompleta").toggle();
                var btnText = $("#tabelaCompleta").is(":visible") ? "Ver Menos" : "Ver Mais";
                $("#toggleTabela").text(btnText);
            });
        });
    </script>
    
    <div id="tabelaResumida">
        <h2 class="container mt-4">Lista de Ativos</h2>
       
    <div class="container mt-4">
    <div style="overflow-x: auto;">
        <table class="table table-striped mt-4" id="tabelaAtivos">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Descrição do Ativo</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Quantidade</th>
                    <th scope="col">Observações</th>
                    <th scope="col">Imagem</th>
                    <th style="text-align:center;">Ações</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { 
                // Verifica se a quantidade está no limite crítico
                $alerta = ($row['quantidadeAtivo'] <= $row['quantidadeMinAtivo'] + 1) ? 'table-warning' : '';
            ?>
                <tr class="<?php echo $alerta; ?>"> <!-- Adiciona classe de alerta na linha -->
                    <td><?php echo $row['idAtivo']; ?></td>
                    <td><?php echo $row['descricaoAtivo']; ?></td>
                    <td><?php echo $row['nomeMarca']; ?></td>
                    <td><?php echo $row['descricaoTipo']; ?></td>
                    <td><?php echo $row['quantidadeAtivo']; ?></td>
                    <td><?php echo htmlspecialchars($row['observacaoAtivo']); ?></td>
                    
                    <td>
                        <?php if (!empty($row['urlImg'])) { ?>
                            <img src="<?php echo $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].':'. $_SERVER['SERVER_PORT'].'/'.$row['urlImg']; ?>" 
                                alt="Imagem do Ativo" style="width: 50px; height: 50px; object-fit: cover;">
                        <?php } else { ?>
                            <span>Sem imagem</span>
                        <?php } ?>
                    </td>

                    <td>
                        <div class="acoes d-flex justify-content-between">
                            <!-- Botão para abrir o modal de ativos -->
<div class="text-center mt-2">
  <a href="responsiveAtivo.php" class="btn btn-primary">
    Ver Lista de Ativos
  </a>
</div>

                            <div class="muda_status">
                                
                   
                                <?php if ($row['statusAtivo'] == 'S') { ?>
                                    <div class="inativo" onclick="verificaEstoqueAntesDeMudar('N', '<?php echo $row['idAtivo']; ?>', <?php echo $row['quantidadeAtivo']; ?>, <?php echo $row['quantidadeMinAtivo']; ?>, '<?php echo htmlspecialchars($row['descricaoAtivo']); ?>')">
                                        <i class="bi bi-toggle-on"></i>
                                    </div>
                                <?php } else { ?>
                                    <div class="ativo" onclick="verificaEstoqueAntesDeMudar('S', '<?php echo $row['idAtivo']; ?>', <?php echo $row['quantidadeAtivo']; ?>, <?php echo $row['quantidadeMinAtivo']; ?>, '<?php echo htmlspecialchars($row['descricaoAtivo']); ?>')">
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

    <!-- Scripts para o alerta personalizado e verificação de estoque -->
    <script>
        // Função para mostrar o alerta personalizado
        function showCustomAlert(message, onConfirm, onCancel, isWarning = true) {
            // Criar overlay
            const overlay = document.createElement('div');
            overlay.className = 'custom-alert-overlay';
            
            // Criar caixa de alerta
            const alertBox = document.createElement('div');
            alertBox.className = 'custom-alert-box';
            
            // Conteúdo do alerta
            alertBox.innerHTML = `
                <div class="custom-alert-icon ${isWarning ? '' : 'info'}">
                    <i class="bi ${isWarning ? 'bi-exclamation-triangle-fill' : 'bi-info-circle-fill'}"></i>
                </div>
                <div class="custom-alert-title">${isWarning ? 'Atenção!' : 'Confirmar ação'}</div>
                <div class="custom-alert-message">${message}</div>
                <div class="custom-alert-buttons">
                    <button class="custom-alert-btn custom-alert-btn-cancel">Cancelar</button>
                    <button class="custom-alert-btn custom-alert-btn-confirm">Continuar</button>
                </div>
            `;
            
            // Adicionar ao DOM
            overlay.appendChild(alertBox);
            document.body.appendChild(overlay);
            
            // Ações dos botões
            const cancelBtn = alertBox.querySelector('.custom-alert-btn-cancel');
            const confirmBtn = alertBox.querySelector('.custom-alert-btn-confirm');
            
            cancelBtn.addEventListener('click', function() {
                document.body.removeChild(overlay);
                if (onCancel) onCancel();
            });
            
            confirmBtn.addEventListener('click', function() {
                document.body.removeChild(overlay);
                if (onConfirm) onConfirm();
            });

            // Aplicar tema escuro se necessário
            if (document.body.classList.contains('dark-mode')) {
                alertBox.classList.add('dark-mode');
            }
        }

        // Função para verificar estoque antes de mudar status
        function verificaEstoqueAntesDeMudar(novoStatus, idAtivo, quantidade, quantidadeMin, descricaoAtivo) {
            const statusText = novoStatus === 'S' ? 'ativar' : 'desativar';
            
            if (quantidade <= quantidadeMin + 2) {
                // Alerta de aviso para quantidade baixa
                showCustomAlert(
                    `A quantidade do ativo <strong>${descricaoAtivo}</strong> está próxima ou abaixo do mínimo permitido.<br><br>Deseja realmente ${statusText} este item?`,
                    function() {
                        // Usuário confirmou - prosseguir com a mudança de status
                        muda_status(novoStatus, idAtivo);
                    },
                    function() {
                        // Usuário cancelou - não fazer nada
                        console.log("Operação cancelada pelo usuário");
                    },
                    true // É um aviso
                );
            } else {
                // Alerta normal para confirmação
                showCustomAlert(
                    `Deseja realmente ${statusText} o ativo <strong>${descricaoAtivo}</strong>?`,
                    function() {
                        // Usuário confirmou - prosseguir com a mudança de status
                        muda_status(novoStatus, idAtivo);
                    },
                    function() {
                        // Usuário cancelou - não fazer nada
                        console.log("Operação cancelada pelo usuário");
                    },
                    false // Não é um aviso, é só uma confirmação
                );
            }
        }
    </script>

    <!-- Script para inicializar o DataTables com botões -->
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
    
    <!-- Inclua o script de tema -->
    <script src="../js/theme.js"></script>
</body>
</html>