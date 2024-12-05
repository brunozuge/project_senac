
$(document).ready(function () {
    $("#salvar_info").click(function () {

        let descricao_ativo = $("#ativo").val();
        let marca = $("#marca").val();
        let tipo = $("#tipo").val();
        let quantidade = $("#quantidade").val();
        let observacao = $("#observacao").val();
        let idAtivo = $("#idAtivo").val();


        if(idAtivo == ""){
            acao='inserir';
        } else {
            acao='update';
        }

        $.ajax({
            type:'POST',
            url: "../controle/ativos_controller.php",
            data:{
               
                acao:acao,
                ativo:descricao_ativo,
                marca:marca,
                tipo:tipo,
                quantidade:quantidade,
                observacao:observacao,
               
            },
            
            success: function(result){
                alert(result);
                location.reload();
            }});

    });
});
function muda_status(status,idAtivo){

    $.ajax({
        type:'POST',
        url: "../controle/ativos_controller.php",
        data:{
            acao:'alterar_status',
            status:status,
            idAtivo:idAtivo
        },
        
        success: function(result){
            alert(result);
            location.reload();
        }
    });

}
function carregarAtivo(idAtivo) {
    // Realiza uma requisição AJAX para buscar os dados do ativo
    fetch(`../controle/get_ativo.php?id=${idAtivo}`)
        .then(response => response.json())
        .then(data => {
            // Preenche o modal com os dados recebidos
            document.getElementById("editIdAtivo").value = data.idAtivo;
            document.getElementById("editDescricaoAtivo").value = data.descricaoAtivo;
            document.getElementById("editMarca").value = data.idMarca;
            document.getElementById("editTipo").value = data.idTipo;
            document.getElementById("editQuantidadeAtivo").value = data.quantidadeAtivo;
            document.getElementById("editObservacao").value = data.observacaoAtivo;

            // Abre o modal
            const modal = new bootstrap.Modal(document.getElementById("modalEditAtivo"));
            modal.show();
        })
        .catch(error => console.error("Erro ao carregar ativo:", error));
}

function atualizarAtivo() {
    const form = document.getElementById("formEditAtivo");
    const formData = new FormData(form);

    // Realiza uma requisição AJAX para atualizar o ativo
    fetch("../controle/update_ativo.php", {
        method: "POST",
        body: formData,
    })
        .then(response => response.text())
        .then(result => {
            alert("Ativo atualizado com sucesso!");
            location.reload();
        })
        .catch(error => console.error("Erro ao atualizar ativo:", error));
}

function editar(idAtivo) {

    $('#idAtivo').val(idAtivo);

    $.ajax({
        type: 'POST',
        url: "../controle/ativos_controle.php",
        data: {
            acao: 'get_info',
            idAtivo: idAtivo
        },

        success: function (result) {
          retorno=  JSON.parse(result)

          $("#ativo").val(retorno);
           $("#marca").val(retorno);
          $("#tipo").val(retorno);
           $("#quantidade").val(retorno);
          $("#observacao").val(retorno);
          $("#idAtivo").val(retorno);
        console.log(result);
        }
    });

};
function limpar_modal(){
    $("#descricao").val('');
        $("#quantidade").val('');
        $("#marca").val('');
        $("#tipo").val('');
        $("#observacao").val('');
  }