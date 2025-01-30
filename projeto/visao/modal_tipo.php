
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-4 shadow-lg">
      <!-- Cabeçalho do Modal -->
      <div class="modal-header bg-primary text-white">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Cadastrar Tipo</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Corpo do Modal -->
      <div class="modal-body">
        <form id="form-cadastrar-tipo">
          <div class="mb-3">
            <label for="descricaoTipo" class="form-label">Descrição do Tipo</label>
            <input type="text" class="form-control" id="descricaoTipo" name="descricaoTipo" placeholder="Digite o tipo" required>
            <input type="hidden" class="form-control" id="idTipo" >
          </div>
        </form>
      </div>

      <!-- Rodapé do Modal -->
      <div class="modal-footer">
        <button type="reset" class="btn btn-secondary" form="form-cadastrar-tipo">Limpar</button>
        <button type="button" class="btn btn-primary salvar" id="salvar" class="salvar">Salvar</button>
      </div>
    </div>
  </div>
</div>
