<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Alterar Usuário</title>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Estilos customizados */
        :root {
            --azul-marinho: #002f6c; /* Azul Marinho Senac */
            --laranja: #ff6600; /* Laranja */
            --branco: #ffffff;
            --fundo-claro: #f5f5f5;
            --texto-escuro: #333;
        }

        body {
            background-color: var(--fundo-claro);
            color: var(--texto-escuro);
        }

        .navbar {
            background-color: var(--azul-marinho); /* Azul marinho */
            position: relative;
        }

        .navbar .navbar-brand img {
            position: absolute;
            top: 10px;
            left: 10px;
            height: 40px;
        }

        .navbar .navbar-brand, .navbar .nav-link {
            color: var(--branco) !important; /* Letras brancas */
        }

        .navbar .nav-link:hover {
            color: var(--branco) !important; /* Cor do hover em branco */
        }

        h2 {
            color: var(--azul-marinho);
            border-bottom: 2px solid var(--laranja); /* Linha laranja embaixo do título */
            margin-bottom: 20px;
        }

        .table {
            background-color: white;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th {
            background-color: var(--azul-marinho);
            color: var(--branco);
        }

        .table td a {
            color: var(--azul-marinho);
        }

        .table td a:hover {
            color: var(--azul-marinho);
        }
    </style>
</head>
<body>
    <!-- Menu de Navegação -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="https://www.mg.senac.br/programasenacdegratuidade/assets/img/senac_logo_branco.png" alt="Logo SENAC">
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="cadastro.php">Cadastrar</a></li>
                    <li class="nav-item"><a class="nav-link" href="listar_usuario.php">Listar</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Alterar Usuário</h2>
      
        <?php
        // Incluindo a conexão e funções
        include ('../modelo/conexao.php');
        include ('../controle/funcoes.php');

        // Pegando o ID do usuário da URL
        if (isset($_GET['id_usuario'])) {
            $usuario_altera = $_GET['id_usuario'];
            // Buscando os dados do usuário no banco
            $info_bd = busca_info_bd($conexao, 'usuario', 'idUsuario', $usuario_altera);
            foreach ($info_bd as $user) {
                $nome = $user['nomeUsuario'];
                $turma = $user['turmaUsuario'];
            }
        } else {
            echo "<p>Erro: ID do usuário não encontrado.</p>";
            exit;
        }
        ?>




        <!-- Formulário de Alteração de Usuário -->
        <form action="../controle/alterar_usuario_controle.php" method="POST">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $nome; ?>" required>
            </div>
            <div class="form-group">
                <label for="turma">Turma:</label>
                <input type="text" class="form-control" id="turma" name="turma" value="<?php echo $turma; ?>" required>
            </div>
            <input type="hidden" name="id_usuario" value="<?php echo $usuario_altera; ?>">
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </form>
        
    </div>
</body>
</html>