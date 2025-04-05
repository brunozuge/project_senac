$(document).ready(function () {
    $("#salvar").click(function () {

    
       
       let descricaTipo=$("#descricaoTipo").val();

        if ( descricaTipo == "" ) {
            alert("Campos obrigatórios não preenchidos!");
            return false;
        }

        $.ajax({
            type: 'POST',
            url: "../controle/marcas_controller.php",
            data: {
               descricaoTipo:descricaoTipo,
               idTipo:idTipo

            },

            success: function (result) {
                alert(result);
                location.reload();
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