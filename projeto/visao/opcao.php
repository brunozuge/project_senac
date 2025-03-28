<?php
include_once('../controle/controle_session.php');
include_once('../controle/controle_opcao.php');
include_once('../modelo/conexao.php');
include_once('../controle/funcoes.php');
$opcoes = busca_info_bd($conexao, 'opcoes_menu');
$title = "Opções";
include_once("senac.html");
include_once('modal_opcoes.php');
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

<script src="../js/opcoes.js"></script>
<!-- Inclua o script no final do <body> -->
<script src="theme.js"></script>
<body>
<div class="d-flex justify-content-center mt-4">
    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" id="modal">Cadastrar Opção</button>
</div>

<div class=" mt-5">
    <h2 class="mt-4">Lista de Opções</h2>
    <!-- Tabela com as opções -->
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
            <?php foreach ($opcoes as $opcao) { ?>
                <tr>
                    <td><?php echo $opcao['idOpcao']; ?></td>
                    <td><?php echo $opcao['descricaoOpcao']; ?></td>
                    <td><?php echo date("d/m/Y H:i:s", strtotime($opcao['dataCadastro'])); ?></td>
                    <td><?php echo $opcao['idUsuario']; ?></td>
                    <td>
                        <div class="acoes" style="display: flex; justify-content: space-between">
                            <div class="muda_status">
                                <?php
                                if ($opcao['statusOpcao'] == "S") {
                                ?>
                                    <div class="inativo" onclick="muda_status('N','<?php echo $opcao['idOpcao']; ?>')">
                                        <i class="bi bi-toggle-on"></i>
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <div class="ativo" onclick="muda_status('S', '<?php echo $opcao['idOpcao']; ?>')">
                                        <i class="bi bi-toggle-off"></i>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                            <div class="edit" onclick="edita('<?php echo $opcao['idOpcao']; ?>')">
                                <i class="bi bi-pencil-square"></i>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <input type="hidden" id="idOpcao" name="idOpcao">
</div>

<!-- Script para inicializar o DataTables com botões -->
<script>
    $(document).ready(function () {
        $('#tabelaOpcoes').DataTable({
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