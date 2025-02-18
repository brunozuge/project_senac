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
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <script src="../js/relatorio.js"></script>
    <style>
        /* Variáveis de cores */
        :root {
            --primaria: #002f6c;
            --secundaria: #ff6600;
            --fundo-claro: #f5f5f5;
            --texto-escuro: #333;
            --fundo-escuro: #121212;
            --texto-claro: #ffffff;
        }

        /* Estilo global para o tema claro */
        body {
            background-color: var(--fundo-claro);
            color: var(--texto-escuro);
            font-family: Arial, sans-serif;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Estilo global para o tema escuro */
        body.dark-mode {
            background-color: var(--fundo-escuro);
            color: var(--texto-claro);
        }

        /* Formulário no modo claro */
        .bg-light {
            background-color: white !important;
        }

        /* Formulário no modo escuro */
        body.dark-mode .bg-light {
            background-color: #1e1e1e !important;
            color: var(--texto-claro);
        }

        /* Botões no modo escuro */
        body.dark-mode .btn-primary {
            background-color: var(--texto-claro);
            border-color: var(--texto-claro);
            color: var(--primaria);
        }

        body.dark-mode .btn-primary:hover {
            background-color: var(--primaria);
            color: var(--texto-claro);
        }

        body.dark-mode .btn-secondary {
            background-color: #444;
            border-color: #444;
            color: var(--texto-claro);
        }

        body.dark-mode .btn-secondary:hover {
            background-color: #555;
        }

        /* Títulos no modo claro */
        h1 {
            color: var(--primaria);
        }

        /* Títulos no modo escuro */
        body.dark-mode h1 {
            color: var(--texto-claro);
        }

        /* Inputs e selects no modo escuro */
        body.dark-mode .form-control,
        body.dark-mode .form-select {
            background-color: #333;
            color: var(--texto-claro);
            border-color: #444;
        }

        body.dark-mode .form-control:focus,
        body.dark-mode .form-select:focus {
            background-color: #333;
            color: var(--texto-claro);
            border-color: var(--texto-claro);
            box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.25);
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Informe os filtros que deseja gerar o relatório</h1>
        <form method="POST" action="resultado_relatorios.php" class="bg-light p-4 rounded shadow-sm" target="_blank">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="ativo" class="form-label">Ativo</label>
                    <select id="ativo" name="ativo" class="form-select shadow-sm border-light">
                        <option value="">Todos Alvos</option>
                        <?php
                        foreach ($ativos as $ativo) {
                            echo '<option value="' . $ativo['idAtivo'] . '">' . $ativo['descricaoAtivo'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="marca" class="form-label">Marca</label>
                    <select id="marca" name="marca" class="form-select shadow-sm border-light">
                        <option value="">Todas Marcas</option>
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
                    <label for="tipo" class="form-label">Tipo</label>
                    <select id="tipo" name="tipo" class="form-select shadow-sm border-light">
                        <option value="">Todos Tipos</option>
                        <?php
                        foreach ($tipos as $tipo) {
                            echo '<option value="' . $tipo['idTipo'] . '">' . $tipo['descricaoTipo'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="usuario" class="form-label">Usuário responsável</label>
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
                    <label for="data_inicial" class="form-label">Data Inicial</label>
                    <input type="date" id="data_inicial" name="data_inicial" class="form-control shadow-sm border-light">
                </div>
                <div class="col-md-6">
                    <label for="data_final" class="form-label">Data Final</label>
                    <input type="date" id="data_final" name="data_final" class="form-control shadow-sm border-light">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="tipo_movimentacao" class="form-label">Tipo de Movimentação</label>
                    <select id="tipo_movimentacao" name="tipo_movimentacao" class="form-select shadow-sm border-light">
                    <option value="" disabled selected>Selecione</option>
                        <option value="adicionar">Adicionar</option>
                        <option value="remover">Remover</option>
                        <option value="realocar">Realocar</option>
                    </select>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Gerar Relatório</button>
                <button type="reset" class="btn btn-secondary">Limpar Filtros</button>
            </div>
        </form>
    </div>

    <!-- Script para inicializar o tema -->
    <script src="../js/theme.js"></script>
</body>
</html>