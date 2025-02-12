<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Função para buscar streams da Twitch API
function fetchTwitchStream($channelName) {
    $client_id = 'SEU_CLIENT_ID'; // Substitua pelo seu Client ID
    $access_token = 'SEU_ACCESS_TOKEN'; // Substitua pelo seu Access Token

    $url = "https://api.twitch.tv/helix/streams?user_login=" . urlencode($channelName);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Client-ID: $client_id",
        "Authorization: Bearer $access_token"
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);
    if (isset($data['data'][0])) {
        return $data['data'][0];
    }
    return null;
}

// Verifica se foi enviado um formulário com nomes de canais
$channels = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['channels'])) {
    $channelNames = explode(',', sanitize_input($_POST['channels'], $conexao));
    foreach ($channelNames as $name) {
        $stream = fetchTwitchStream(trim($name));
        if ($stream) {
            $channels[] = $stream;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MultiStream Viewer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        h1 {
            margin: 20px 0;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"] {
            padding: 10px;
            width: 300px;
            margin-right: 10px;
        }
        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .stream-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* 2 streams por linha */
            gap: 10px;
            width: 90%;
        }
        iframe {
            width: 100%;
            height: 300px;
            border: none;
        }
        @media (min-width: 768px) {
            .stream-container {
                grid-template-columns: repeat(3, 1fr); /* 3 streams por linha em telas maiores */
            }
        }
    </style>
</head>
<body>
    <h1>MultiStream Viewer</h1>

    <!-- Formulário para adicionar canais -->
    <form method="POST">
        <input type="text" name="channels" placeholder="Insira nomes de canais separados por vírgula" required>
        <button type="submit">Adicionar Streams</button>
    </form>

    <!-- Container para exibir streams -->
    <div class="stream-container">
        <?php if (!empty($channels)): ?>
            <?php foreach ($channels as $stream): ?>
                <iframe
                    src="https://player.twitch.tv/?channel=<?= $stream['user_name'] ?>&parent=localhost"
                    allowfullscreen>
                </iframe>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nenhum stream disponível. Insira nomes de canais no formulário acima.</p>
        <?php endif; ?>
    </div>
</body>
</html>