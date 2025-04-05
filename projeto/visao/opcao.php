<?php

// Inclui os arquivos necessários
include_once('../controle/controle_session.php');

include_once('../modelo/conexao.php');
include_once('../controle/funcoes.php');

// Busca as opções no banco de dados
$opcoes = busca_info_bd($conexao, 'opcoes_menu');
$title = "Opções";
$niveis = busca_info_bd($conexao, 'nivel_acesso');

include_once("senac.html");
include('navbar.php');

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?></title>
    
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
        
        body {
            transition: none !important;
        }

        .dark-mode {
            background-color: #121212;
            color: #fff;
        }

        .acoes {
            display: flex;
            justify-content: space-around;
        }

        .acoes i {
            font-size: 1.5rem;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .acoes i:hover {
            color: #17a2b8;
        }
    </style>
</head>
<body>
    <div class="d-flex justify-content-center mt-4">
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" id="modal">Cadastrar Opção</button>
    </div>

    <?php include_once('modal_opcoes.php'); ?>

    <div class="container mt-4">
        <h2 class="text mb-4">Lista de Opções</h2>

        <table class="table table-striped mt-4" id="tabelaOpcoes">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Data de Cadastro</th>
                    <th scope="col">Usuário</th>
                    <th style="text-align:center;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($opcoes as $opcao): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($opcao['idOpcao']); ?></td>
                        <td><?php echo htmlspecialchars($opcao['descricaoOpcao']); ?></td>
                        <td><?php echo date("d/m/Y H:i:s", strtotime($opcao['datacadastroOpcao'])); ?></td>
                        <td><?php echo htmlspecialchars($opcao['idUsuario']); ?></td>
                        <td>
                            <div class="acoes d-flex justify-content-between">
                                <div class="muda_status">
                                    <?php if ($opcao['statusOpcao'] == 'S') { ?>
                                        <div class="inativo" onclick="verificaAntesDeMudar('N', '<?php echo $opcao['idOpcao']; ?>', '<?php echo htmlspecialchars($opcao['descricaoOpcao']); ?>')">
                                            <i class="bi bi-toggle-on"></i>
                                        </div>
                                    <?php } else { ?>
                                        <div class="ativo" onclick="verificaAntesDeMudar('S', '<?php echo $opcao['idOpcao']; ?>', '<?php echo htmlspecialchars($opcao['descricaoOpcao']); ?>')">
                                            <i class="bi bi-toggle-off"></i>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="edit" onclick="editar(<?php echo $opcao['idOpcao']; ?>)">
                                    <i class="bi bi-pencil-square"></i>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Hidden Input for ID -->
    <input type="hidden" id="idOpcao" name="idOpcao">

    <!-- Bootstrap and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
<script src ="../js/opcao.js"> </script>
    <script>/*
        // Função para mostrar o alerta personalizado (similar ao da página de ativos)
        function showCustomAlert(message, onConfirm, onCancel, isWarning = true) {
            const overlay = document.createElement('div');
            overlay.className = 'custom-alert-overlay';
            
            const alertBox = document.createElement('div');
            alertBox.className = 'custom-alert-box';
            
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
            
            overlay.appendChild(alertBox);
            document.body.appendChild(overlay);
            
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

        // Função para verificar antes de mudar status
        function verificaAntesDeMudar(novoStatus, idOpcao, descricaoOpcao) {
            const statusText = novoStatus === 'S' ? 'ativar' : 'desativar';
            
            showCustomAlert(
                `Deseja realmente ${statusText} a opção <strong>${descricaoOpcao}</strong>?`,
                function() {
                    // Usuário confirmou - prosseguir com a mudança de status
                    muda_status(novoStatus, idOpcao);
                },
                function() {
                    // Usuário cancelou - não fazer nada
                    console.log("Operação cancelada pelo usuário");
                },
                false // Não é um aviso, é só uma confirmação
            );
        }

        // Função para mudar status via AJAX
        function muda_status(statusOpcao, idOpcao) {
            $.ajax({
                type: 'POST',
                url: "../controle/opcoes_controller.php",
                data: {
                    acao: 'alterar_status',
                    statusOpcao: statusOpcao,
                    idOpcao: idOpcao
                },
                success: function (response) {
                    alert(response);
                    location.reload();
                },
                error: function (xhr, status, error) {
                    console.error("Erro ao alterar status:", error);
                }
            });
        }

        // Função para editar opção
        function edita(idOpcao) {
            $.ajax({
                type: 'POST',
                url: "../controle/opcoes_controller.php",
                data: {
                    acao: 'get_info',
                    idOpcao: idOpcao
                },
                success: function (response) {
                    const opcao = JSON.parse(response)[0];
                    $('#idOpcao').val(opcao.idOpcao);
                    $('#descricaoOpcao').val(opcao.descricaoOpcao);
                    $('#exampleModal').modal('show');
                },
                error: function (xhr, status, error) {
                    console.error("Erro ao carregar informações da opção:", error);
                }
            });
        }

        // Inicializar DataTables
        $(document).ready(function () {
            $('#tabelaOpcoes').DataTable({
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
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                pageLength: 6,
                lengthMenu: [6, 10, 25, 50, 100],
                order: [[0, 'asc']]
            });
        });
        */
    </script>
    
    <!-- Inclua o script de tema -->
    <script src="../js/theme.js"></script>
</body>
</html>