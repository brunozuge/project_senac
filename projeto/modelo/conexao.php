<?php
// Configurações do banco de dados
$servidor = "localhost";  // Endereço do servidor (localhost ou IP)
$usuario = "root";        // Nome de usuário do banco de dados (ajuste conforme seu ambiente)
$senha = "";              // Senha do banco de dados (vazia no XAMPP por padrão)
$banco = "ativo";         // Nome do banco de dados

// Cria a conexão com o banco de dados
$conexao = new mysqli($servidor, $usuario, $senha, $banco);

// Verifica se houve erro na conexão
if ($conexao->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conexao->connect_error);
}

// O script não deve exibir mensagem de sucesso em produção para evitar informações desnecessárias
?>