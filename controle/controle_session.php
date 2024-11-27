<?php
session_start();
if (!isset($_SESSION['controle_login']) || $_SESSION['controle_login'] !== true) {
    header('Location: ../visao/login.php?erro=sem_acesso');
    exit();
}
?>