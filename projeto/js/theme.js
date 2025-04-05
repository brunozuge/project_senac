// Função para alternar o tema
function toggleTheme() {
    const body = document.body;
    const navbar = document.querySelector('.navbar'); // Seleciona a navbar

    // Alterna as classes de tema no body e na navbar
    body.classList.toggle('dark-mode');
    navbar.classList.toggle('navbar-dark-mode');

    // Salva a preferência no localStorage com base no estado atual
    const isDarkMode = body.classList.contains('dark-mode');
    localStorage.setItem('theme', isDarkMode ? 'dark' : 'light');
}

// Aplica o tema salvo ao carregar a página
document.addEventListener('DOMContentLoaded', () => {
    const savedTheme = localStorage.getItem('theme') || 'light'; // Define 'light' como padrão se não houver preferência salva
    const body = document.body;
    const navbar = document.querySelector('.navbar'); // Seleciona a navbar

    // Aplica o tema salvo
    if (savedTheme === 'dark') {
        body.classList.add('dark-mode');
        navbar.classList.add('navbar-dark-mode');
    } else {
        body.classList.remove('dark-mode');
        navbar.classList.remove('navbar-dark-mode');
    }
});