<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Listar Usuário</title>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Estilos customizados */
        :root {
            --primaria: #002f6c;
            --secundaria: #ff6600;
            --fundo-claro: #f5f5f5;
            --texto-escuro: #333;
        }
        
        body {
            background-color: var(--fundo-claro);
            color: var(--texto-escuro);
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
        
        .table {
            background-color: white;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .table th {
            background-color: var(--primaria);
            color: white;
        }
        
        .table td a {
            color: var(--primaria);
        }
        
        .table td a:hover {
            color: var(--secundaria);
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

    <div class="container mt-4">
        <h2>Listar Usuário</h2>
        <table class="table">
            <thead>
             
            </thead>
            <tbody>
            <?php
include ('../modelo/conexao.php');

// Consultando os usuários no banco de dados
$query = "SELECT idUsuario, nomeUsuario, turmaUsuario FROM usuario";
$result = $conexao->query($query);

if ($result->num_rows > 0) {
    echo "<table class='table'>";
    echo "<thead><tr><th>ID</th><th>Nome</th><th>Turma</th><th>Ações</th></tr></thead>";
    echo "<tbody>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['idUsuario'] . "</td>";
        echo "<td>" . $row['nomeUsuario'] . "</td>";
        echo "<td>" . $row['turmaUsuario'] . "</td>";
        echo "<td><a href='alterar_usuario.php?id_usuario=" . $row['idUsuario'] . "' class='btn btn-warning btn-sm'>Alterar</a> ";
        echo "<a href='excluir_usuario.php?id_usuario=" . $row['idUsuario'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Tem certeza que deseja excluir este usuário?\");'>Excluir</a></td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
} else {
    echo "<p>Nenhum usuário encontrado.</p>";
}

$conexao->close();
?>

            </tbody>
        </table>
    </div>
</body>
</html>
