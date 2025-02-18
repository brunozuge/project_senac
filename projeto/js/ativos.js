
$(document).ready(function () {
    $("#salvar_info").click(function () {
       

        let descricao_ativo = $("#ativo").val();
        let marca = $("#marca").val();
        let tipo = $("#tipo").val();
        let quantidade = $("#quantidade").val();
        let quantidadeMin = $("#quantidadeMin").val();
        let observacao = $("#observacao").val();
        let idAtivo = $("#idAtivo").val();
        let imgAtivo = $("#imgAtivo");

        console.log(imgAtivo);
        let img = imgAtivo[0].files[0];



        if (idAtivo == "") {
            acao = 'inserir';
        } else {
            acao = 'update';
        }

        var formData = new FormData();

        formData.append('acao', acao)
        formData.append('marca', marca)
        formData.append('tipo', tipo)
        formData.append('quantidade', quantidade)
        formData.append('quantidadeMin', quantidadeMin)
        formData.append('observacao', observacao)
        formData.append('idAtivo', idAtivo)
        formData.append('ativo', descricao_ativo)
        formData.append('imgAtivo', img)

        $.ajax({
            type: 'POST',
            url: "../controle/ativos_controller.php",
            data: formData,
            processData: false,
            contentType: false,

            success: function (result) {
                retorno = JSON.parse (result);
                mensagem = retorno ['message']
                
                alert(mensagem);
                location.reload();
            }
        });

    });
});
function muda_status(status, idAtivo) {

    $.ajax({
        type: 'POST',
        url: "../controle/ativos_controller.php",
        data: {
            acao: 'alterar_status',
            status: status,
            idAtivo: idAtivo
        },

       
            success: function (result) {
                retorno = JSON.parse (result);
                mensagem = retorno ['message']
                alert(mensagem);
           location.reload();
        }
    });

}
function carregarAtivo(idAtivo) {
    // Realiza uma requisição AJAX para buscar os dados do ativo
    fetch(`../controle/ativos_controller.php?id=${idAtivo}`)
        .then(response => response.json())
        .then(data => {
           
            // Preenche o modal com os dados recebidos
            document.getElementById("editIdAtivo").value = data.idAtivo;
            document.getElementById("editDescricaoAtivo").value = data.descricaoAtivo;
            document.getElementById("editMarca").value = data.idMarca;
            document.getElementById("editTipo").value = data.idTipo;
            document.getElementById("editQuantidadeAtivo").value = data.quantidadeAtivo;
            document.getElementById("editQuantidadeMinAtivo").value = data.quantidadeMin;
            document.getElementById("editObservacao").value = data.observacaoAtivo;

            // Abre o modal
            const modal = new bootstrap.Modal(document.getElementById("modalEditAtivo"));
            modal.show();
        })
        .catch(error => console.error("Erro ao carregar ativo:", error));
}



function edita(idAtivo) {
    $('#modal').click();
    $('#idAtivo').val(idAtivo);
    $.ajax({
        type: 'POST',
        url: "../controle/ativos_controller.php",
        data: {
            acao: 'get_info',
            idAtivo: idAtivo
        },

        success: function (result) {
            retorno = JSON.parse(result)


            console.log (retorno)

            $("#ativo").val(retorno [0]['descricaoAtivo']);
            $("#marca").val(retorno[0]['idMarca']);
            $("#tipo").val(retorno[0]['idTipo']);
            $("#quantidade").val(retorno[0]['quantidadeAtivo']);
            $("#quantidadeMin").val(retorno[0]['quantidadeMinAtivo']);
            $("#observacao").val(retorno[0]['observacaoAtivo']);
            
            
            if (retorno[0]['urlImg'] != "") {
                let imgPreview = $("#imgPreview");
                let divPreview = $("#divPreview");
                imgPreview.attr("src", window.location.protocol + "//" + window.location.host + '/' + retorno[0]['urlImg']);
               divPreview.attr("style", "display:block");
            } else {
                imgPreview.attr("style", "display:none");
            }


         
           
        }
    });

};



function limpar_modal() {
    $("#ativo").val('');
    $("#quantidade").val('');
    $("#quantidadeMin").val('');
    $("#marca").val('');
    $("#imgAtivo").val('');
    $("#imgPreview").val('');
    $("#tipo").val('');
    $("#observacao").val('');

};
/*$(document).ready(function () {
    $("#salvar_info").click(function () {
        let descricao_ativo = $("#ativo").val();
        let marca = $("#marca").val();
        let tipo = $("#tipo").val();
        let quantidade = $("#quantidade").val();
        let quantidadeMin = $("#quantidadeMin").val();
        let observacao = $("#observacao").val();
        let idAtivo = $("#idAtivo").val();
        let imgAtivo = $("#imgAtivo")[0].files[0]; // Obtém o arquivo, se houver
        let imgAtual = $("#imgPreview").attr("src"); // Obtém a imagem existente

        let acao = idAtivo === "" ? 'inserir' : 'update';

        var formData = new FormData();
        formData.append('acao', acao);
        formData.append('marca', marca);
        formData.append('tipo', tipo);
        formData.append('quantidade', quantidade);
        formData.append('quantidadeMin', quantidadeMin);
        formData.append('observacao', observacao);
        formData.append('idAtivo', idAtivo);
        formData.append('ativo', descricao_ativo);

        // Só adiciona a imagem nova se o usuário tiver selecionado uma
        if (imgAtivo) {
            formData.append('imgAtivo', imgAtivo);
        } else {
            formData.append('imgAtivo', imgAtual); // Mantém a imagem antiga
        }

        $.ajax({
            type: 'POST',
            url: "../controle/ativos_controller.php",
            data: formData,
            processData: false,
            contentType: false,

            success: function (result) {
                retorno = JSON.parse (result);
                mensagem = retorno ['message']
                
                alert(mensagem);
                location.reload();
            }
        });
    });
});*/

