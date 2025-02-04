$(document).ready(function () {
    let ativo = $("#ativo");
    let marca = $("#marca");
    let tipo = $("#tipo");

    // Função para atualizar os campos com base nas seleções
    const atualizarCampos = () => {
        const ativoValor = ativo.val();
        const marcaValor = marca.val();
        const tipoValor = tipo.val();

        // Se "ativo" for selecionado, desabilita "marca" e "tipo"
        if (ativoValor !== '' && ativoValor !== 'todos') {
            marca.prop('disabled', true).val(''); // Desabilita e limpa a seleção de marca
            tipo.prop('disabled', true).val(''); // Desabilita e limpa a seleção de tipo
        } 
        // Se "marca" for selecionada, desabilita "ativo" e "tipo"
        else if (marcaValor !== '' && marcaValor !== 'todas') {
            ativo.prop('disabled', true).val(''); // Desabilita e limpa a seleção de ativo
            tipo.prop('disabled', true).val(''); // Desabilita e limpa a seleção de tipo
        } 
        // Se "tipo" for selecionado, desabilita "ativo" e "marca"
        else if (tipoValor !== '' && tipoValor !== 'todos') {
            ativo.prop('disabled', true).val(''); // Desabilita e limpa a seleção de ativo
            marca.prop('disabled', true).val(''); // Desabilita e limpa a seleção de marca
        } 
        // Caso nenhum dos campos esteja preenchido, habilita todos
        else {
            ativo.prop('disabled', false);
            marca.prop('disabled', false);
            tipo.prop('disabled', false);
        }
    };

    // Evento de mudança no campo "ativo"
    ativo.change(function () {
        if ($(this).val() !== '' && $(this).val() !== 'todos') {
            marca.prop('disabled', true).val(''); // Desabilita e limpa a seleção de marca
            tipo.prop('disabled', true).val(''); // Desabilita e limpa a seleção de tipo
        } else {
            marca.prop('disabled', false); // Habilita marca
            tipo.prop('disabled', false); // Habilita tipo
        }
        atualizarCampos(); // Atualiza os campos
    });

    // Evento de mudança no campo "marca"
    marca.change(function () {
        if ($(this).val() !== '' && $(this).val() !== 'todas') {
            ativo.prop('disabled', true).val(''); // Desabilita e limpa a seleção de ativo
            tipo.prop('disabled', true).val(''); // Desabilita e limpa a seleção de tipo
        } else {
            ativo.prop('disabled', false); // Habilita ativo
            tipo.prop('disabled', false); // Habilita tipo
        }
        atualizarCampos(); // Atualiza os campos
    });

    // Evento de mudança no campo "tipo"
    tipo.change(function () {
        if ($(this).val() !== '' && $(this).val() !== 'todos') {
            ativo.prop('disabled', true).val(''); // Desabilita e limpa a seleção de ativo
            marca.prop('disabled', true).val(''); // Desabilita e limpa a seleção de marca
        } else {
            ativo.prop('disabled', false); // Habilita ativo
            marca.prop('disabled', false); // Habilita marca
        }
        atualizarCampos(); // Atualiza os campos
    });

    // Chama a função ao carregar a página
    atualizarCampos();
});

// Função para limpar o formulário
function limpar_modal() {
    $("#ativo").prop('disabled', false).val('');
    $("#marca").prop('disabled', false).val('');
    $("#tipo").prop('disabled', false).val('');
    $("#data_inicial").val('');
    $("#data_final").val('');
    $("#usuario").val('');
    $("#tipo_movimentacao").val('');
}