<?php include_once("../controle/controle_session.php");?>




<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Ativos</title>
    
    <!-- Bootstrap e ícones -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    
    <!-- DataTables e Buttons -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
    
    <style>
        
        /* Estilos responsivos */
        .dt-buttons {
            margin-bottom: 10px;
            flex-wrap: wrap;
            gap: 5px;
        }
        
        @media (max-width: 768px) {
            .dt-buttons button {
                font-size: 0.8rem;
                padding: 0.2rem 0.5rem;
            }
            
            .dataTables_filter {
                margin-top: 10px;
                width: 100%;
            }
            
            .dataTables_filter input {
                width: 100% !important;
                margin-left: 0 !important;
            }
            
            .form-busca {
                flex-direction: column;
            }
            
            .form-busca input {
                margin-right: 0 !important;
                margin-bottom: 10px;
            }
            
            .acoes {
                flex-direction: column;
                gap: 5px;
                align-items: center;
            }
            
            h2 {
                font-size: 1.5rem;
                text-align: center;
            }
        }
        
        /* Alerta personalizado */
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
        
        @media (max-width: 400px) {
            .custom-alert-buttons {
                flex-direction: column;
            }
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
        
        /* Responsividade para tabela */
        .table-responsive {
       
        }
        
        /* Imagens responsivas */
        .img-ativo {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }
        
        @media (max-width: 576px) {
            .img-ativo {
                width: 40px;
                height: 40px;
            }
        }
        
        /* Tema escuro */
        body {
            transition: none !important;
        }
        
        .dark-mode {
            background-color: #121212;
            color: #fff;
        }
        
        /* Ocultamento na versão mobile */
        .oculta-mobile {
            display: block;
        }
        
        @media (max-width: 991px) {
            .oculta-mobile {
                display: none !important;
            }
        }
        
        /* Espaçamento dos botões */
        .btn-action {
            margin: 2px;
        }
    </style>
</head>

<body>
    <?php
    include_once("../controle/funcoes.php");
    include_once("../modelo/conexao.php");
    
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
         a.urlImg,
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

    <div class="container py-4">
        <div class="row">
            <div class="col-12 text-center mb-3">
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" id="modal" onclick="limpar_modal()">Cadastrar Ativo</button>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <form method="GET" action="../controle/buscarProduto.php" class="form-busca d-flex flex-column flex-md-row gap-2">
                    <input type="text" name="busca" class="form-control" placeholder="Buscar produto no Mercado Livre" required>
                    <button type="submit" class="btn btn-warning shadow">Buscar</button>
                </form>
            </div>
        </div>

        <?php include_once('modal_ativo.php'); ?>

        <div class="row mb-4">
            <div class="col-12 text-center">
                <a href="detalhes.php" class="btn btn-dark shadow" id="verMaisBtn">Ver Mais</a>
            </div>
        </div>

        <div id="tabelaResumida">
            <h2 class="mb-4 text-center text-md-start">Lista de Ativos</h2>
            
            <div class="">
                <table class="table table-striped display responsive nowrap" id="tabelaAtivos" width="100%">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Marca</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Qtd</th>
                            <th scope="col">Obs</th>
                            <th scope="col">Imagem</th>
                            <th scope="col" class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { 
                        // Verifica se a quantidade está no limite crítico
                        $alerta = ($row['quantidadeAtivo'] <= $row['quantidadeMinAtivo'] + 1) ? 'table-warning' : '';
                    ?>
                        <tr class="<?php echo $alerta; ?>">
                            <td data-title="ID"><?php echo $row['idAtivo']; ?></td>
                            <td data-title="Descrição"><?php echo $row['descricaoAtivo']; ?></td>
                            <td data-title="Marca"><?php echo $row['nomeMarca']; ?></td>
                            <td data-title="Tipo"><?php echo $row['descricaoTipo']; ?></td>
                            <td data-title="Quantidade"><?php echo $row['quantidadeAtivo']; ?></td>
                            <td data-title="Obs"><?php echo htmlspecialchars($row['observacaoAtivo']); ?></td>
                            
                            <td data-title="Imagem">
                                <?php if (!empty($row['urlImg'])) { ?>
                                    <img src="<?php echo $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].':'. $_SERVER['SERVER_PORT'].'/'.$row['urlImg']; ?>" 
                                        alt="Imagem do Ativo" class="img-ativo img-thumbnail">
                                <?php } else { ?>
                                    <span>Sem imagem</span>
                                <?php } ?>
                            </td>

                            <td data-title="Ações">
                                <div class="acoes d-flex justify-content-center flex-wrap gap-2">
                                    <div class="muda_status">
                                        <?php if ($row['statusAtivo'] == 'S') { ?>
                                            <button class="btn btn-sm btn-action btn-outline-secondary" onclick="verificaEstoqueAntesDeMudar('N', '<?php echo $row['idAtivo']; ?>', <?php echo $row['quantidadeAtivo']; ?>, <?php echo $row['quantidadeMinAtivo']; ?>, '<?php echo htmlspecialchars($row['descricaoAtivo']); ?>')">
                                                <i class="bi bi-toggle-on"></i>
                                            </button>
                                        <?php } else { ?>
                                            <button class="btn btn-sm btn-action btn-outline-secondary" onclick="verificaEstoqueAntesDeMudar('S', '<?php echo $row['idAtivo']; ?>', <?php echo $row['quantidadeAtivo']; ?>, <?php echo $row['quantidadeMinAtivo']; ?>, '<?php echo htmlspecialchars($row['descricaoAtivo']); ?>')">
                                                <i class="bi bi-toggle-off"></i>
                                            </button>
                                        <?php } ?>
                                    </div>
                                    <button class="btn btn-sm btn-action btn-outline-primary" onclick="edita(<?php echo $row['idAtivo']; ?>)">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="../js/ativos.js"></script>

    <!-- Alerta personalizado -->
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

    <!-- DataTables -->
    <script>
        $(document).ready(function () {
            $('#tabelaAtivos').DataTable({
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
                        text: 'Copiar',
                        className: 'btn btn-sm btn-secondary'
                    },
                    {
                        extend: 'csv',
                        text: 'CSV',
                        className: 'btn btn-sm btn-secondary'
                    },
                    {
                        extend: 'excel',
                        text: 'Excel',
                        className: 'btn btn-sm btn-secondary'
                    },
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        className: 'btn btn-sm btn-secondary'
                    },
                    {
                        extend: 'print',
                        text: 'Imprimir',
                        className: 'btn btn-sm btn-secondary'
                    }
                ],
                pageLength: 6,
                lengthMenu: [6, 10, 25, 50, 100],
                order: [[0, 'asc']],
                columnDefs: [
                    { responsivePriority: 1, targets: 0 },
                    { responsivePriority: 2, targets: 1 },
                    { responsivePriority: 3, targets: 4 },
                    { responsivePriority: 4, targets: 7 }
                ]
            });
            
            // Toggle tabela
            $("#toggleTabela").click(function () {
                $("#tabelaResumida").toggle();
                $("#tabelaCompleta").toggle();
                var btnText = $("#tabelaCompleta").is(":visible") ? "Ver Menos" : "Ver Mais";
                $("#toggleTabela").text(btnText);
            });
        });
    </script>
    
    <!-- Tema -->
    <script src="../js/theme.js"></script>
</body>
</html>