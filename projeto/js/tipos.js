$(document).ready(function () {
    $(".salvar").click(function () {
        let tipo = $("#descricaoTipo").val();
        let idTipo = $("#idTipo").val();

        // Verifica se o campo 'tipo' está vazio
        if (tipo.trim() === "") {
            alert("O campo 'Tipo' é obrigatório.");
            return false; // Interrompe a execução do código
        }

        let acao = idTipo == "" ? 'inserir' : 'update';

        $.ajax({
            type: 'POST',
            url: "../controle/tipos_controller.php",
            data: {
                acao: acao,
                tipo: tipo,
                idTipo: idTipo,
            },
            success: function (result) {
                alert(result);
                location.reload();
            },
            error: function () {
                alert("Erro ao processar a solicitação.");
            }
        });
    });
});

function muda_status(statusTipo, idTipo) {
    $.ajax({
        type: 'POST',
        url: "../controle/tipos_controller.php",
        data: {
            acao: 'alterar_status',
            status: statusTipo,
            idTipo: idTipo
        },
        success: function (result) {
            alert(result);
            location.reload();
        },
        error: function () {
            alert("Erro ao alterar o status.");
        }
    });
}

function edita(idTipo) {
    $('#idTipo').val(idTipo);

    $.ajax({
        type: 'POST',
        url: "../controle/tipos_controller.php",
        data: {
            acao: 'salvar',
            idTipo: idTipo
        },
        success: function (result) {
            let retorno = JSON.parse(result);

            // Preenche os campos no formulário
            $('#modal').click();
            $('#descricaoTipo').val(retorno[0]['descricaoTipo']);
            $('#idTipo').val(retorno[0]['idTipo']);

            console.log(result);
        },
        error: function () {
            alert("Erro ao carregar os dados para edição.");
        }
    });
}