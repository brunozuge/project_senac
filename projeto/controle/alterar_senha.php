<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Senha</title>
    <script src="usuario.js" defer></script>
</head>
<body>
    <h1>Alterar Senha</h1>
    <form action="alterar_senha.php" method="POST" onsubmit="return validarSenha()">
        <label for="senhaAtual">Senha Atual:</label>
        <input type="password" id="senhaAtual" name="senhaAtual" required><br><br>

        <label for="novaSenha">Nova Senha:</label>
        <input type="password" id="novaSenha" name="novaSenha" required><br><br>

        <label for="confirmarSenha">Confirmar Nova Senha:</label>
        <input type="password" id="confirmarSenha" name="confirmarSenha" required><br><br>

        <button type="submit">Alterar Senha</button>
    </form>
</body>
</html>