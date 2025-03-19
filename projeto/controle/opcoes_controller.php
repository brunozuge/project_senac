<?php

    include('controle_session.php');
    include('classe_opcoes.php');
    include('../modelo/conexao.php');

    $acao=$_POST ['acao'];
 $classeOpcoes= new opcoes();
    if($acao=='insert'){
        $classeOpcoes->insert($conexao,$valor1,$valor2,$valor3)
    }






?>