// Função para validar a senha antes de enviar o formulário
function validarSenha() {
    // Obtém o valor da senha do campo de entrada
    const senha = document.getElementById("senha").value;

    // Verifica se a senha tem pelo menos 8 caracteres
    if (senha.length < 8) {
        alert("A senha deve ter pelo menos 8 caracteres.");
        return false;
    }

    // Verifica se a senha contém pelo menos um número
    const temNumero = /[0-9]/.test(senha);
    if (!temNumero) {
        alert("A senha deve conter pelo menos um número.");
        return false;
    }

    // Verifica se a senha contém pelo menos uma letra
    const temLetra = /[a-zA-Z]/.test(senha);
    if (!temLetra) {
        alert("A senha deve conter pelo menos uma letra.");
        return false;
    }

    // Verifica se a senha contém pelo menos um caractere especial
    const temCaractereEspecial = /[!@#$%^&*(),.?":{}|<>]/.test(senha);
    if (!temCaractereEspecial) {
        alert("A senha deve conter pelo menos um caractere especial.");
        return false;
    }

    // Se todas as validações passarem, permite o envio do formulário
    return true;
}

// Adiciona um ouvinte de evento para o formulário
document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    if (form) {
        form.addEventListener("submit", function (event) {
            if (!validarSenha()) {
                event.preventDefault(); // Impede o envio do formulário se a validação falhar
            }
        });
    }
});
function validarSenha() {
    const novaSenha = document.getElementById("novaSenha").value;
    const confirmarSenha = document.getElementById("confirmarSenha").value;

    // Verifica se a nova senha tem pelo menos 8 caracteres
    if (novaSenha.length < 8) {
        alert("A nova senha deve ter pelo menos 8 caracteres.");
        return false;
    }

    // Verifica se a nova senha contém pelo menos um número
    const temNumero = /[0-9]/.test(novaSenha);
    if (!temNumero) {
        alert("A nova senha deve conter pelo menos um número.");
        return false;
    }

    // Verifica se a nova senha contém pelo menos uma letra
    const temLetra = /[a-zA-Z]/.test(novaSenha);
    if (!temLetra) {
        alert("A nova senha deve conter pelo menos uma letra.");
        return false;
    }

    // Verifica se a nova senha contém pelo menos um caractere especial
    const temCaractereEspecial = /[!@#$%^&*(),.?":{}|<>]/.test(novaSenha);
    if (!temCaractereEspecial) {
        alert("A nova senha deve conter pelo menos um caractere especial.");
        return false;
    }

    // Verifica se a nova senha e a confirmação coincidem
    if (novaSenha !== confirmarSenha) {
        alert("A nova senha e a confirmação não coincidem.");
        return false;
    }

    // Se todas as validações passarem, permite o envio do formulário
    return true;
}