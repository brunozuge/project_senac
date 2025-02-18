<?php
// config.php
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurações</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        /* Variáveis de cores */
        :root {
            --primaria: #002f6c;
            --secundaria: #ff6600;
            --fundo-claro: #f5f5f5;
            --texto-escuro: #333;
            --fundo-escuro: #121212;
            --texto-claro: #ffffff;
        }

        /* Estilo global para o tema claro */
        body {
            background-color: var(--fundo-claro);
            color: var(--texto-escuro);
            font-family: Arial, sans-serif;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Estilo global para o tema escuro */
        body.dark-mode {
            background-color: var(--fundo-escuro);
            color: var(--texto-claro);
        }

        /* Navbar no modo escuro */
        body.dark-mode .navbar {
            background-color: #1e1e1e;
        }

        /* Tabela no modo escuro */
        body.dark-mode .table {
            background-color: #1e1e1e;
            color: var(--texto-claro);
        }

        body.dark-mode .table th {
            background-color: #333;
            color: var(--texto-claro);
        }

        /* Botões no modo escuro */
        body.dark-mode .btn-outline-primary {
            border-color: var(--texto-claro);
            color: var(--texto-claro);
        }

        body.dark-mode .btn-outline-primary:hover {
            background-color: var(--texto-claro);
            color: var(--primaria);
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2><i class="bi bi-gear"></i> Configurações</h2>
        <p>Aqui você pode ajustar suas preferências.</p>

        <!-- Botão para alternar o tema -->
        <button id="toggle-theme-settings" class="btn btn-outline-primary w-100">
            <i id="theme-icon-settings" class="bi bi-moon"></i> Alterar Tema
        </button>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script para alternar o tema e redirecionar -->
    <script>
        // Função para alternar o tema
        function toggleTheme() {
            const body = document.body;
            const themeIconSettings = document.getElementById('theme-icon-settings');

            if (body.classList.contains('dark-mode')) {
                // Alterna para o tema claro
                body.classList.remove('dark-mode');
                themeIconSettings.classList.remove('bi-sun');
                themeIconSettings.classList.add('bi-moon');
                localStorage.setItem('theme', 'light'); // Salva a preferência
            } else {
                // Alterna para o tema escuro
                body.classList.add('dark-mode');
                themeIconSettings.classList.remove('bi-moon');
                themeIconSettings.classList.add('bi-sun');
                localStorage.setItem('theme', 'dark'); // Salva a preferência
            }

            // Redireciona para a página inicio.php após 1 segundo
            setTimeout(() => {
                window.location.href = 'inicio.php';
            }, 1000); // 1000ms = 1 segundo
        }

        // Adiciona o evento de clique ao botão
        document.getElementById('toggle-theme-settings').addEventListener('click', toggleTheme);

        // Carregar o tema salvo ao carregar a página
        document.addEventListener('DOMContentLoaded', () => {
            const savedTheme = localStorage.getItem('theme');
            const body = document.body;
            const themeIconSettings = document.getElementById('theme-icon-settings');

            if (savedTheme === 'dark') {
                body.classList.add('dark-mode');
                themeIconSettings.classList.remove('bi-moon');
                themeIconSettings.classList.add('bi-sun');
            } else {
                body.classList.remove('dark-mode');
                themeIconSettings.classList.remove('bi-sun');
                themeIconSettings.classList.add('bi-moon');
            }
        });
    </script>
</body>
</html>