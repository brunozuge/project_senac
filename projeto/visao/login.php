<?php
session_start();
if (isset($_SESSION['erro'])) {
    echo "<div class='alert alert-danger'>" . htmlspecialchars($_SESSION['erro']) . "</div>";
    unset($_SESSION['erro']);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login de Usuário</title>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Reset de margens e fonte global */
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        /* Fundo do formulário de login */
        .login-background {
            background-image: url('https://api.senacrs.com.br/bff/site-senac/v1/file/07c9f01657a6a3ad9c8d44d5f5903407774768.png');
            background-size: cover;
            background-position: center;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Estilos da área de formulário */
        .form-container {
            background-color: rgba(255, 255, 255, 0.9); /* Fundo branco com leve transparência */
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: left;
        }

        /* Estilo da logo */
        .logo {
            display: block;
            margin: 0 auto 40px auto;
            max-width: 200px;
        }

        /* Título do formulário */
        .form-title {
            font-size: 24px;
            color: #003B5C; /* Cor principal do Senac */
            margin-bottom: 20px;
            text-align: center;
        }

        /* Campos de entrada */
        .form-control {
            border-radius: 5px;
            margin-bottom: 15px;
        }

        /* Botão de envio */
        .btn-outline-primary {
            background-color: #003B5C; /* Cor de fundo padrão */
            border: none;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
        }

        .btn-outline-primary:hover {
            background-color: #01579B; /* Cor ao passar o mouse */
        }

        /* Link de cadastro */
        .cadastro-link {
            display: block;
            text-align: center;
            margin-top: 10px;
        }

        .cadastro-link a {
            color: #003B5C;
            text-decoration: none;
            font-weight: bold;
        }

        .cadastro-link a:hover {
            text-decoration: underline;
        }

        /* Rodapé */
        .footer {
            background-color: #f0f0f0;
            padding: 15px 0;
            text-align: center;
            color: #333;
        }

        .footer .text-muted {
            font-size: 14px;
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .form-container {
                padding: 30px;
                max-width: 90%;
            }
        }
    </style>
</head>
<body>

    <!-- Fundo e formulário de login -->
    <div class="login-background">
        <div class="form-container">
            <h2 class="form-title">Login de Usuário</h2>
            <form action="../controle/processa_login.php" method="POST">
                <div class="form-group">
                    <label for="usuario">Usuário:</label>
                    <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Digite seu usuário" required>
                </div>
                <div class="form-group">
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" class="form-control" placeholder="Digite sua senha" required>
                </div>
               
                <button type="submit" class="btn btn-outline-primary">Entrar</button>
            </form>
            
            <!-- Link para página de cadastro -->
            <div class="cadastro-link">
                <p>Não tem uma conta? <a href="cadastro.php">Cadastre-se aqui</a></p>
            </div>
        </div>
    </div>

    <!-- Rodapé -->
    <footer class="footer">
        <div class="container">
            <span class="text-muted">© 2024 SENAC. Todos os direitos reservados.</span>
        </div>
    </footer>
</body>
</html>