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
// Capturando o motivo da alteração
$motivo = isset($_POST['motivo']) ? sanitize_input($_POST['motivo'], $conexao) : '';

// Array para resposta única
$response = [];

// Handle file upload securely
$img = isset($_FILES['imgAtivo']) ? $_FILES['imgAtivo'] : null;
$urlImg = ''; // Variable to store the uploaded image URL

if ($img && $img['error'] === UPLOAD_ERR_OK) {
    // Define the base directory for uploads
    $pasta_base = $_SERVER['DOCUMENT_ROOT'] . "/projeto/imgAtivo/";
    if (!is_dir($pasta_base)) {
        mkdir($pasta_base, 0755, true);
    }
    // Generate a unique file name
    $fileName = uniqid() . '_' . basename($img['name']);
    $filePath = $pasta_base . $fileName;

    if (move_uploaded_file($img['tmp_name'], $filePath)) {
        $urlImg = 'projeto/imgAtivo/' . $fileName;
    } else {
        $response['error'] = 'Falha ao mover arquivo';
        echo json_encode($response);
        exit();
    }
}

// Perform actions based on the value of $acao
switch ($acao) {
    case 'inserir':
        $query = "
            INSERT INTO ativo (
                idAtivo,
                descricaoAtivo,
                quantidadeAtivo,
                quantidadeMinAtivo,
                statusAtivo,
                observacaoAtivo,
                idMarca,
                idTipo,
                dataCadastro,
                idUsuario,
                urlImg,
                obsQuantiAtivo
            ) VALUES (
                '$idAtivo',
                '$ativo',
                '$quantidade',
                '$quantidadeMin',
                'S',
                '$observacao',
                '$marca',
                '$tipo',
                NOW(),
                '$user',
                '" . ($urlImg ?: '') . "',
                'Cadastro inicial'
            )
        ";
        $result = mysqli_query($conexao, $query);
        $response['success'] = $result ? true : false;
        $response['message'] = $result ? "Cadastro realizado" : "Cadastro não realizado";
        break;

    case 'alterar_status':
        if ($idAtivo > 0) {
            // Verificar se o motivo foi fornecido
            if (empty($motivo)) {
                $response['success'] = false;
                $response['message'] = "É necessário informar o motivo da alteração de status.";
                echo json_encode($response);
                exit();
            }
            
            $sql = "UPDATE ativo SET statusAtivo = '$statusAtivo', obsQuantiAtivo = '$motivo' WHERE idAtivo = $idAtivo";
            $result = mysqli_query($conexao, $sql);
            $response['success'] = $result ? true : false;
            $response['message'] = $result ? "Status alterado" : "Status não alterado";
        } else {
            $response['success'] = false;
            $response['error'] = "ID inválido";
        }
        break;

    case 'get_info':
        if ($idAtivo > 0) {
            $sql = "
                SELECT
                    descricaoAtivo,
                    quantidadeAtivo,
                    quantidadeMinAtivo,
                    observacaoAtivo,
                    idMarca,
                    idTipo,
                    urlImg,
                    obsQuantiAtivo
                FROM ativo
                WHERE idAtivo = $idAtivo
            ";
            $result = mysqli_query($conexao, $sql);
            $ativoData = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $response['success'] = true;
            $response['data'] = $ativoData;
        } else {
            $response['success'] = false;
            $response['error'] = "ID inválido";
        }
        break;

    case 'update':
        if ($idAtivo > 0) {
            // Verificar se o motivo foi fornecido para atualizações
            if (empty($motivo)) {
                $response['success'] = false;
                $response['message'] = "É necessário informar o motivo da alteração.";
                echo json_encode($response);
                exit();
            }
            
            $sql = "
                UPDATE ativo SET
                    idAtivo='$idAtivo',
                    descricaoAtivo = '$ativo',
                    idMarca = '$marca',
                    idTipo = '$tipo',
                    quantidadeAtivo = '$quantidade',
                    quantidadeMinAtivo = '$quantidadeMin',
                    observacaoAtivo = '$observacao',
                    obsQuantiAtivo = '$motivo'
            ";

            // Se uma nova imagem foi enviada, atualiza a URL
            if ($urlImg) {
                $sql .= ", urlImg = '$urlImg'";
            }

            $sql .= " WHERE idAtivo = $idAtivo";

            $result = mysqli_query($conexao, $sql);
            $response['success'] = $result ? true : false;
            $response['message'] = $result ? "Informações alteradas" : "Informações não alteradas";
        } else {
            $response['success'] = false;
            $response['error'] = "ID inválido";
        }
        break;

    default:
        $response['success'] = false;
        $response['error'] = 'Ação inválida';
        break;
}

// Responde apenas uma vez no final
echo json_encode($response);
exit();
?>