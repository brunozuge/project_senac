<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-4 shadow-lg bg-dark text-white">
      <!-- Cabeçalho do Modal -->
      <div class="modal-header bg-dark text-white border-bottom border-secondary">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Cadastrar Ativo</h1>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- Corpo do Modal -->
      <div class="modal-body">
        <form id="form-cadastrar-ativo">
        <div class="mb-3">
    <label for="idAtivo" class="form-label">ID Ativo</label>
    <input class="form-control bg-dark text-white" type="text" id="idAtivo" readonly>
</div>

          <div class="mb-3">
            <label for="ativo" class="form-label">Descrição do Ativo</label>
            <input type="text" class="form-control bg-dark text-white" id="ativo" placeholder="Digite a descrição do ativo" required>
          </div>
          <div class="mb-3">
            <label for="marca" class="form-label">Marca</label>
            <select class="form-select bg-dark text-white" id="marca" required>
              <option selected disabled>Selecione a Marca</option>
              <?php
              foreach ($marcas as $marca) {
                echo '<option value="' . $marca['idMarca'] . '">' . $marca['descricaoMarca'] . '</option>';
              }
              ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="tipo" class="form-label">Tipo</label>
            <select class="form-select bg-dark text-white" id="tipo" required>
              <option selected disabled>Selecione o Tipo</option> 
              <?php
              foreach ($tipos as $tipo) {
                echo '<option value="' . $tipo['idTipo'] . '">' . $tipo['descricaoTipo'] . '</option>';
              }
              ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="quantidade" class="form-label">Quantidade</label>
            <input type="number" class="form-control bg-dark text-white" id="quantidade" placeholder="Quantidade do ativo" required>
          </div>
          <div class="mb-3">
            <label for="quantidadeMin" class="form-label">Quantidade Min</label>
            <input type="number" class="form-control bg-dark text-white" id="quantidadeMin" placeholder="Quantidade mínima do ativo" required>
          </div>
          <div class="mb-3">
            <label for="observacao" class="form-label">Observação</label>
            <input type="text" class="form-control bg-dark text-white" id="observacao" placeholder="Observações adicionais">
          </div>
        </form>
        <div class="mb-3">
          <label for="formFile" class="form-label">Imagem Ativo</label>
          <input class="form-control bg-dark text-white" accept="image/png, image/jpeg" type="file" id="imgAtivo">
        </div>
        
      </div>
      <div class="mb-3" id="divPreview">
        <label for="formFile" class="form-label"></label>
        <img id="imgPreview" style="width: 400px; height: 400px;">
      </div>
      <!-- Rodapé do Modal -->
      <div class="modal-footer bg-dark border-top border-secondary">
        <button type="reset" class="btn btn-secondary">Limpar</button>
        <button type="button" class="btn btn-primary" id="salvar_info">Salvar</button>
      </div>
    </div>
  </div>
</div>

<script>
  // Captura o formulário e o botão de salvar
  const form = document.getElementById('form-cadastrar-ativo');
  const salvarButton = document.getElementById('salvar_info');

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