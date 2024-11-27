
$(document).ready(function () {
    $("#salvar_info").click(function () {

        let descricao_ativo = $("#ativo").val();
        let marca = $("#marca").val();
        let tipo = $("#tipo").val();
        let quantidade = $("#quantidade").val();
        let observacao = $("#observacao").val();

        $.ajax({
            type:'POST',
            url: "../controle/ativos_controller.php",
            data:{
                ativo:descricao_ativo,
                marca:marca,
                tipo:tipo,
                quantidade:quantidade,
                observacao:observacao
            },
            
            success: function(result){
                console.log(result)
            }});

    });
});