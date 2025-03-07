$(document).ready(function () {
    $("#salvar_info").click(function () {
       
        let descricao_ativo = $("#ativo").val();
        let marca = $("#marca").val();
        let tipo = $("#tipo").val();
        let quantidade = $("#quantidade").val();
        let quantidadeMin = $("#quantidadeMin").val();
        let observacao = $("#observacao").val();
        let idAtivo = $("#idAtivo").val();
        let imgAtivo = $("#imgAtivo")[0].files[0]; // Obtém o arquivo, se houver

        // Verifica se os campos obrigatórios estão preenchidos
        if (descricao_ativo.trim() === "") {
            alert("O campo 'Descrição do Ativo' é obrigatório.");
            return false;
        }
        if (marca.trim() === "") {
            alert("O campo 'Marca' é obrigatório.");
            return false;
        }
        if (tipo.trim() === "") {
            alert("O campo 'Tipo' é obrigatório.");
            return false;
        }
        if (quantidade.trim() === "" || isNaN(quantidade)) {
            alert("O campo 'Quantidade' é obrigatório e deve ser um número.");
            return false;
        }
        if (quantidadeMin.trim() === "" || isNaN(quantidadeMin)) {
            alert("O campo 'Quantidade Mínima' é obrigatório e deve ser um número.");
            return false;
        }

        let acao = idAtivo === "" ? 'inserir' : 'update';

        // Se for uma atualização, perguntar o motivo da alteração
        if (acao === 'update') {
            let motivo = prompt("Por favor, informe o motivo da alteração:");
            
            // Se o usuário cancelar o prompt ou não fornecer um motivo
            if (motivo === null) {
                return false; // Cancela a operação
            }
            
            if (motivo.trim() === "") {
                alert("É necessário informar um motivo para a alteração.");
                return false;
            }
            
            var formData = new FormData();
            formData.append('acao', acao);
            formData.append('marca', marca);
            formData.append('tipo', tipo);
            formData.append('quantidade', quantidade);
            formData.append('quantidadeMin', quantidadeMin);
            formData.append('observacao', observacao);
            formData.append('idAtivo', idAtivo);
            formData.append('ativo', descricao_ativo);
            formData.append('motivo', motivo);
            
            // Só adiciona a imagem nova se o usuário tiver selecionado uma
            if (imgAtivo) {
                formData.append('imgAtivo', imgAtivo);
            }
        } else {
            // Caso seja inserção, não precisa de motivo
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
            }
        }

        $.ajax({
            type: 'POST',
            url: "../controle/ativos_controller.php",
            data: formData,
            processData: false,
            contentType: false,
            success: function (result) {
                let retorno = JSON.parse(result);
                let mensagem = retorno['message'];
                alert(mensagem);
                location.reload();
            },
            error: function () {
                alert("Erro ao processar a solicitação.");
            }
        });
    });
});

function muda_status(status, idAtivo) {
    // Perguntar o motivo da alteração de status
    let motivo = prompt("Por favor, informe o motivo da alteração de status:");
    
    // Se o usuário cancelar o prompt ou não fornecer um motivo
    if (motivo === null) {
        return; // Cancela a operação
    }
    
    if (motivo.trim() === "") {
        alert("É necessário informar um motivo para a alteração de status.");
        return;
    }
    
    $.ajax({
        type: 'POST',
        url: "../controle/ativos_controller.php",
        data: {
            acao: 'alterar_status',
            status: status,
            idAtivo: idAtivo,
            motivo: motivo
        },
        success: function (result) {
            let retorno = JSON.parse(result);
            let mensagem = retorno['message'];
            alert(mensagem);
            location.reload();
        },
        error: function () {
            alert("Erro ao alterar o status.");
        }
    });
}

function carregarAtivo(idAtivo) {
    fetch(`../controle/ativos_controller.php?id=${idAtivo}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById("editIdAtivo").value = data.idAtivo;
            document.getElementById("editDescricaoAtivo").value = data.descricaoAtivo;
            document.getElementById("editMarca").value = data.idMarca;
            document.getElementById("editTipo").value = data.idTipo;
            document.getElementById("editQuantidadeAtivo").value = data.quantidadeAtivo;
            document.getElementById("editQuantidadeMinAtivo").value = data.quantidadeMin;
            document.getElementById("editObservacao").value = data.observacaoAtivo;

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
            let retorno = JSON.parse(result);

            $("#ativo").val(retorno['data'][0]['descricaoAtivo']);
            $("#marca").val(retorno['data'][0]['idMarca']);
            $("#tipo").val(retorno['data'][0]['idTipo']);
            $("#quantidade").val(retorno['data'][0]['quantidadeAtivo']);
            $("#quantidadeMin").val(retorno['data'][0]['quantidadeMinAtivo']);
            $("#observacao").val(retorno['data'][0]['observacaoAtivo']);

            if (retorno['data'][0]['urlImg'] != "") {
                let imgPreview = $("#imgPreview");
                let divPreview = $("#divPreview");
                imgPreview.attr("src", window.location.protocol + "//" + window.location.host + '/' + retorno['data'][0]['urlImg']);
                divPreview.attr("style", "display:block");
            } else {
                $("#imgPreview").attr("style", "display:none");
            }
        },
        error: function () {
            alert("Erro ao carregar informações para edição.");
        }
    });
}

function limpar_modal() {
    $("#ativo").val('');
    $("#quantidade").val('');
    $("#quantidadeMin").val('');
    $("#marca").val('');
    $("#imgAtivo").val('');
    $("#imgPreview").attr("src", "");
    $("#tipo").val('');
    $("#observacao").val('');
}