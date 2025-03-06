// Função para alternar o tema
function toggleTheme() {
    const body = document.body;
    const navbar = document.querySelector('.navbar'); // Selecione a navbar
    body.classList.toggle('dark-mode');
    navbar.classList.toggle('navbar-dark-mode'); // Adiciona ou remove a classe da navbar

    // Salva a preferência no localStorage
    if (body.classList.contains('dark-mode')) {
        localStorage.setItem('theme', 'dark');
    } else {
        localStorage.setItem('theme', 'light');
    }
}

// Aplica o tema salvo ao carregar a página
document.addEventListener('DOMContentLoaded', () => {
    const savedTheme = localStorage.getItem('theme');
    const body = document.body;
    const navbar = document.querySelector('.navbar'); // Selecione a navbar

    if (savedTheme === 'dark') {
        body.classList.add('dark-mode');
        navbar.classList.add('navbar-dark-mode'); // Aplica a classe na navbar ao recarregar a página
    } else {
        body.classList.remove('dark-mode');
        navbar.classList.remove('navbar-dark-mode');
    }

    
});
