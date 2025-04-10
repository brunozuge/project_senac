<?php
include_once('../controle/controle_session.php');
include_once('../modelo/conexao.php');
include_once('../controle/funcoes.php');
$marcas = busca_info_bd($conexao, 'marca');
$title = "Marcas";
include_once("senac.html");
include_once('modal_marca.php');
include('navbar.php');
?>
<!-- Meta tag para responsividade -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Bibliotecas CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

<!-- Estilos responsivos aprimorados -->
<style>
    /* Configurações gerais para todos os dispositivos */
    .table-responsive-container {
        width: 100%;
      
        margin-bottom: 1rem;
    }
    
    /* Estilos para tabela e DataTables */
    #tabelaMarcas {
        width: 100% !important;
    }
    
    .dataTables_wrapper {
        width: 100% !important;
        padding: 0;
    }
    
    /* Estilos para ações na tabela */
    .acoes {
        display: flex;
        justify-content: center;
        gap: 12px;
    }
    
    .acoes div {
        cursor: pointer;
        padding: 4px;
        transition: transform 0.2s ease;
    }
    
    .acoes div:hover {
        transform: scale(1.2);
    }
    
    .acoes i {
        font-size: 1.2rem;
    }
    
    /* Formatação de botões do DataTables */
    .dt-buttons {
        margin-bottom: 15px;
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
    }
    
    .dt-button {
        margin: 2px !important;
        padding: 5px 10px !important;
    }
    
    /* Estilos para dispositivos móveis e tablets */
    @media (max-width: 991.98px) {
        .container {
            padding-left: 10px;
            padding-right: 10px;
            max-width: 100%;
        }
        
        .btn-container {
            display: flex;
            justify-content: center;
            margin: 1rem 0;
        }
        
        #modal {
            width: 80%;
            max-width: 300px;
        }
        
        .dt-buttons {
            justify-content: center;
            width: 100%;
        }
        
        .dt-button {
            font-size: 0.75rem !important;
        }
        
        .dataTables_filter {
            text-align: center !important;
            margin: 10px 0 !important;
            width: 100% !important;
        }
        
        .dataTables_filter input {
            width: 85% !important;
            margin-left: 0 !important;
            display: inline-block !important;
        }
        
        .dataTables_info, .dataTables_paginate {
            text-align: center !important;
            width: 100% !important;
            margin-top: 10px !important;
        }
        
        .dataTables_length {
            text-align: center !important;
            width: 100% !important;
            margin-bottom: 10px !important;
        }
        
        .dataTables_paginate .paginate_button {
            padding: 0.3rem 0.5rem !important;
        }
    }
    
    /* Ajustes específicos para celulares */
    @media (max-width: 575.98px) {
        h2 {
            font-size: 1.5rem;
        }
        
        .dt-button {
            padding: 3px 6px !important;
            font-size: 0.7rem !important;
        }
        
        .dataTables_length select {
            width: 60px !important;
        }
        
        .dataTables_paginate .paginate_button {
            padding: 0.2rem 0.4rem !important;
        }
        
        /* Melhorar visualização em formato de cards para mobile */
        .dtr-details {
            width: 100%;
            padding: 8px;
        }
        
        .dtr-title {
            font-weight: bold;
            margin-right: 5px;
        }
    }
</style>

<body>
<div class="container mt-4">
    <div class="col-12 text-center mb-3">
        <button type="button" class="btn btn-outline-primary texte-center" data-bs-toggle="modal" data-bs-target="#exampleModal" id="modal">Cadastrar Marca</button>
    </div>

    <div class="mt-4">
        <h2 class="text-center mb-3">Lista de Marcas</h2>

        <div class="table-responsive-container">
            <table class="table table-striped table-hover display nowrap" id="tabelaMarcas" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Marca</th>
                        <th scope="col">Data de Cadastro</th>
                        <th scope="col">Usuário</th>
                        <th scope="col" style="text-align:center;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($marcas as $marca) { ?>
                        <tr>
                            <td data-title="ID"><?php echo $marca['idMarca']; ?></td>
                            <td data-title="Marca"><?php echo $marca['descricaoMarca']; ?></td>
                            <td data-title="Data"><?php echo date("d/m/Y H:i:s", strtotime($marca['dataCadastro'])); ?></td>
                            <td data-title="Usuário"><?php echo $marca['usuarioCadastro']; ?></td>
                            <td data-title="Ações">
                                <div class="acoes">
                                    <div class="muda_status">
                                        <?php
                                        if ($marca['statusMarca'] == "S") {
                                        ?>
                                            <div class="inativo" onclick="muda_status('N','<?php echo $marca['idMarca']; ?>')">
                                                <i class="bi bi-toggle-on text-success"></i>
                                            </div>
                                        <?php
                                        } else {
                                        ?>
                                            <div class="ativo" onclick="muda_status('S', '<?php echo $marca['idMarca']; ?>')">
                                                <i class="bi bi-toggle-off text-secondary"></i>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="edit" onclick="edita('<?php echo $marca['idMarca']; ?>')">
                                        <i class="bi bi-pencil-square text-primary"></i>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <input type="hidden" id="idMarca" name="idMarca">
    </div>
</div>

<!-- Scripts carregados ao final para melhor performance -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<!-- Script aprimorado para configuração do DataTables e responsividade -->
<script>
    $(document).ready(function () {
        // Configurações para evitar erros e melhorar desempenho
        $.fn.dataTable.ext.errMode = 'none';
        
        // Detectar se estamos em dispositivo móvel
        const isMobile = window.innerWidth < 768;
        
        // Configuração da tabela com responsividade aprimorada
        const table = $('#tabelaMarcas').DataTable({
            responsive: {
                details: {
                    type: isMobile ? 'column' : 'inline',
                    target: 'tr',
                    renderer: function(api, rowIdx, columns) {
                        // Renderização customizada para melhor exibição em dispositivos móveis
                        let data = $.map(columns, function(col, i) {
                            return col.hidden ? 
                                '<tr data-dt-row="' + col.rowIndex + '" data-dt-column="' + col.columnIndex + '">' +
                                    '<td class="dtr-title">' + col.title + ':</td> ' +
                                    '<td class="dtr-data">' + col.data + '</td>' +
                                '</tr>' :
                                '';
                        }).join('');
                        
                        return data ? 
                            $('<table class="table table-sm table-bordered dtr-details" width="100%"/>').append(data) :
                            false;
                    }
                }
            },
            autoWidth: false,
            scrollX: false,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json',
                info: "Exibindo _START_ a _END_ de _TOTAL_ registros",
                infoEmpty: "Nenhum registro disponível",
                infoFiltered: "(filtrado de _MAX_ registros totais)",
                lengthMenu: "_MENU_ por página",
                search: "Buscar:",
                zeroRecords: "Nenhum registro encontrado",
                paginate: {
                    first: "Primeira",
                    last: "Última",
                    next: "Próxima",
                    previous: "Anterior"
                },
                aria: {
                    sortAscending: ": ordenar colunas de forma ascendente",
                    sortDescending: ": ordenar colunas de forma descendente"
                }
            },
            // Layout otimizado para responsividade
            dom: isMobile ? 
                "<'row'<'col-12'B>><'row'<'col-12'f>><'row'<'col-12'tr>><'row'<'col-12'l>><'row'<'col-12'p>>" : 
                "<'row'<'col-sm-6'B><'col-sm-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-5'l><'col-sm-7'p>>",
            buttons: [
                {
                    extend: 'copy',
                    className: 'btn btn-sm btn-outline-secondary',
                    text: 'Copiar',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                },
                {
                    extend: 'csv',
                    className: 'btn btn-sm btn-outline-secondary',
                    text: 'CSV',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                },
                {
                    extend: 'excel',
                    className: 'btn btn-sm btn-outline-secondary',
                    text: 'Excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                },
                {
                    extend: 'pdf',
                    className: 'btn btn-sm btn-outline-secondary',
                    text: 'PDF',
                    orientation: 'landscape',
                    pageSize: 'A4',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                },
                {
                    extend: 'print',
                    className: 'btn btn-sm btn-outline-secondary',
                    text: 'Imprimir',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                }
            ],
            pageLength: 6,
            lengthMenu: [[6, 10, 25, 50, -1], [6, 10, 25, 50, "Todos"]],
            order: [[0, 'asc']],
            columnDefs: [
                {
                    responsivePriority: 1,
                    targets: [0, 1] // ID e Marca são prioritários
                },
                {
                    responsivePriority: 2,
                    targets: 4 // Ações são secundárias em prioridade
                },
                {
                    responsivePriority: 3,
                    targets: [2, 3] // Data e Usuário têm menor prioridade
                }
            ],
            // Ajuste completo após inicialização
            initComplete: function() {
                // Timeout escalonados para garantir que os elementos estejam renderizados
                setTimeout(function() {
                    $(window).trigger('resize');
                }, 200);
                
                setTimeout(function() {
                    table.columns.adjust().responsive.recalc();
                }, 400);
            }
        });
        
        // Garantir responsividade em dispositivos táteis
        if ('ontouchstart' in window) {
            const contentWidth = document.querySelector('.table-responsive-container').offsetWidth;
            if (contentWidth < table.table().node().offsetWidth) {
                $('.table-responsive-container').css();
            }
        }
        
        // Ajuste do layout em redimensionamento
        $(window).on('resize orientationchange', function() {
            clearTimeout(window.resizedFinished);
            window.resizedFinished = setTimeout(function() {
                table.columns.adjust().responsive.recalc();
                
                // Ajustes específicos para mobile
                const isMobileNow = window.innerWidth < 768;
                if (isMobileNow !== isMobile) {
                    // Recarregar página se mudar drasticamente de tamanho para 
                    // garantir que a configuração correta seja usada
                    location.reload();
                }
            }, 250);
        });
    });
</script>

<script src="../js/marcas.js"></script>
<script src="../js/theme.js"></script>
</body>