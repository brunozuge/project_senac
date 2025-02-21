<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: rgb(0, 47, 108);">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="inicio.php">
            <img src="https://www.mg.senac.br/programasenacdegratuidade/assets/img/senac_logo_branco.png" alt="Logo SENAC" style="height: 40px;">
        </a>
        <!-- Botão para dispositivos móveis -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Alternar navegação">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Links do menu -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <!-- Links padrão -->
                <li class="nav-item"><a class="nav-link" href="inicio.php">Início</a></li>
                <li class="nav-item"><a class="nav-link" href="marcas.php">Marca</a></li>
                <li class="nav-item"><a class="nav-link" href="ativos.php">Ativo</a></li>
                <li class="nav-item"><a class="nav-link" href="movimentacoes.php">Movimentação</a></li>
                <li class="nav-item"><a class="nav-link" href="tipos.php">Tipo</a></li>
                <li class="nav-item"><a class="nav-link" href="relatorio.php">Relatório</a></li>
                <li class="nav-item"><a class="nav-link" href="busca_prod_ml.php">Reposição</a></li>
                <!-- Dropdown organizado -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="ativosDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Usuário
                    </a>
                    <div class="dropdown-menu" aria-labelledby="ativosDropdown">
                        <a class="dropdown-item" href="listar_usuario.php">Listar Usuários</a>
                        <a class="dropdown-item" href="cadastro.php">Cadastrar Usuários</a>
                    </div>
                </li>
                <!-- Logout -->
                <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Sair</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Botão de Configurações -->
<div class="position-fixed end-0 m-3" style="top: -6px">
    <a href="config.php" class="btn btn-primary btn-sm rounded-circle shadow">
        <i class="bi bi-gear"></i>
    </a>
</div>