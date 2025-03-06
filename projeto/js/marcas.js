$(document).ready(function () {
    $("#salvar").click(function () {

    
       
       let descricaoMarca=$("#descricaoMarca").val();

        if ( descricaoMarca == "" ) {
            alert("Campos obrigatórios não preenchidos!");
            return false;
        }

        $.ajax({
            type: 'POST',
            url: "../controle/marcas_controller.php",
            data: {
               descricaoMarca:descricaoMarca,
               idMarca:idMarca

            },

            success: function (result) {
                alert(result);
                location.reload();
            }
        });
    });
});

function muda_status(statusMarca, idMarca) {
    $.ajax({
        type: 'POST',
        url: "../controle/marcas_controller.php",
        data: {
            acao: 'alterar_status',
            status: statusMarca,
            idMarca: idMarca
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

function edita(idMarca) {
    $('#idMarca').val(idMarca);

    $.ajax({
        type: 'POST',
        url: "../controle/marcas_controller.php",
        data: {
            acao: 'salvar',
            idMarca: idMarca
        },
        success: function (result) {
            let retorno = JSON.parse(result);

            // Preenche os campos no formulário
            $('#modal').click();
            $('#descricaoMarca').val(retorno[0]['descricaoMarca']);
            $('#idMarca').val(retorno[0]['idMarca']);

            console.log(result);
        },
        error: function () {
            alert("Erro ao carregar os dados para edição.");
        }
    });
}