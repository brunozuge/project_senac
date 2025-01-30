// Dados das mulheres
const women = [
    { id: 1, name: "Isabella Pattussi", image: "images/woman1.jpg", clicks: 0 },
    { id: 2, name: "Virginia Torres Henz", image: "images/woman2.jpg", clicks: 0 },
    { id: 3, name: "Ana Clara Hein", image: "images/woman3.jpg", clicks: 0 },
    { id: 4, name: "Ana Kraether", image: "images/woman4.jpg", clicks: 0 },
    { id: 5, name: "Mariah Spall", image: "images/woman5.jpg", clicks: 0 },
    { id: 6, name: "Larissa Sins", image: "images/woman6.jpg", clicks: 0 },
    { id: 7, name: "Sofia Lopes", image: "images/woman7.jpg", clicks: 0 },
    { id: 8, name: "Amanda Zilch Bernardes", image: "images/woman8.jpg", clicks: 0 },
    { id: 9, name: "Carolina Ertel", image: "images/woman9.jpg", clicks: 0 },
    { id: 10, name: "Paula Gehlen Voos", image: "images/woman10.jpg", clicks: 0 },
    { id: 11, name: "Rafaela Taina Stumm", image: "images/woman11.jpg", clicks: 0 },  
    { id: 12, name: "Grazi Cappellari", image: "images/woman12.jpg", clicks: 0 },
    { id: 13, name: "Raissa Dalastra Copetti", image: "images/woman13.jpg", clicks: 0 },
    { id: 14, name: "Vanessa Reuter Nepumoceno", image: "images/woman14.jpg", clicks: 0 },
    { id: 15, name: "Bianca Heinen", image: "images/woman15.jpg", clicks: 0 },
    { id: 16, name: "Leticia Pali", image: "images/woman16.jpg", clicks: 0 },
    { id: 17, name: "Lavinia Wendland", image: "images/woman17.jpg", clicks: 0 },
    { id: 18, name: "Ana Julia Nunes", image: "images/woman18.jpg", clicks: 0 },
    { id: 19, name: "Nicole Machado", image: "images/woman19.jpg", clicks: 0 },
    { id: 20, name: "Pietra Groto", image: "images/woman20.jpg", clicks: 0 },
    { id: 21, name: "Anna Carolina Schultz", image: "images/woman21.jpg", clicks: 0 },
    { id: 22, name: "Mari Hirsh", image: "images/woman22.jpg", clicks: 0 },
    { id: 23, name: "Laura Calliero", image: "images/woman23.jpg", clicks: 0 },
    { id: 24, name: "Valentina Heck", image: "images/woman24.jpg", clicks: 0 },
    { id: 25, name: "Jordana Hider", image: "images/woman25.jpg", clicks: 0 },
    { id: 26, name: "Gabi Gauterio", image: "images/woman26.jpg", clicks: 0 },
    { id: 27, name: "Luiza Vitória", image: "images/woman27.jpg", clicks: 0 },
   
    { id: 29, name: "Rebeca Fisher", image: "images/woman29.jpg", clicks: 0 },
    { id: 30, name: "Manuela Stumm", image: "images/woman30.jpg", clicks: 0 },
    { id: 31, name: "Bruna Agnes", image: "images/woman31.jpg", clicks: 0 },
    { id: 32, name: "Ana Reuter", image: "images/woman32.jpg", clicks: 0 },
    { id: 33, name: "Maria Grassi", image: "images/woman33.jpg", clicks: 0 },
    { id: 34, name: "Pietra Pellegrini", image: "images/woman34.jpg", clicks: 0 },
    { id: 35, name: "Bruna Larissa", image: "images/woman35.jpg", clicks: 0 },
    
    
];


let previousWomen = [];

// Código de autenticação
const AUTH_CODE = "bruno2003";  // Substitua isso por um código único

// Função para carregar os votos armazenados no localStorage
function loadVotes() {
    const storedVotes = JSON.parse(localStorage.getItem("votes"));
    if (storedVotes) {
        storedVotes.forEach((storedWoman) => {
            const woman = women.find((w) => w.id === storedWoman.id);
            if (woman) {
                woman.clicks = storedWoman.clicks;
            }
        });
    }
}

// Função para salvar os votos no localStorage
function saveVotes() {
    localStorage.setItem("votes", JSON.stringify(women));
}

// Função para resetar os votos
function resetVotes() {
    const userCode = prompt("Digite o código de autenticação para resetar os votos:");

    // Se o usuário clicar em "Cancelar" ou não digitar nada, a variável userCode será null ou uma string vazia
    if (userCode === null || userCode.trim() === "") {
        return; // Não faz nada se o usuário clicar em "Cancelar" ou não digitar nada
    }

    if (userCode === AUTH_CODE) {
        // Resetando os votos automaticamente sem necessidade de mais confirmação
        women.forEach((woman) => {
            woman.clicks = 0;
        });
        saveVotes(); // Salva os votos resetados

        // Atualiza a interface sem precisar recarregar a página
        showOptions(); // Exibe novas opções de mulheres
        showRanking(); // Atualiza e exibe o ranking após o reset

        alert("Votos resetados com sucesso!");
    } else {
        alert("Código incorreto. Você não tem permissão para resetar os votos.");
    }
}

// Função para salvar os votos no localStorage
function saveVotes() {
    localStorage.setItem("votes", JSON.stringify(women));
}

// Função para carregar os votos armazenados no localStorage
function loadVotes() {
    const storedVotes = JSON.parse(localStorage.getItem("votes"));
    if (storedVotes) {
        storedVotes.forEach((storedWoman) => {
            const woman = women.find((w) => w.id === storedWoman.id);
            if (woman) {
                woman.clicks = storedWoman.clicks;
            }
        });
    }
}

// Função para exibir as opções de mulheres
function showOptions() {
    const [woman1, woman2] = getRandomWomen();
    document.getElementById('option1').innerHTML = `<img src="${woman1.image}" alt="${woman1.name}">`;
    document.getElementById('option2').innerHTML = `<img src="${woman2.image}" alt="${woman2.name}">`;

    document.getElementById('option1').onclick = () => vote(woman1.id);
    document.getElementById('option2').onclick = () => vote(woman2.id);
}

// Função para obter duas mulheres aleatórias
function getRandomWomen() {
    const availableWomen = women.filter(
        (woman) => !previousWomen.includes(woman.id)
    );
    const shuffled = availableWomen.sort(() => 0.5 - Math.random());
    const selectedWomen = shuffled.slice(0, 2);

    previousWomen.push(selectedWomen[0].id, selectedWomen[1].id);
    if (previousWomen.length > 8) {
        previousWomen = previousWomen.slice(-8);
    }

    return selectedWomen;
}

// Função para registrar o voto
function vote(id) {
    const woman = women.find((w) => w.id === id);
    if (woman) {
        woman.clicks += 1;
    }
    saveVotes();  // Salva os votos após o registro
    showOptions();
}

// Função para exibir o ranking
function showRanking() {
    const sortedWomen = [...women].sort((a, b) => b.clicks - a.clicks);
    document.getElementById("rankingList").innerHTML = sortedWomen
        .map((w) => `<li>${w.name}: ${w.clicks} votos</li>`)
        .join("");
    document.getElementById("rankingModal").style.display = "block";
    // Exibe o botão de reset após o ranking ser aberto
    document.getElementById("resetVotesButton").style.display = "inline-block";
}

// Modal - fechar
const closeModal = document.querySelector(".close");
closeModal.onclick = () => {
    document.getElementById("rankingModal").style.display = "none";
    // Esconde o botão de reset quando o ranking for fechado
    document.getElementById("resetVotesButton").style.display = "none";
};

window.onclick = (event) => {
    if (event.target === document.getElementById("rankingModal")) {
        document.getElementById("rankingModal").style.display = "none";
        // Esconde o botão de reset quando o ranking for fechado
        document.getElementById("resetVotesButton").style.display = "none";
    }
};

// Inicializar
document.getElementById("rankingButton").addEventListener("click", showRanking);
document.getElementById("resetVotesButton").addEventListener("click", resetVotes);
// Função para exibir as opções de mulheres
function showOptions() {
    const [woman1, woman2] = getRandomWomen();
    document.getElementById('option1').innerHTML = `
        <img src="${woman1.image}" alt="${woman1.name}">
        <p>${woman1.name}</p>
    `;
    document.getElementById('option2').innerHTML = `
        <img src="${woman2.image}" alt="${woman2.name}">
        <p>${woman2.name}</p>
    `;

    document.getElementById('option1').onclick = () => vote(woman1.id);
    document.getElementById('option2').onclick = () => vote(woman2.id);
}

loadVotes();  // Carregar os votos ao iniciar
showOptions();  // Inicializa as opções de votação