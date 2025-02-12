<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include necessary files
include_once("../modelo/conexao.php");
include_once("controle_session.php");

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Helper function to sanitize input
function sanitize_input($data, $connection) {
    return mysqli_real_escape_string($connection, htmlspecialchars(trim($data)));
}

// Get POST data and sanitize inputs
$ativo = isset($_POST['ativo']) ? sanitize_input($_POST['ativo'], $conexao) : '';
$marca = isset($_POST['marca']) ? sanitize_input($_POST['marca'], $conexao) : '';
$tipo = isset($_POST['tipo']) ? sanitize_input($_POST['tipo'], $conexao) : '';
$quantidade = isset($_POST['quantidade']) ? intval($_POST['quantidade']) : 0;
$quantidadeMin = isset($_POST['quantidadeMin']) ? sanitize_input($_POST['quantidadeMin'], $conexao) : '';
$observacao = isset($_POST['observacao']) ? sanitize_input($_POST['observacao'], $conexao) : '';
$acao = isset($_POST['acao']) ? sanitize_input($_POST['acao'], $conexao) : '';
$idAtivo = isset($_POST['idAtivo']) ? intval($_POST['idAtivo']) : 0;
$statusAtivo = isset($_POST['status']) ? sanitize_input($_POST['status'], $conexao) : '';
$user = isset($_SESSION['usuario_logado']) ? intval($_SESSION['usuario_logado']) : 0;

// Handle file upload securely
$img = isset($_FILES['imgAtivo']) ? $_FILES['imgAtivo'] : null;
$urlImg = ''; // Variable to store the uploaded image URL
if ($img && $img['error'] === UPLOAD_ERR_OK) {
    // Define the base directory for uploads
    $pasta_base = $_SERVER['DOCUMENT_ROOT'] . "/projeto/imgAtivo/";
    // Create the directory if it doesn't exist
    if (!is_dir($pasta_base)) {
        mkdir($pasta_base, 0755, true); // Create directory with proper permissions
    }
    // Generate a unique file name to avoid overwriting
    $fileName = uniqid() . '_' . basename($img['name']);
    $filePath = $pasta_base . $fileName;
    // Move the uploaded file to the target directory
    if (move_uploaded_file($img['tmp_name'], $filePath)) {
        $urlImg = 'projeto/imgAtivo/' . $fileName; // Save the relative URL of the image
    } else {
        echo json_encode(['error' => 'Falha ao mover arquivo']);
        exit();
    }
}

// Perform actions based on the value of $acao
switch ($acao) {
    case 'inserir':
        // Prepare the SQL query
        $query = "
            INSERT INTO ativo (
                descricaoAtivo,
                quantidadeAtivo,
                  quantidadeMinAtivo,
                statusAtivo,
                observacaoAtivo,
                idMarca,
                idTipo,
                dataCadastro,
                idUsuario,
                urlImg
            ) VALUES (
                '$ativo',
                '$quantidade',
                '$quantidadeMin',
                'S',
                '$observacao',
                '$marca',
                '$tipo',
                NOW(),
                '$user',
                '" . ($urlImg ?: '') . "'
            )
        ";
        $result = mysqli_query($conexao, $query);
        echo $result ? "Cadastro realizado" : "Cadastro não realizado";
        break;

    case 'alterar_status':
        $sql = "UPDATE ativo SET statusAtivo = '$statusAtivo' WHERE idAtivo = $idAtivo";
        $result = mysqli_query($conexao, $sql);
        echo $result ? "Status alterado" : "Status não alterado";
        break;

    case 'get_info':
        $sql = "
            SELECT
                descricaoAtivo,
                quantidadeAtivo,
                 quantidadeMinAtivo,
                observacaoAtivo,
                idMarca,
                idTipo,
                urlImg
            FROM
                ativo
            WHERE
                idAtivo = $idAtivo
        ";
        $result = mysqli_query($conexao, $sql);
        $ativoData = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode($ativoData);
        exit();

    case 'update':
        // Prepare the SQL query
        $sql = "
            UPDATE ativo SET
                descricaoAtivo = '$ativo',
                idMarca = '$marca',
                idTipo = '$tipo',
                quantidadeAtivo = '$quantidade',
                quantidadeMinAtivo = '$quantidadeMin',
                observacaoAtivo = '$observacao',
                urlImg = '" . ($urlImg ?: '') . "'
            WHERE idAtivo = $idAtivo
        ";
        $result = mysqli_query($conexao, $sql);
        echo $result ? "Informações alteradas" : "Informações não alteradas";
        break;

    default:
        echo json_encode(['error' => 'Ação inválida']);
        break;
}
?>