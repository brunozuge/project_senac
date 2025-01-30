
$(document).ready(function () {
    $(".salvar").click(function () {

        let tipo= $("#descricaoTipo").val();
       let idTipo = $("#idTipo").val();



        if(idTipo == ""){
            acao='inserir';
        } else {
            acao='update';
        }

        $.ajax({
            type:'POST',
            url: "../controle/tipos_controller.php",
            data:{
               
                acao:acao,
                tipo:tipo,
                idTipo:idTipo,
               
               
            },
            
            success: function(result){
                alert(result);
               location.reload();
            }});

    });
});
function muda_status(statusTipo,idTipo){

    $.ajax({
        type:'POST',
        url: "../controle/tipos_controller.php",
        data:{
            acao:'alterar_status',
            status:statusTipo,
            idTipo:idTipo
        },
        
        success: function(result){
            alert(result);
            location.reload();
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
            idTipo:idTipo
        },

        success: function (result) {
          retorno=  JSON.parse(result)
            
          $('#modal').click();
          $('#descricaoTipo').val(retorno[0]['descricaoTipo']);
        
        console.log(result);
        }
    });

};


