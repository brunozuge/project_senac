<?php

include_once('../controle/controle_session.php');
include_once('../modelo/conexao.php');
include_once('../controle/funcoes.php');
$tipos=busca_info_bd($conexao,'tipo');
$title = "Tipos";
include_once("senac.html");
    include_once('modal_tipo.php');
include ('navbar.php');

?>
<script src="../js/tipos.js"></script>
<body>
<div class="d-flex justify-content-center mt-4">
    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" id="modal">Abrir Modal</button>
</div>
<div class="container mt-5">
   

    <!-- Tabela com os ativos -->
    <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Tipo</th>
               
               
              
                <th scope="col">Data de Cadastro</th>
                <th scope="col">Usuário</th>
                <th style="text-align:center;">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($tipos as $tipo) {?>
                <tr>
                    <td><?php echo $tipo['idTipo']; ?></td>
                    <td><?php echo $tipo['descricaoTipo']; ?></td>
              
               
                    
                   
                    <td><?php echo date("d/m/Y H:i:s", strtotime($tipo['dataCadastro'])); ?></td>
                    <td><?php echo $tipo['usuarioCadastro']; ?></td>
                    <td>
                                <div class="acoes" style="display: flex;justify-content: space-between">
                                    <div class="muda_status">

                                        <?php
                                        if ($tipo['statusTipo'] == "S") {
                                            ?>

                                            <div class="inativo" onclick="muda_status('N','<?php echo $tipo['idTipo']; ?>')">
                                                <i class="bi bi-toggle-on"></i>

                                            </div>

                                            <?php
                                        } else {
                                            ?>

                                            <div class="ativo" onclick="muda_status('S', '<?php echo $tipo['idTipo']; ?>')">
                                                <i class="bi bi-toggle-off"></i>

                                            </div>

                                            <?php
                                        }
                                        ?>

                                    </div>

                                    <div class="edit" onclick="edita('<?php echo $tipo['idTipo']; ?>')">
                                        <i class="bi bi-pencil-square"></i>

                                    </div>
                                </div>
                            </td>
                        </tr>

                                  

                                   
                                 

                                  

                                    <?php
                                    }
                                    ?>

                               
           
            </div>
            <input type="hidden" id="idTipo" name="idTipo">
                </td> </tr>
           
</body>



<div class="container mt-5">
    <h2 class="mt-4">Lista de Tipos</h2>

   