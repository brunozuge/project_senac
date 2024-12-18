<?php
// Configuração de conexão com o banco de dados
$host = 'localhost';
$user = 'root';
$password = ''; // Substitua pela sua senha
$dbname = 'bd_farmacia';

// Criando conexão com o banco de dados
$conn = new mysqli($host, $user, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Exemplo de consulta: Listar todas as categorias
$sql = "SELECT * FROM categoria";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row['idCategoria'] . " - Descrição: " . $row['descricaoCategoria'] . "<br>";
    }
} else {
    echo "Nenhum registro encontrado.";
}

// Fechando conexão
$conn->close();
?>
