<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Usuários</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <style>
        .table-responsive {
            overflow-x: auto;
        }
        @media (max-width: 768px) {
            .btn-sm {
                padding: 0.25rem 0.4rem;
                font-size: 0.75rem;
            }
            h2 {
                font-size: 1.8rem;
                margin-bottom: 1rem;
            }
            .action-buttons {
                display: flex;
                flex-direction: column;
                gap: 5px;
            }
        }
    </style>
</head>
<body>
    <?php
    session_start(); // Inicia a sessão
    
    // Verifica se o usuário não está logado
    if (!isset($_SESSION['usuario_logado'])) {
        header("Location: login.php"); // Redireciona para o login se não estiver logado
        exit;
    }
    
    include_once('navbar.php');
    include_once('senac.html');
    $admin = $_SESSION['admin'];
    
    // Incluindo a conexão e funções
    include('../modelo/conexao.php');
    include('../controle/funcoes.php');
    
    // Buscando todos os usuários para exibir
    $sql = "SELECT * FROM usuario";
    $result = $conexao->query($sql);
    ?>
    
    <div class="container mt-5">
        <h2 class="mb-4">Listagem de Usuários</h2>
        
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Turma</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($usuario = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $usuario['idUsuario']; ?></td>
                            <td><?php echo $usuario['nomeUsuario']; ?></td>
                            <td><?php echo $usuario['turmaUsuario']; ?></td>
                            <td>
                                <?php if ($admin == "S") { ?>
                                    <div class="action-buttons">
                                        <a href="alterar_usuario.php?id_usuario=<?php echo $usuario['idUsuario']; ?>" class="btn btn-warning btn-sm">Alterar</a>
                                        <a href="excluir_usuario.php?id_usuario=<?php echo $usuario['idUsuario']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este usuário?');">Excluir</a>
                                    </div>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/theme.js"></script>
</body>
</html>