

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-4 shadow-lg">
      <!-- Cabeçalho do Modal -->
      <div class="modal-header bg-primary text-white">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Cadastrar Ativo</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <!-- Corpo do Modal -->
      <div class="modal-body">
        <form id="form-cadastrar-ativo">
          <div class="mb-3">
            <label for="ativo" class="form-label">Descrição do Ativo</label>
            <input type="text" class="form-control" id="ativo" placeholder="Digite a descrição do ativo" required>
          </div>
          <div class="mb-3">
            <label for="marca" class="form-label">Marca</label>
            <select class="form-select" id="marca" required> 
              <option selected disabled>Selecione a Marca</option> 
              <?php 
              foreach ($marcas as $marca){
                echo '<option value="'.$marca['idMarca'].'">'.$marca['descricaoMarca'].'</option>';
              }
              ?>
              
            </select>
          </div>
          <div class="mb-3">
            <label for="tipo" class="form-label">Tipo</label>
            <select class="form-select" id="tipo" required>
              <option selected disabled>Selecione o Tipo</option> <?php 
              foreach ($tipos as $tipo){
                echo '<option value="'.$tipo['idTipo'].'">'.$tipo['descricaoTipo'].'</option>';
              }
              ?>
             
            </select>
          </div>
          <div class="mb-3">
            <label for="quantidade" class="form-label">Quantidade</label>
            <input type="number" class="form-control" id="quantidade" placeholder="Quantidade do ativo" required>
          </div>
          <div class="mb-3">
            <label for="observacao" class="form-label">Observação</label>
            <input type="text" class="form-control" id="observacao" placeholder="Observações adicionais">
          </div>
        </form>
      </div>
      
      <!-- Rodapé do Modal -->
      <div class="modal-footer">
        <button type="reset" class="btn btn-secondary" form="form-cadastrar-ativo">Limpar</button>
        <button type="button" class="btn btn-primary " form="form-cadastrar-ativo" id="salvar_info">Salvar</button>
      </div>
    </div>
  </div>
</div>


