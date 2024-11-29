<?php
session_start(); // Inicia a sessão

// Verifica se o usuário não está logado
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: login.php"); // Redireciona para o login se não estiver logado
    exit;
}
?>

<?php
include_once('navbar.php');
include_once ('senac.html');



?>
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="../js/ativos.js"></script>

<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Abrir Modal</button>

<?php 

include_once('modal_ativo.php');

?>
