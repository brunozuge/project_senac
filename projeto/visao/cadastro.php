
    
<?php 

include_once ('navbar.php');
include_once ('senac.html');?>
<!-- Inclua o script no final do <body> -->
<script src="theme.js"></script>
<script src="../js/usuario.js"></script>


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
    <!-- Inclua o script de tema -->
<script src="../js/theme.js"></script>

</body>
</html>
