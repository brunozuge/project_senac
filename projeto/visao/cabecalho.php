<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar e Cabeçalho</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Estilos personalizados */
        :root {
            --cor-primaria: #002f6c;
            --cor-secundaria: #ff6600;
        }

        body {
            font-family: Arial, sans-serif;
            margin-top: 0;
        }

        /* Navbar */
        .navbar {
            background-color: var(--cor-primaria);
        }

        .navbar .navbar-brand img {
            height: 40px;
        }

        .navbar .nav-link {
            color: white !important;
            font-weight: bold;
        }

        .navbar .nav-link:hover {
            color: var(--cor-secundaria) !important;
        }

        .navbar .nav-item.active .nav-link {
            color: var(--cor-secundaria) !important;
        }

        /* Botões */
        .btn {
            font-size: 18px;
            padding: 12px 30px;
            background-color: var(--cor-primaria);
            color: white;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 20px;
        }

        .btn:hover {
            background-color: var(--cor-secundaria);
        }

        /* Dropdown menu */
        .navbar-nav .dropdown-menu {
            background-color: var(--cor-primaria);
        }

        .navbar-nav .dropdown-item {
            color: white;
        }

        .navbar-nav .dropdown-item:hover {
            background-color: var(--cor-secundaria);
        }
    </style>
</head>
<body>



<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>