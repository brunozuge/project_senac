<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuário</title>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Estilos customizados */
        :root {
            --primaria: #002f6c;
            --secundaria: #ff6600;
        }
        
        body {
            background-color: #f5f5f5;
            color: #333;
        }
        
        .navbar {
            background-color: var(--primaria);
            position: relative;
        }

        .navbar .navbar-brand img {
            position: absolute;
            top: 10px;
            left: 10px;
            height: 40px;
        }
        
        .navbar .navbar-brand, .navbar .nav-link {
            color: white !important;
        }
        
        .navbar .nav-link:hover {
            color: var(--secundaria) !important;
        }
        
        h2 {
            color: var(--primaria);
            border-bottom: 2px solid var(--secundaria);
            margin-bottom: 20px;
        }
        
        button, .btn-primary {
            background-color: var(--secundaria);
            border: none;
            color: white;
            padding: 10px 20px;
            font-size: 1rem;
            border-radius: 5px;
        }
        
        .form-group label {
            font-weight: bold;
            color: var(--primaria);
        }
        
        .form-group input[type="text"],
        .form-group input[type="password"] {
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <!-- Menu de Navegação -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <!-- Logo do SENAC -->
                <img src="https://www.mg.senac.br/programasenacdegratuidade/assets/img/senac_logo_branco.png" alt="Logo SENAC">
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="cadastro.php">Cadastro</a></li>
                    <li class="nav-item"><a class="nav-link" href="listar_usuario.php">Listar</a></li>
                
                    <li class="nav-item"><a class="nav-link text-white" href="login.php">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Cadastro de Usuário</h2>
        <form action="../controle/cadastrar_usuario_controle.php" method="POST">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite seu nome" required>
            </div>
            <div class="form-group">
                <label for="usuario">Usuário:</label>
                <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Digite seu usuário" required>
            </div>
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite sua senha" required>
            </div>
            <div class="form-group">
                <label for="turma">Turma:</label>
                <input type="text" class="form-control" id="turma" name="turma" placeholder="Digite sua turma" required>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>
</body>
</html>
