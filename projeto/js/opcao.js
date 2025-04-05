$(document).ready(function () {
    $(".salvar").click(function () {
        let descricaoOpcao = $("#descricaoOpcao").val();
        let idOpcao = $("#idOpcao").val();

        let nivelOpcao = $("#nivelOpcao").val();
        let urlOpcao = $("#urlOpcao").val();
        let idSuperior = $("#idSuperior").val();

        if (descricaoOpcao === "" || nivelOpcao === "") {
            alert("Campo obrigatório");
            return false;
        }
        let acao = (idOpcao === "") ? 'inserir' : 'update';

        $.ajax({
            type: 'POST',
            url: "../controle/opcoes_controller.php",
            data: {
                acao: acao,
                descricaoOpcao: descricaoOpcao,
                idOpcao: idOpcao,
                urlOpcao: urlOpcao,
                nivelOpcao: nivelOpcao,
                idSuperior: idSuperior
            },
            success: function (result) {
                alert(result);
                location.reload();
            }
        });
    });
});

function muda_status(statusOpcao, idOpcao) {
    $.ajax({
        type: 'POST',
        url: "../controle/opcoes_controller.php",
        data: {
            acao: 'alterar_status',
            statusOpcao: statusOpcao,
            idOpcao: idOpcao
        },
        success: function (result) {
            alert(result);
            location.reload();
        }
    });
}

function editar(idOpcao) {
    $.ajax({
        type: 'POST',
        url: "../controle/opcoes_controller.php",
        data: {
            acao: 'get_info',
            idOpcao: idOpcao
        },
        success: function (result) {
            retorno = JSON.parse(result);

            $('#modal').click();
            $('#descricaoOpcao').val(retorno[0]['descricaoOpcao']);
            $('#idOpcao').val(idOpcao);
            $('#nivelOpcao').val(parseInt(retorno[0]['nivelOpcao']));
            $('#urlOpcao').val(retorno[0]['urlOpcao']);
            $('#idSuperior').val(retorno[0]['idSuperior']);
            exibeSuperior ('', retorno[0]['nivelOpcao'],retorno[0]['idSuperior']);

        }
    });
}


function limpar_modal() {
    $("#idOpcao").val('');
    $("#descricaoOpcao").val('');
    $("#nivelOpcao").val('');
    $("#urlOpcao").val('');
}

function exibeSuperior(elemento, nivel = false,idSuperior=false) {
   
    if(nivel != false) {
        nivel = nivel;
    }else{
        nivel = elemento.value;
    }
    
    let nivelSuperior = nivel - 1;

    console.log(nivel);

    if (nivel == 1 || nivel == '') {
        $('.divSuperior').attr('style', 'display:none;');
    } else {
        $.ajax({
            type: 'POST',
            url: "../controle/opcoes_controller.php",
            data: {
                acao: 'busca-superior',
                nivelOpcao: nivelSuperior
            },
            success: function (result) {
                //console.log();
                retorno = JSON.parse(result);
                let select = '<select class="form-select" id="idSuperior"><option value="">Selecione um Nível Superior</option>';
                $(retorno).each(function (index, element) { 
                    if (idSuperior==element.idOpcao){
                        select += '<option value="' + element.idOpcao + '" selected>' + element.descricaoOpcao + '</option>';
                    }else{
                        select += '<option value="' + element.idOpcao + '">' + element.descricaoOpcao + '</option>';
                    }
                    
                });
                select += "</select>";
                $('#select').html(select);
            }
        });
        $('.divSuperior').attr('style', 'display:block;');
    }
}

document.addEventListener('DOMContentLoaded', function () {
    var tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    var tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
});