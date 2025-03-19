<!-- Modal para cadastro e edição de opções -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-4 shadow-lg bg-dark text-white">
      <!-- Cabeçalho do Modal -->
      <div class="modal-header bg-dark text-white border-bottom border-secondary">
        <h5 class="modal-title" id="exampleModalLabel">Cadastro de Opção</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- Corpo do Modal -->
      <div class="modal-body">
        <form id="formOpcao">
          <div class="mb-3">
            <label for="descricaoOpcao" class="form-label">Descrição da Opção</label>
            <input type="text" class="form-control bg-dark text-white" id="descricaoOpcao" name="descricaoOpcao" required>
          </div>
        </form>
      </div>
      
      <!-- Rodapé do Modal -->
      <div class="modal-footer bg-dark border-top border-secondary">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary" form="formOpcao">Salvar</button>
      </div>
    </div>
  </div>
</div>
