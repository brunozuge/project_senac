<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-4 shadow-lg bg-dark text-white">
      <!-- Cabeçalho do Modal -->
      <div class="modal-header  bg-dark text-white border-bottom border-secondary">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Cadastrar Marca</h1>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- Corpo do Modal -->
      <div class="modal-body">
        <form id="form-cadastrar-marca">
          <div class="mb-3">
            <label for="descricaoMarca" class="form-label">Descrição da Marca</label>
            <input type="text" class="form-control bg-dark text-white" id="descricaoMarca" name="descricaoMarca" placeholder="Digite o nome da marca" required>
            <input type="hidden" class="form-control" id="idMarca">
          </div>
        </form>
      </div>
      <!-- Rodapé do Modal -->
      <div class="modal-footer bg-dark border-top border-secondary">
        <button type="reset" class="btn btn-secondary" form="form-cadastrar-marca">Limpar</button>
        <button type="button" class="btn btn-primary salvar" id="salvar">Salvar</button>
      </div>
    </div>
  </div>
</div>

<script>
  // Captura o formulário e o botão de salvar
  const form = document.getElementById('form-cadastrar-marca');
  const salvarButton = document.getElementById('salvar');

  // Adiciona um ouvinte de evento para o formulário
  form.addEventListener('keypress', function (event) {
    // Verifica se a tecla pressionada foi Enter (keyCode 13)
    if (event.key === 'Enter') {
      event.preventDefault(); // Previne o comportamento padrão do Enter
      salvarButton.click(); // Simula o clique no botão Salvar
    }
  });

  // Função para simular o envio do formulário
  salvarButton.addEventListener('click', function () {
    // Aqui você pode adicionar a lógica para salvar os dados
 
    // Exemplo: fechar o modal após o envio
    const modal = bootstrap.Modal.getInstance(document.getElementById('exampleModal'));
    modal.hide();
  });
</script>