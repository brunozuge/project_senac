<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Distribuidora Acermed - Cadastro e Compras</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e9f5f9;
            margin: 0;
            padding: 20px;
            text-align: center;
        }

        .container {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #2c3e50;
        }

        button {
            padding: 10px 20px;
            background-color: #27ae60;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 10px;
        }

        button:hover {
            background-color: #219653;
        }

        .success {
            margin-top: 20px;
            color: #27ae60;
            font-weight: bold;
        }

        .error {
            margin-top: 20px;
            color: red;
            font-weight: bold;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>

<?php
session_start();

// Função para limpar o CPF (remover pontos e traços)
function limparCPF($cpf) {
    return preg_replace('/[^0-9]/', '', $cpf);
}

// Produtos com seus respectivos preços
$produtos = [
    'A' => ['nome' => 'Benzetacil', 'preco' => 30.00],
    'B' => ['nome' => 'Suplementação', 'preco' => 45.50],
    'C' => ['nome' => 'Vitamina C', 'preco' => 12.30],
    'D' => ['nome' => 'Anti-inflamatório', 'preco' => 20.00],
    'E' => ['nome' => 'Analgésico', 'preco' => 10.00],
    'F' => ['nome' => 'Anti-histamínico', 'preco' => 15.00],
    'G' => ['nome' => 'Creme Hidratante', 'preco' => 25.00],
    'H' => ['nome' => 'Pomada Antisséptica', 'preco' => 18.00],
    'I' => ['nome' => 'Antibiótico', 'preco' => 50.00],
    'J' => ['nome' => 'Soro Fisiológico', 'preco' => 5.00],
    'K' => ['nome' => 'Colírio', 'preco' => 12.00],
    'L' => ['nome' => 'Analgesia', 'preco' => 9.50],
    'M' => ['nome' => 'Antiácido', 'preco' => 7.00],
    'N' => ['nome' => 'Repelente', 'preco' => 25.00],
    'O' => ['nome' => 'Protetor Solar', 'preco' => 40.00],
    'P' => ['nome' => 'Descongestionante', 'preco' => 20.00],
    'Q' => ['nome' => 'Xarope', 'preco' => 15.00],
    'R' => ['nome' => 'Inibidor', 'preco' => 30.00],
    'S' => ['nome' => 'Antidepressivo', 'preco' => 75.00],
    'T' => ['nome' => 'Antipsicótico', 'preco' => 100.00],
    'U' => ['nome' => 'Esteroide', 'preco' => 60.00],
    'V' => ['nome' => 'Antifúngico', 'preco' => 40.00],
    'W' => ['nome' => 'Vitamínico', 'preco' => 20.00],
    'X' => ['nome' => 'Anestésico', 'preco' => 50.00],
    'Y' => ['nome' => 'Broncodilatador', 'preco' => 35.00],
    'Z' => ['nome' => 'Creme Dermatológico', 'preco' => 55.90],
];

// Verifica se uma ação foi enviada
$acao = $_POST['acao'] ?? null;

// Exibe a tela de seleção inicial com as opções de cadastro, compras e ver pedidos
if (!$acao) {
    echo '<div class="container">
            <h1>Bem-vindo à Distribuidora Acermed</h1>
            <form action="" method="POST">
                <button type="submit" name="acao" value="cadastro">Cadastrar Cliente</button>
                <button type="submit" name="acao" value="compras">Ir para Compras</button>
                <button type="submit" name="acao" value="ver_pedidos">Ver Todos os Pedidos</button>
                <button type="submit" name="acao" value="redirecionar">Redirecionar para Outra Distribuidora</button>
                <button type="submit" name="acao" value="remover_cliente">Remover Cadastro</button>
                <button type="submit" name="acao" value="ver_cadastros">Ver Todos os Cadastros</button>

            </form>
          </div>';
}

// Exibe o formulário de cadastro se "Cadastro" for selecionado
// Exibe todos os cadastros de clientes
if ($acao === 'ver_cadastros') {
    echo '<div class="container">
            <h1>Todos os Cadastros</h1>';

    if (!empty($_SESSION['clientes'])) {
        foreach ($_SESSION['clientes'] as $cpf => $cliente) {
            echo '<div>
                    <h3>Nome: ' . $cliente['nome'] . '</h3>
                    <p>Email: ' . $cliente['email'] . '</p>
                    <p>CPF: ' . $cpf . '</p>
                    <p>Cidade: ' . $cliente['cidade'] . '</p>
                    <p>Estado: ' . $cliente['estado'] . '</p>
                    <p>País: ' . $cliente['pais'] . '</p>
                  </div>';
        }
    } else {
        echo '<p>Nenhum cliente cadastrado até agora.</p>';
    }

    echo '<form action="" method="POST">
            <button type="submit" name="acao" value="">Voltar ao início</button>
          </form>
          </div>';
}// Verifica se o CPF já está cadastrado


if ($acao === 'cadastro') {
    echo '<div class="container">
            <h1>Cadastro de Cliente</h1>
            <form action="" method="POST">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>

                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" required placeholder="000.000.000-00">

                <label for="cidade">Cidade:</label>
                <input type="text" id="cidade" name="cidade" required>

                <label for="estado">Estado:</label>
                <input type="text" id="estado" name="estado" required>

                <label for="pais">País:</label>
                <input type="text" id="pais" name="pais" value="Brasil" readonly>

                <button type="submit" name="acao" value="finalizar_cadastro">Cadastrar</button>
            </form>
            <form action="" method="POST">
                <button type="submit" name="acao" value="">Voltar ao início</button>
            </form>
          </div>';
}

// Processa o cadastro do cliente e armazena os dados na sessão
if ($acao === 'finalizar_cadastro') {
    $nome = htmlspecialchars($_POST['nome']);
    $email = htmlspecialchars($_POST['email']);
    $senha = htmlspecialchars($_POST['senha']);
    $cpf = limparCPF($_POST['cpf']);  // Limpa o CPF
    $cidade = htmlspecialchars($_POST['cidade']);
    $estado = htmlspecialchars($_POST['estado']);
    $pais = htmlspecialchars($_POST['pais']);

    // Verifica se o CPF já está cadastrado
    if (isset($_SESSION['clientes'][$cpf])) {
        echo '<div class="container">
                <div class="error">Erro: Já existe um cliente cadastrado com este CPF!</div>
                <form action="" method="POST">
                    <button type="submit" name="acao" value="">Voltar ao início</button>
                </form>
              </div>';
              // Verifica se o CPF já está cadastrado
if (isset($_SESSION['clientes'][$cpf])) {
    echo '<div class="container">
            <div class="error">Erro: Já existe um cliente cadastrado com este CPF!</div>
            <form action="" method="POST">
                <button type="submit" name="acao" value="">Voltar ao início</button>
            </form>
          </div>';
} else {
    // Código para armazenar os dados do cliente na sessão
}

    } else {
        // Armazena os dados do cliente na sessão
        $_SESSION['clientes'][$cpf] = [
            'nome' => $nome,
            'email' => $email,
            'cpf' => $cpf,
            'cidade' => $cidade,
            'estado' => $estado,
            'pais' => $pais,
        ];

        // Mensagem de sucesso após o cadastro
        echo '<div class="container">
                <div class="success">Cliente cadastrado com sucesso!</div>
                <form action="" method="POST">
                    <button type="submit" name="acao" value="">Voltar ao início</button>
                </form>
              </div>';
    }
}

// Exibe o formulário de compras
if ($acao === 'compras') {
    echo '<div class="container">
            <h1>Faça sua Compra</h1>
            <form action="" method="POST">
                <label for="cpf_compras">CPF:</label>
                <input type="text" id="cpf_compras" name="cpf_compras" placeholder="000.000.000-00">
                <label>
                    <input type="checkbox" name="anonimo" value="sim"> Comprar de forma anônima
                </label>
                <button type="submit" name="acao" value="verificar_cpf">Verificar</button>
            </form>
            <form action="" method="POST">
                <button type="submit" name="acao" value="">Voltar ao início</button>
            </form>
          </div>';
}

// Verifica o CPF do cliente ou se a compra é anônima
if ($acao === 'verificar_cpf') {
    $anonimo = isset($_POST['anonimo']);
    $cpf_compras = limparCPF($_POST['cpf_compras']);

    if (!$anonimo && isset($_SESSION['clientes'][$cpf_compras])) {
        // Se o cliente existir e não for anônimo, exibe os produtos disponíveis
        echo '<div class="container">
                <h2>Bem-vindo, ' . $_SESSION['clientes'][$cpf_compras]['nome'] . '!</h2>
                <h3>Produtos disponíveis:</h3>
                <form action="" method="POST">
                    <input type="hidden" name="cpf_compras" value="' . $cpf_compras . '">
                    <input type="hidden" name="anonimo" value="nao">';
        
        foreach ($produtos as $key => $produto) {
            echo '<label>
                    <input type="checkbox" name="produtos[]" value="' . $key . '"> ' . $produto['nome'] . ' - R$ ' . number_format($produto['preco'], 2, ',', '.') . '
                  </label>';
        }

        echo '<button type="submit" name="acao" value="finalizar_compra">Finalizar Compra</button>
                </form>
                <form action="" method="POST">
                    <button type="submit" name="acao" value="">Voltar ao início</button>
                </form>
              </div>';
    } elseif ($anonimo) {
        // Se o cliente optar por ser anônimo
        echo '<div class="container">
                <h2>Bem-vindo, Cliente Anônimo!</h2>
                <h3>Produtos disponíveis:</h3>
                <form action="" method="POST">
                    <input type="hidden" name="anonimo" value="sim">';
        
        foreach ($produtos as $key => $produto) {
            echo '<label>
                    <input type="checkbox" name="produtos[]" value="' . $key . '"> ' . $produto['nome'] . ' - R$ ' . number_format($produto['preco'], 2, ',', '.') . '
                  </label>';
        }

        echo '<button type="submit" name="acao" value="finalizar_compra">Finalizar Compra</button>
                </form>
                <form action="" method="POST">
                    <button type="submit" name="acao" value="">Voltar ao início</button>
                </form>
              </div>';
    } else {
        // Se o cliente não existir e não for anônimo
        echo '<div class="container">
                <div class="error">Cliente não encontrado!</div>
                <form action="" method="POST">
                    <button type="submit" name="acao" value="">Voltar ao início</button>
                </form>
              </div>';
    }
}

// Finaliza a compra e armazena os dados na sessão
if ($acao === 'finalizar_compra') {
    $anonimo = $_POST['anonimo'] === 'sim';
    $cpf_compras = $_POST['cpf_compras'] ?? null;
    $produtos_selecionados = $_POST['produtos'] ?? [];

    if (!empty($produtos_selecionados)) {
        // Calcula o total da compra
        $total = 0;
        foreach ($produtos_selecionados as $produto_key) {
            $total += $produtos[$produto_key]['preco'];
        }

        // Armazena o pedido na sessão
        $_SESSION['pedidos'][] = [
            'cpf' => $anonimo ? 'Anônimo' : $cpf_compras,
            'produtos' => $produtos_selecionados,
            'total' => $total,
        ];

        echo '<div class="container">
                <div class="success">Compra finalizada com sucesso!</div>
                <form action="" method="POST">
                    <button type="submit" name="acao" value="">Voltar ao início</button>
                </form>
              </div>';
    } else {
        echo '<div class="container">
                <div class="error">Nenhum produto selecionado!</div>
                <form action="" method="POST">
                    <button type="submit" name="acao" value="">Voltar ao início</button>
                </form>
              </div>';
    }
}

// Exibe todos os pedidos feitos
if ($acao === 'ver_pedidos') {
    echo '<div class="container">
            <h1>Todos os Pedidos</h1>';

    if (!empty($_SESSION['pedidos'])) {
        foreach ($_SESSION['pedidos'] as $index => $pedido) {
            $cliente_nome = $pedido['cpf'] === 'Anônimo' ? 'Cliente Anônimo' : ($_SESSION['clientes'][$pedido['cpf']]['nome'] ?? 'Desconhecido');
            echo '<div>
                    <h3>Cliente: ' . $cliente_nome . ' (CPF: ' . $pedido['cpf'] . ')</h3>
                    <p>Produtos: ';
            foreach ($pedido['produtos'] as $produto_key) {
                echo $produtos[$produto_key]['nome'] . ', ';
            }
            echo '</p>
                    <p>Total: R$ ' . number_format($pedido['total'], 2, ',', '.') . '</p>
                    <form action="" method="POST" style="display:inline;">
                        <input type="hidden" name="pedido_index" value="' . $index . '">
                        <button type="submit" name="acao" value="excluir_pedido">Excluir Pedido</button>
                    </form>
                  </div>';
        }
    } else {
        echo '<p>Nenhum pedido registrado até agora.</p>';
    }

    echo '<form action="" method="POST">
            <button type="submit" name="acao" value="">Voltar ao início</button>
          </form>
          </div>';
}

// Exclui um pedido
if ($acao === 'excluir_pedido') {
    $pedido_index = $_POST['pedido_index'];

    if (isset($_SESSION['pedidos'][$pedido_index])) {
        unset($_SESSION['pedidos'][$pedido_index]);
        $_SESSION['pedidos'] = array_values($_SESSION['pedidos']); // Reindexa o array

        echo '<div class="container">
                <div class="success">Pedido excluído com sucesso!</div>
                <form action="" method="POST">
                    <button type="submit" name="acao" value="ver_pedidos">Ver Todos os Pedidos</button>
                    <button type="submit" name="acao" value="">Voltar ao início</button>
                </form>
              </div>';
    } else {
        echo '<div class="container">
                <div class="error">Pedido não encontrado!</div>
                <form action="" method="POST">
                    <button type="submit" name="acao" value="">Voltar ao início</button>
                </form>
              </div>';
    }
}

// Redireciona para outra distribuidora
if ($acao === 'redirecionar') {
    echo '<div class="container">
            <h1>Redirecionando...</h1>
            <p>Você será direcionado para a página da distribuidora.</p>
            <form action="" method="POST">
                <button type="submit" name="acao" value="">Voltar ao início</button>
            </form>
          </div>';
    // Redireciona para a URL desejada
    header("Refresh: 3; url=https://www.youtube.com/@BroxadaSinistra");
}

// Exibe o formulário para remover cliente
if ($acao === 'remover_cliente') {
    echo '<div class="container">
            <h1>Remover Cadastro de Cliente</h1>
            <form action="" method="POST">
                <label for="cpf_remover">CPF:</label>
                <input type="text" id="cpf_remover" name="cpf_remover" placeholder="000.000.000-00" required>
                <label for="senha_remover">Senha:</label>
                <input type="password" id="senha_remover" name="senha_remover" placeholder="Digite a senha" required>
                <button type="submit" name="acao" value="confirmar_remover">Remover Cadastro</button>
            </form>
            <form action="" method="POST">
                <button type="submit" name="acao" value="">Voltar ao início</button>
            </form>
          </div>';
}

// Confirma a remoção do cliente
if ($acao === 'confirmar_remover') {
    $cpf_remover = limparCPF($_POST['cpf_remover']);
    $senha_remover = $_POST['senha_remover'];

    if ($senha_remover === '1234') {
        if (isset($_SESSION['clientes'][$cpf_remover])) {
            unset($_SESSION['clientes'][$cpf_remover]);

            echo '<div class="container">
                    <div class="success">Cadastro removido com sucesso!</div>
                    <form action="" method="POST">
                        <button type="submit" name="acao" value="">Voltar ao início</button>
                    </form>
                  </div>';
        } else {
            echo '<div class="container">
                    <div class="error">Erro: Cliente não encontrado!</div>
                    <form action="" method="POST">
                        <button type="submit" name="acao" value="">Voltar ao início</button>
                    </form>
                  </div>';
        }
    } else {
        echo '<div class="container">
                <div class="error">Erro: Senha incorreta!</div>
                <form action="" method="POST">
                    <button type="submit" name="acao" value="">Voltar ao início</button>
                </form>
              </div>';
    }
}
?>
</body>
</html>
