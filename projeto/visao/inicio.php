<?php 
include_once("senac.html");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Início</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Estilos customizados */
        body {
            background-color: #f5f5f5;
            color: #333;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .navbar {
            background-color: #002f6c;
            padding: 10px 20px;
        }

        .navbar-brand img {
            height: 50px;
        }

        .hero {
            background-color: #002f6c;
            color: white;
            padding: 50px 20px;
            text-align: center;
        }

        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 1.2rem;
        }

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
            color: #002f6c;
        }

        .features .feature-item a:hover {
            color: #ff6600;
        }

        .features .feature-item i {
            font-size: 40px;
            color: #002f6c;
            margin-bottom: 10px;
        }

        .footer {
            background-color: #002f6c;
            color: white;
            text-align: center;
            padding: 10px 0;
        }

        .feature-item {
            min-height: 9rem;
        }
    </style>
</head>
<body>

    <!-- Navbar com a logo -->
    <nav class="navbar navbar-expand-lg ">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="inicio.php">
            <img src="https://www.mg.senac.br/programasenacdegratuidade/assets/img/senac_logo_branco.png" alt="Logo SENAC" style="height: 40px;">
        </a>

        <!-- Botão de logout alinhado à direita -->
        <div class="ml-auto">
            <a href="logout.php" class="btn btn-primary btn-sm" style="background-color: #002f6c; border-color: #002f6c;">Sair</a>
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
</body>
</html>
