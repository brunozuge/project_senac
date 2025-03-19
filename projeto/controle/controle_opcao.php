<?php
include_once('controle_session.php');
include_once('../modelo/conexao.php');

// Verifica a operação solicitada
if (isset($_POST['operacao'])) {
    $operacao = $_POST['operacao'];
    
    // Inserir nova opção
    if ($operacao == "I") {
        if (isset($_POST['descricaoOpcao']) && $_POST['descricaoOpcao'] != "") {
            $descricaoOpcao = $_POST['descricaoOpcao'];
            $usuario = $_SESSION['usuario'];
            
            // Verifica se a opção já existe
            $sql = "SELECT * FROM opcoes_menu WHERE descricaoOpcao = '$descricaoOpcao'";
            $resultado = mysqli_query($conexao, $sql);
            
            if (mysqli_num_rows($resultado) > 0) {
                $retorno = array("status" => "erro", "mensagem" => "Esta opção já está cadastrada!");
            } else {
                // Insere a nova opção
                $sql = "INSERT INTO opcao (descricaoOpcao, statusOpcao, dataCadastro, idUsuario) 
                        VALUES ('$descricaoOpcao', 'S', NOW(), '$usuario')";
                        
                if (mysqli_query($conexao, $sql)) {
                    $retorno = array("status" => "ok", "mensagem" => "Opção cadastrada com sucesso!");
                } else {
                    $retorno = array("status" => "erro", "mensagem" => "Erro ao cadastrar a opção: " . mysqli_error($conexao));
                }
            }
        } else {
            $retorno = array("status" => "erro", "mensagem" => "O campo descrição é obrigatório!");
        }
    }
    
    // Atualizar opção existente
    else if ($operacao == "E") {
        if (isset($_POST['descricaoOpcao']) && $_POST['descricaoOpcao'] != "") {
            $descricaoOpcao = $_POST['descricaoOpcao'];
            $idOpcao = $_POST['idOpcao'];
            
            // Verifica se já existe outra opção com o mesmo nome
            $sql = "SELECT * FROM opcoes_menu WHERE descricaoOpcao = '$descricaoOpcao' AND idOpcao != $idOpcao";
            $resultado = mysqli_query($conexao, $sql);
            
            if (mysqli_num_rows($resultado) > 0) {
                $retorno = array("status" => "erro", "mensagem" => "Esta opção já está cadastrada!");
            } else {
                // Atualiza a opção
                $sql = "UPDATE opcoes_menu SET descricaoOpcao = '$descricaoOpcao' WHERE idOpcao = $idOpcao";
                
                if (mysqli_query($conexao, $sql)) {
                    $retorno = array("status" => "ok", "mensagem" => "Opção atualizada com sucesso!");
                } else {
                    $retorno = array("status" => "erro", "mensagem" => "Erro ao atualizar a opção: " . mysqli_error($conexao));
                }
            }
        } else {
            $retorno = array("status" => "erro", "mensagem" => "O campo descrição é obrigatório!");
        }
    }
    
    // Alterar status da opção (ativar/inativar)
    else if ($operacao == "S") {
        $statusOpcao = $_POST['statusOpcao'];
        $idOpcao = $_POST['idOpcao'];
        
        $sql = "UPDATE opcoes_menu SET statusOpcao = '$statusOpcao' WHERE idOpcao = $idOpcao";
        
        if (mysqli_query($conexao, $sql)) {
            $retorno = array("status" => "ok", "mensagem" => "Status alterado com sucesso!");
        } else {
            $retorno = array("status" => "erro", "mensagem" => "Erro ao alterar o status: " . mysqli_error($conexao));
        }
    }
    
    // Consultar opção para edição
    else if ($operacao == "C") {
        $idOpcao = $_POST['idOpcao'];
        
        $sql = "SELECT * FROM opcao WHERE idOpcao = $idOpcao";
        $resultado = mysqli_query($conexao, $sql);
        
        if (mysqli_num_rows($resultado) > 0) {
            $opcao = mysqli_fetch_assoc($resultado);
            $retorno = array(
                "status" => "ok",
                "idOpcao" => $opcao['idOpcao'],
                "descricaoOpcao" => $opcao['descricaoOpcao']
            );
        } else {
            $retorno = array("status" => "erro", "mensagem" => "Opção não encontrada!");
        }
    }
    
    // Responde com o resultado em formato JSON
    echo json_encode($retorno);
}
?>