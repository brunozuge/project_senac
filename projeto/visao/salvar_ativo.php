<?php
header('Content-Type: application/json'); // Defina o tipo de resposta como JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ativo = $_POST['ativo'] ?? null;
    $marca = $_POST['marca'] ?? null;
    $tipo = $_POST['tipo'] ?? null;
    $quantidade = $_POST['quantidade'] ?? null;
    $observacao = $_POST['observacao'] ?? '';

    // Validação simples
    if (!$ativo || !$marca || !$tipo || !$quantidade) {
        echo json_encode(['success' => false, 'message' => 'Preencha todos os campos obrigatórios!']);
        exit;
    }

    // Simule a gravação no banco de dados (substitua pelo código de inserção no banco)
    // Exemplo: $query = "INSERT INTO ativos (descricao, marca, tipo, quantidade, observacao) VALUES (...)";
    $success = true; // Suponha que a inserção foi bem-sucedida

    if ($success) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao salvar os dados.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
}
exit;
