$(document).ready(function () {
    $("#salvar").click(function () {

        let idAtivo = $("#idAtivo").val();
        let tipoMovimentacao = $("#tipoMov").val();
        let quantidadeMov = $("#quantidadeMov").val();
        let localOrigem = $("#localOrigem").val();
        let localDestino = $("#localDestino").val();
        let descricaoMovimentacao = $("#descricaoMovimentacao").val();

        if (idAtivo == "" || tipoMovimentacao == "" || quantidadeMov == "") {
            alert("Campos obrigatórios não preenchidos!");
            return false;
        }

        $.ajax({
            type: 'POST',
            url: "../controle/controle_movimentacao.php",
            data: {
                idAtivo: idAtivo,
                tipoMovimentacao: tipoMovimentacao,
                quantidadeMov: quantidadeMov,
                localOrigem: localOrigem,
                localDestino: localDestino,
                descricaoMovimentacao: descricaoMovimentacao,

            },

            success: function (result) {
                alert(result);
                location.reload();
            }
        });
    });
});


function limpar_modal() {

    $("#ativo").val('');
    $("#tipoMov").val('');
    $("#quantidadeMov").val('');
    $("#localOrigem").val('');
    $("#localDestino").val('');
    $("#descricaoMovimentacao").val('');

}