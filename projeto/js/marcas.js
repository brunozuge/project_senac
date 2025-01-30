
$(document).ready(function () {
    $(".salvar").click(function () {

        let marca= $("#descricaoMarca").val();
       let idMarca = $("#idMarca").val();



        if(idMarca == ""){
            acao='inserir';
        } else {
            acao='update';
        }

        $.ajax({
            type:'POST',
            url: "../controle/marcas_controller.php",
            data:{
               
                acao:acao,
                marca:marca,
                idMarca:idMarca,
               
               
            },
            
            success: function(result){
                alert(result);
               location.reload();
            }});

    });
});
function muda_status(statusMarca,idMarca){

    $.ajax({
        type:'POST',
        url: "../controle/marcas_controller.php",
        data:{
            acao:'alterar_status',
            status:statusMarca,
            idMarca:idMarca
        },
        
        success: function(result){
            alert(result);
            location.reload();
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
            idMarca:idMarca
        },

        success: function (result) {
          retorno=  JSON.parse(result)
            
          $('#modal').click();
          $('#descricaoMarca').val(retorno[0]['descricaoMarca']);
          $('#idMarca').val(retorno[0]['idMarca']);
        
        console.log(result);
        }
    });

};


