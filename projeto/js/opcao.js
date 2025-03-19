$(document).ready(function () {
    $("#formOpcao").submit(function (e) {
        e.preventDefault();
        
        const descricao = $("#descricaoOpcao").val();
        const idOpcao = $("#idOpcao").val();
        
        // Verifica se é inserção ou edição
        let operacao = (idOpcao === "") ? "I" : "E";
        
        $.ajax({
            url: "../controle/controle_opcao.php",
            type: "POST",
            data: {
                descricaoOpcao: descricao,
                idOpcao: idOpcao,
                operacao: operacao
            },
            dataType: "json",
            success: function (retorno) {
                if (retorno.status === "ok") {
                    // Exibe mensagem de sucesso
                    alert(retorno.mensagem);
                    // Fecha o modal
                    $("#exampleModal").modal("hide");
                    // Recarrega a página para mostrar a nova opção
                    location.reload();
                } else {
                    // Exibe mensagem de erro
                    alert(retorno.mensagem);
                }
            },
            error: function () {
                alert("Erro ao processar a solicitação.");
            }
        });
    });
});

// Função para mudar o status da opção (ativar/inativar)
function muda_status(status, id) {
    $.ajax({
        url: "../controle/controle_opcao.php",
        type: "POST",
        data: {
            statusOpcao: status,
            idOpcao: id,
            operacao: "S"
        },
        dataType: "json",
        success: function (retorno) {
            if (retorno.status === "ok") {
                // Recarrega a página para mostrar o novo status
                location.reload();
            } else {
                alert(retorno.mensagem);
            }
        },
        error: function () {
            alert("Erro ao processar a solicitação.");
        }
    });
}

// Função para editar uma opção existente
function edita(id) {
    $.ajax({
        url: "../controle/controle_opcao.php",
        type: "POST",
        data: {
            idOpcao: id,
            operacao: "C"
        },
        dataType: "json",
        success: function (retorno) {
            if (retorno.status === "ok") {
                // Preenche o modal com os dados existentes
                $("#descricaoOpcao").val(retorno.descricaoOpcao);
                $("#idOpcao").val(retorno.idOpcao);
                // Abre o modal
                $("#exampleModal").modal("show");
            } else {
                alert(retorno.mensagem);
            }
        },
        error: function () {
            alert("Erro ao processar a solicitação.");
        }
    });
}