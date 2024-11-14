<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Alterar Usuário</title>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="estilo.css"> <!-- Link para o arquivo CSS -->
</head>
<body>
    <!-- Menu de Navegação -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Sistema de Usuários</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="listar_usuario.php">Listar Usuário</a></li>
                    <li class="nav-item"><a class="nav-link" href="cadastro.php">Cadastro de Usuário</a></li>
                    <head><link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="estilo.css"> <!-- Link para o arquivo CSS -->
                </ul>

            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Alterar Usuário</h2>
        <?php
        include ('../modelo/conexao.php');
        include ('../controle/funcoes.php');
        $usuario_altera = $_GET['id_usuario'];
        $info_bd = busca_info_bd($conexao,'usuario','idUsuario',$usuario_altera);
        foreach($info_bd as $user) {
            $nome = $user['nomeUsuario'];
            $turma = $user['turmaUsuario'];
        }
        ?>
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
