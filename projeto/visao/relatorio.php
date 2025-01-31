<?php
include_once('../controle/controle_session.php');
include_once('../modelo/conexao.php');
include_once('../controle/funcoes.php');
$title = "Relatórios";
include_once('senac.html');
include_once('navbar.php');

$marcas = busca_info_bd($conexao, 'marca');
$tipos = busca_info_bd($conexao, 'tipo');
$ativos = busca_info_bd($conexao, 'ativo');
$usuarios = busca_info_bd($conexao, 'usuario');
$movimentacoes = busca_info_bd($conexao, 'movimentacao');

?>

<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center" style="color: #003B5C;">Informe os filtros que deseja gerar o relatório</h1>
        <form method="POST" action="relatorio.php" class="bg-light p-4 rounded shadow-sm">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="ativo" class="form-label" style="color: #003B5C;">Ativo</label>
                    <select id="ativo" name="ativo" class="form-select shadow-sm border-light">
                        <option value="todos">Todos Alvos</option>
                        <?php
                        foreach ($ativos as $ativo) {
                            echo '<option value="' . $ativo['idAtivo'] . '">' . $ativo['descricaoAtivo'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="marca" class="form-label" style="color: #003B5C;">Marca</label>
                    <select id="marca" name="marca" class="form-select shadow-sm border-light">
                        <option value="todas">Todas Marcas</option>
                        <?php
                        foreach ($marcas as $marca) {
                            echo '<option value="' . $marca['idMarca'] . '">' . $marca['descricaoMarca'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="tipo" class="form-label" style="color: #003B5C;">Tipo</label>
                    <select id="tipo" name="tipo" class="form-select shadow-sm border-light">
                        <option value="todos">Todos Tipos</option>
                        <?php
                        foreach ($tipos as $tipo) {
                            echo '<option value="' . $tipo['idTipo'] . '">' . $tipo['descricaoTipo'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="usuario" class="form-label" style="color: #003B5C;">Usuário responsável</label>
                    <select id="usuario" name="usuario" class="form-select shadow-sm border-light">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($usuarios as $usuario) {
                            echo '<option value="' . $usuario['idUsuario'] . '">' . $usuario['nomeUsuario'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="data_inicial" class="form-label" style="color: #003B5C;">Data Inicial</label>
                    <input type="date" id="data_inicial" name="data_inicial" class="form-control shadow-sm border-light">
                </div>
                <div class="col-md-6">
                    <label for="data_final" class="form-label" style="color: #003B5C;">Data Final</label>
                    <input type="date" id="data_final" name="data_final" class="form-control shadow-sm border-light">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="tipo_movimentacao" class="form-label" style="color: #003B5C;">Tipo de Movimentação</label>
                    <select id="tipo_movimentacao" name="tipo_movimentacao" class="form-select shadow-sm border-light">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($movimentacoes as $movimentacao) {
                            echo '<option value="' . $movimentacao['idMovimentacao'] . '">' . $movimentacao['tipoMov'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary" style="background-color: #003B5C; color: white;">Gerar Relatório</button>
                <button type="reset" class="btn btn-secondary">Limpar Filtros</button>
            </div>
        </form>
    </div>
</body>