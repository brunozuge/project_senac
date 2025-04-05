<style>
  .modal-content {
    background-color: #343a40; /* Cinza escuro */
    color: white;
  }
  .form-control, .form-select {
    background-color: #495057; /* Cinza médio escuro */
    color: white;
    border: 1px solid #6c757d; /* Borda cinza */
  }
  .form-control::placeholder {
    color: #ced4da;
  }
  .form-control:focus, .form-select:focus {
    background-color: #5a6268;
    color: white;
    border-color: #868e96;
  }
  .modal-header, .modal-footer {
    background-color: #212529; /* Preto quase puro */
    border-color: #495057;
  }
  .btn-secondary {
    background-color: #6c757d;
    border-color: #545b62;
  }
  .btn-primary {
    background-color: #004085; /* Azul escuro */
    border-color: #002752;
  }
  .btn-primary:hover {
    background-color: #002752;
  }
</style>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Cadastrar Opções</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-1">
            <label for="descricaoOpcao" class="col-form-label"><span class="text-danger">*</span>Descrição Opção:</label>
            <input type="text" class="form-control" id="descricaoOpcao">
          </div>
          <div class="mb-1">
            <label for="nivelOpcao" class="col-form-label"><span class="text-danger">*</span>Nível Opção:</label>
            <select class="form-select" id="nivelOpcao" onchange="exibeSuperior(this)">
              <option selected disabled value="">Selecione a Opção</option>
              <?php
                foreach($niveis as $nivel){
                  echo '<option value="'.$nivel['idNivel'].'">'.$nivel['descricaoNivel'].'</option>';
                }
              ?>
            </select>
          </div>
          <div class="mb-1 divSuperior" style="display:none;">
            <label for="recipient-name" class="col-form-label">Superior</label>
            <div id = "select"> </div>
          </div>
          <div class="mb-1">
            <label for="urlOpcao" class="col-form-label">URL Opção:</label>
            <input type="text" class="form-control" id="urlOpcao">
          </div>
        
          <div>
            <label class="text-danger"><span>*</span> Campos Obrigatórios!!</label>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn btn-secondary">Limpar</button>
            <button type="button" class="btn btn-primary salvar">Salvar</button>
          </div>
          <input type="hidden" class="form-control" id="idOpcao">
        </form>
      </div>
    </div>
  </div>
</div>
