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

<script src="../js/tipos.js"></script>

<body>
<div class="d-flex justify-content-center mt-4">
    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" id="modal">Cadastrar Tipo</button>
</div>

<div class=" mt-5">
    <h2 class="container mt-4">Lista de Tipos</h2>

    <div class="container mt-4">    <table class="table table-striped mt-4" id="tabelaTipos">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Tipo</th>
                <th scope="col">Data de Cadastro</th>
                <th scope="col">Usuário</th>
                <th style="text-align:center;">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tipos as $tipo) { ?>
                <tr>
                    <td><?php echo $tipo['idTipo']; ?></td>
                    <td><?php echo $tipo['descricaoTipo']; ?></td>
                    <td><?php echo date("d/m/Y H:i:s", strtotime($tipo['dataCadastro'])); ?></td>
                    <td><?php echo $tipo['usuarioCadastro']; ?></td>
                    <td>
                        <div class="acoes" style="display: flex; justify-content: space-between">
                            <div class="muda_status">
                                <?php
                                if ($tipo['statusTipo'] == "S") {
                                ?>
                                    <div class="inativo" onclick="muda_status('N','<?php echo $tipo['idTipo']; ?>')">
                                        <i class="bi bi-toggle-on"></i>
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <div class="ativo" onclick="muda_status('S', '<?php echo $tipo['idTipo']; ?>')">
                                        <i class="bi bi-toggle-off"></i>
                                    </div>
                                <?php
                                }
                                ?>
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
    <input type="hidden" id="idTipo" name="idTipo">
</div>

<!-- Script para inicializar o DataTables com botões -->
<script>
    $(document).ready(function () {
        $('#tabelaTipos').DataTable({
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
</body>