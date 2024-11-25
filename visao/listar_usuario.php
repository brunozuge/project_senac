<?php
session_start(); // Inicia a sessão

// Verifica se o usuário não está logado
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: login.php"); // Redireciona para o login se não estiver logado
    exit;
}
?>


</head>
<body>
<?php 
include_once ('navbar.php');
include_once ('senac.html');
?>
<?php
// Incluindo a conexão e funções
include ('../modelo/conexao.php');
include ('../controle/funcoes.php');

// Buscando todos os usuários para exibir
$sql = "SELECT * FROM usuario";
$result = $conexao->query($sql);
?>

<div class="container mt-5">
    <h2>Listagem de Usuários</h2>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Turma</th>
                <th>Ações</th> <!-- Coluna para as ações (Alterar, Excluir) -->
            </tr>
        </thead>
        <tbody>
            <?php while ($usuario = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $usuario['idUsuario']; ?></td>
                    <td><?php echo $usuario['nomeUsuario']; ?></td>
                    <td><?php echo $usuario['turmaUsuario']; ?></td>
                    <td>
                        <!-- Botão de Alterar -->
                        <a href="alterar_usuario.php?id_usuario=<?php echo $usuario['idUsuario']; ?>" class="btn btn-warning btn-sm">Alterar</a>
                        
                        <!-- Botão de Excluir -->
                        <a href="excluir_usuario.php?id_usuario=<?php echo $usuario['idUsuario']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este usuário?');">Excluir</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

            
        </tbody>
    </table>
</div>

</body>
</html>
