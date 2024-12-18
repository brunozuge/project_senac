const easyCapitals = {
    "Brasília": "Brasil",
    "Buenos Aires": "Argentina",
    "Paris": "França",
    "Lisboa": "Portugal",
    "Berlim": "Alemanha",
    "Madri": "Espanha",
    "Roma": "Itália",
    "Londres": "Reino Unido",
    "Tóquio": "Japão",
    "Canberra": "Austrália",
    "Ottawa": "Canadá",
    "Pequim": "China",
    "Moscou": "Rússia",
    "Washington, D.C.": "Estados Unidos",
    "Cidade do México": "México",
    "Nova Délhi": "Índia",
    "Seul": "Coreia do Sul",
    "Pretória": "África do Sul",
    "Santiago": "Chile",
    "Bogotá": "Colômbia",
};

const hardCapitals = {
    "Astana": "Cazaquistão",
    "Dushanbe": "Tadjiquistão",
    "Bishkek": "Quirguistão",
    "Ashgabat": "Turcomenistão",
    "Malabo": "Guiné Equatorial",
    "Nouakchott": "Mauritânia",
    "N'Djamena": "Chade",
    "Funafuti": "Tuvalu",
    "Porto Novo": "Benin",
    "Ouagadougou": "Burkina Faso",
    "Thimphu": "Butão",
    "Apia": "Samoa",
    "Banjul": "Gâmbia",
    "Porto Moresby": "Papua-Nova Guiné",
    "Honiara": "Ilhas Salomão",
    "Bujumbura": "Burundi",
    "Yamoussoukro": "Costa do Marfim",
    "Lomé": "Togo",
    "Libreville": "Gabão",
    "Lilongwe": "Malawi",
};

let score = 0;
let currentCapital;
let selectedCapitals;

function getRandomCapital(capitals) {
    const capitalsArray = Object.keys(capitals);
    return capitalsArray[Math.floor(Math.random() * capitalsArray.length)];
}

function startGame() {
    currentCapital = getRandomCapital(selectedCapitals);
    document.getElementById('capital-name').textContent = currentCapital;
    document.getElementById('answer-input').value = '';
    document.getElementById('message').textContent = '';
}

document.getElementById('easy-button').addEventListener('click', () => {
    selectedCapitals = easyCapitals;
    document.getElementById('difficulty-selection').style.display = 'none';
    document.getElementById('game').style.display = 'block';
    startGame();
});

document.getElementById('hard-button').addEventListener('click', () => {
    selectedCapitals = hardCapitals;
    document.getElementById('difficulty-selection').style.display = 'none';
    document.getElementById('game').style.display = 'block';
    startGame();
});

document.getElementById('submit-answer').addEventListener('click', () => {
    const userAnswer = normalizeText(document.getElementById('answer-input').value);
    const correctAnswer = normalizeText(selectedCapitals[currentCapital]);

    if (userAnswer === correctAnswer) {
        score++;
        showNotification(`Correto! A capital de ${correctAnswer.charAt(0).toUpperCase() + correctAnswer.slice(1)} é ${currentCapital}.`, 'success');
    } else {
        showNotification(`Errado! A capital de ${correctAnswer.charAt(0).toUpperCase() + correctAnswer.slice(1)} é ${currentCapital}.`, 'error');
    }

    document.getElementById('score').textContent = `Pontuação: ${score}`;
    startGame();
});

function normalizeText(text) {
    return text
        .toLowerCase()
        .normalize("NFD")
        .replace(/[\u0300-\u036f]/g, "");
}

function showNotification(message, type) {
    const notification = document.getElementById('notification');
    notification.textContent = message;
    notification.className = (type === 'error') ? 'error show' : 'show';

    setTimeout(() => {
        notification.className = 'hidden';
    }, 3000);
}
