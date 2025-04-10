


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
    
    <style>
        .acoes {
            display: flex;
            justify-content: space-around;
            flex-wrap: nowrap;
            gap: 8px;
        }
        .acoes div {
            cursor: pointer;
        }
        .table-container {
            overflow-x: auto;
            width: 100%;
        }
        @media (max-width: 768px) {
            .dt-buttons {
                margin-bottom: 10px;
                flex-wrap: wrap;
                justify-content: center;
            }
            .dt-buttons button {
                margin: 2px;
                font-size: 0.8rem;
            }
            .dataTables_filter input {
                width: 100% !important;
                margin-left: 0 !important;
            }
            .dataTables_filter {
                width: 100%;
                text-align: left;
                margin-bottom: 10px;
            }
            h2 {
                font-size: 1.5rem;
                text-align: center;
            }
        }
    </style>
</head>

<body>
<?php
include_once('../controle/controle_session.php');
include_once('../modelo/conexao.php');
include_once('../controle/funcoes.php');
$tipos = busca_info_bd($conexao, 'tipo');
$title = "Tipos";
include_once("senac.html");
include_once('modal_tipo.php');
include('navbar.php');
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-center mb-4">
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" id="modal">Cadastrar Tipo</button>
    </div>

    <h2 class="mb-4 text-center text-md-start">Lista de Tipos</h2>

    <div class="">
        <table class="table table-striped table-hover display responsive nowrap" id="tabelaTipos" width="100%">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Data de Cadastro</th>
                    <th scope="col">Usuário</th>
                    <th scope="col" class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tipos as $tipo) { ?>
                    <tr>
                        <td data-title="ID"><?php echo $tipo['idTipo']; ?></td>
                        <td data-title="Tipo"><?php echo $tipo['descricaoTipo']; ?></td>
                        <td data-title="Data"><?php echo date("d/m/Y H:i:s", strtotime($tipo['dataCadastro'])); ?></td>
                        <td data-title="Usuário"><?php echo $tipo['usuarioCadastro']; ?></td>
                        <td data-title="Ações">
                            <div class="acoes">
                                <div class="muda_status">
                                    <?php if ($tipo['statusTipo'] == "S") { ?>
                                        <div class="inativo" onclick="muda_status('N','<?php echo $tipo['idTipo']; ?>')">
                                            <i class="bi bi-toggle-on"></i>
                                        </div>
                                    <?php } else { ?>
                                        <div class="ativo" onclick="muda_status('S', '<?php echo $tipo['idTipo']; ?>')">
                                            <i class="bi bi-toggle-off"></i>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="edit" onclick="edita('<?php echo $tipo['idTipo']; ?>')">
                                    <i class="bi bi-pencil-square"></i>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <input type="hidden" id="idTipo" name="idTipo">
</div>

<!-- jQuery e DataTables Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/tipos.js"></script>

<!-- Script para inicializar o DataTables com responsividade -->
<script>
    $(document).ready(function () {
        $('#tabelaTipos').DataTable({
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
            order: [[0, 'asc']]
        });
    });
</script>
<script src="../js/theme.js"></script>
</body>
</html>