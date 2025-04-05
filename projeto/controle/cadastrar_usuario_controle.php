<?php
include ('../modelo/conexao.php');
$nome = $_POST['nome'];
$usuario = $_POST['usuario'];
$senha = $_POST['senha'];
$turma = $_POST['turma'];
$cargo ='1';

//echo "Usuário cadastrado com suceso!!!<br>"."Nome: ".$nome."<br>"."Usuario: ". $usuario."<br>"."Turma: ".$turma."<br>";

$senhaC = base64_encode($senha);


 $querry="
            insert into usuario (
                                nomeUsuario,
                                usuario,
                                senhaUsuario,
                                turmaUsuario,
                                dataCadastro,
                                idCargo
                                )values ('".$nome."',
                                '".$usuario. "',
                                '".$senhaC. "',
                                '".$turma. "',
                               
                                    NOW(),
                                    '$cargo'
                                    )";

$result = mysqli_query($conexao,$querry)or die(false);
if($result){
    echo"<script> alert ('usuario cadastrado')
    window.location.href = '../visao/listar_usuario.php'
 </script>";
}
else{
    echo"<script> alert ('usuario cadastrado');
   window.location.href = '../visao/cadastro.php'</script>";
}


?>