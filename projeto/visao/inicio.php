<?php 
include_once("senac.html");
?>
<!-- Inclua o script no final do <body> -->
<script src="theme.js"></script>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Início</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Estilo global para o tema escuro */
        body.dark-mode {
            background-color: var(--fundo-escuro);
            color: var(--texto-claro);
        }

        /* Navbar */
        .navbar {
            background-color: var(--primaria);
            padding: 10px 20px;
            transition: background-color 0.3s ease;
        }

        /* Logo centralizada */
        .navbar-brand {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        .navbar-brand img {
            height: 40px;
        }

        /* Botão Sair */
        .btn-sair {
            background-color: var(--secundaria);
            border: none;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn-sair:hover {
            background-color: #e65c00; /* Um tom mais escuro da cor secundária */
            transform: scale(1.05); /* Efeito de crescimento ao passar o mouse */
        }

        /* Navbar no modo escuro */
        body.dark-mode .navbar {
            background-color: #1e1e1e;
        }

        body.dark-mode .btn-sair {
            background-color: var(--texto-claro);
            color: var(--primaria);
        }

        body.dark-mode .btn-sair:hover {
            background-color: #ccc;
        }

        /* Seção Hero */
        .hero {
            background-color: var(--primaria);
            color: white;
            padding: 50px 20px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        /* Seção Hero no modo escuro */
        body.dark-mode .hero {
            background-color: #333;
        }

        /* Seção de Recursos */
        .features {
            margin-top: 30px;
            flex-grow: 1;
        }

        .features .feature-item {
            text-align: center;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .features .feature-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .features .feature-item a {
            text-decoration: none;
            color: var(--primaria);
        }

        .features .feature-item a:hover {
            color: var(--secundaria);
        }

        .features .feature-item i {
            font-size: 40px;
            color: var(--primaria);
            margin-bottom: 10px;
        }

        /* Seção de Recursos no modo escuro */
        body.dark-mode .features .feature-item {
            background-color: #333;
            color: var(--texto-claro);
        }

        body.dark-mode .features .feature-item a {
            color: var(--texto-claro);
        }

        body.dark-mode .features .feature-item a:hover {
            color: var(--secundaria);
        }

        body.dark-mode .features .feature-item i {
            color: var(--texto-claro);
        }

        /* Rodapé */
        .footer {
            background-color: var(--primaria);
            color: white;
            text-align: center;
            padding: 10px 0;
            transition: background-color 0.3s ease;
        }

        /* Rodapé no modo escuro */
        body.dark-mode .footer {
            background-color: #1e1e1e;
        }
    </style>
</head>
<body>
    <!-- Navbar com a logo -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <!-- Logo centralizada -->
            <a class="navbar-brand" href="inicio.php">
                <img src="https://www.mg.senac.br/programasenacdegratuidade/assets/img/senac_logo_branco.png" alt="Logo SENAC">
            </a>
            <!-- Botão de logout alinhado à direita -->
            <div class="ml-auto">
                <a href="logout.php" class="btn btn-sair">Sair</a>
            </div>
        </div>
    </nav>

    <!-- Seção Hero -->
    <div class="hero">
        <h1>Bem-vindo ao Sistema de Gestão SENAC</h1>
        <p>Gerencie usuários, cadastros e movimentações de forma eficiente e segura.</p>
    </div>

    <!-- Seção de Recursos -->
    <div class="container features">
        <div class="row">
            <div class="col-md-4">
                <div class="feature-item">
                    <a href="cadastro.php">
                        <i class="fas fa-user-plus"></i>
                        <h4>Cadastrar Usuários</h4>
                        <p>Adicione novos usuários ao sistema rapidamente.</p>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-item">
                    <a href="tipos.php">
                        <i class="fas fa-cogs"></i>
                        <h4>Gerenciar Tipos</h4>
                        <p>Monitore e cadastre os tipos com facilidade.</p>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-item">
                    <a href="marcas.php">
                        <i class="fas fa-cogs"></i>
                        <h4>Gerenciar Marcas</h4>
                        <p>Monitore e cadastre as marcas com facilidade.</p>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-item">
                    <a href="listar_usuario.php">
                        <i class="fas fa-list"></i>
                        <h4>Listar Usuários</h4>
                        <p>Veja todos os usuários cadastrados no sistema.</p>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-item">
                    <a href="ativos.php">
                        <i class="fas fa-cogs"></i>
                        <h4>Gerenciar Ativos</h4>
                        <p>Monitore e cadastre os ativos com facilidade.</p>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-item">
                    <a href="movimentacoes.php">
                        <i class="fas fa-list"></i>
                        <h4>Gerenciar Movimentações</h4>
                        <p>Monitore as movimentações com facilidade.</p>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-item">
                    <a href="relatorio.php">
                        <i class="fas fa-cogs"></i>
                        <h4>Gerenciar Relatórios</h4>
                        <p>Monitore e cadastre os relatórios com facilidade.</p>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Rodapé -->
    <footer class="footer">
        <p>&copy; 2025 SENAC - Todos os direitos reservados.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <!-- Inclua o script de tema -->
    <script src="../js/theme.js"></script>
    <div class="position-fixed end-0 m-3" style="top: -6px">
    <a href="config.php" class="btn btn-primary btn-sm rounded-circle shadow">
        <i class="bi bi-gear"></i>
    </a>
</div>
</body>
</html>