// main.js - Script principal para o Mega Cassino

document.addEventListener('DOMContentLoaded', function() {
    // Inicializar todos os componentes
    initCategoryTabs();
    initSlotMachine();
    initFAQs();
    initChatSupport();
    initGameCards();
    loadUserData();
});

// Sistema de navegação por categorias
function initCategoryTabs() {
    const categoryTabs = document.querySelectorAll('.category-tab');
    const gameCards = document.querySelectorAll('.game-card');
    
    categoryTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            // Remover classe active de todas as tabs
            categoryTabs.forEach(t => t.classList.remove('active'));
            
            // Adicionar classe active na tab clicada
            tab.classList.add('active');
            
            // Filtrar jogos por categoria
            const category = tab.textContent.toLowerCase();
            
            if (category === 'todos') {
                gameCards.forEach(card => {
                    card.style.display = 'block';
                });
            } else {
                gameCards.forEach(card => {
                    const gameCategory = card.getAttribute('data-category').toLowerCase();
                    card.style.display = gameCategory === category ? 'block' : 'none';
                });
            }
        });
    });
}

// Animação e lógica do caça-níquel
function initSlotMachine() {
    const spinBtn = document.querySelector('.spin-btn');
    if (!spinBtn) return;
    
    spinBtn.addEventListener('click', function() {
        const reels = document.querySelectorAll('.reel');
        const symbols = ['🍒', '🍋', '🍇', '🍉', '💎', '7️⃣', '🎰'];
        let spinning = true;
        
        // Desabilitar botão durante a rotação
        spinBtn.disabled = true;
        spinBtn.textContent = 'GIRANDO...';
        
        // Girar cada rolo com um pequeno atraso entre eles
        reels.forEach((reel, index) => {
            reel.style.animation = 'none';
            
            setTimeout(() => {
                reel.style.animation = `spin ${0.5 + index * 0.2}s ease-out`;
                
                setTimeout(() => {
                    const randomSymbol = symbols[Math.floor(Math.random() * symbols.length)];
                    reel.textContent = randomSymbol;
                    
                    // Quando o último rolo parar
                    if (index === reels.length - 1) {
                        spinning = false;
                        spinBtn.disabled = false;
                        spinBtn.textContent = 'GIRAR';
                        
                        // Verificar combinação vencedora
                        checkWinningCombination(reels);
                    }
                }, (0.5 + index * 0.2) * 1000);
            }, 10);
        });
    });
}

// Verificar se há uma combinação vencedora
function checkWinningCombination(reels) {
    const symbols = Array.from(reels).map(reel => reel.textContent);
    
    // Se todos os símbolos são iguais
    if (symbols.every(s => s === symbols[0])) {
        showWinMessage('JACKPOT!!! Você ganhou!');
        
        // Adicionar efeito de celebração
        document.querySelector('.jackpot-section').classList.add('celebration');
        setTimeout(() => {
            document.querySelector('.jackpot-section').classList.remove('celebration');
        }, 3000);
    }
    // Se há pelo menos dois símbolos iguais
    else if (symbols[0] === symbols[1] || symbols[1] === symbols[2] || symbols[0] === symbols[2]) {
        showWinMessage('Parabéns! Você ganhou um prêmio menor.');
    }
}

// Mostrar mensagem de vitória
function showWinMessage(message) {
    // Criar elemento de mensagem
    const winMessage = document.createElement('div');
    winMessage.className = 'win-message';
    winMessage.textContent = message;
    
    // Adicionar ao DOM
    document.querySelector('.jackpot-section').appendChild(winMessage);
    
    // Remover após alguns segundos
    setTimeout(() => {
        winMessage.remove();
    }, 3000);
}

// Inicializar sistema de perguntas frequentes
function initFAQs() {
    document.querySelectorAll('.faq-question').forEach(question => {
        question.addEventListener('click', () => {
            // Toggle para a resposta
            const answer = question.nextElementSibling;
            
            // Fechar outras respostas abertas
            document.querySelectorAll('.faq-answer').forEach(a => {
                if (a !== answer) a.classList.remove('open');
            });
            
            // Alternar a resposta atual
            answer.classList.toggle('open');
            
            // Alternar ícone de + para -
            question.classList.toggle('active');
        });
    });
}

// Inicializar chat de suporte
function initChatSupport() {
    const chatButton = document.querySelector('.chat-support');
    if (!chatButton) return;
    
    chatButton.addEventListener('click', () => {
        // Verificar se o chat já está aberto
        let chatWindow = document.querySelector('.chat-window');
        
        if (chatWindow) {
            // Se já existe, apenas alternar visibilidade
            chatWindow.classList.toggle('hidden');
        } else {
            // Criar janela de chat
            chatWindow = document.createElement('div');
            chatWindow.className = 'chat-window';
            chatWindow.innerHTML = `
                <div class="chat-header">
                    <h3>Suporte ao Cliente</h3>
                    <button class="close-chat">&times;</button>
                </div>
                <div class="chat-messages">
                    <div class="message support">
                        <div class="message-content">
                            Olá! Como posso ajudar você hoje?
                        </div>
                        <div class="message-time">Agora</div>
                    </div>
                </div>
                <div class="chat-input">
                    <input type="text" placeholder="Digite sua mensagem...">
                    <button>Enviar</button>
                </div>
            `;
            
            document.body.appendChild(chatWindow);
            
            // Remover notificação
            const notification = document.querySelector('.notification');
            if (notification) notification.remove();
            
            // Adicionar evento para fechar o chat
            chatWindow.querySelector('.close-chat').addEventListener('click', () => {
                chatWindow.classList.add('hidden');
            });
            
            // Adicionar evento para enviar mensagem
            const chatInput = chatWindow.querySelector('.chat-input input');
            const sendButton = chatWindow.querySelector('.chat-input button');
            
            function sendMessage() {
                const message = chatInput.value.trim();
                if (message) {
                    const messagesContainer = chatWindow.querySelector('.chat-messages');
                    const now = new Date();
                    const timeStr = `${now.getHours()}:${now.getMinutes().toString().padStart(2, '0')}`;
                    
                    messagesContainer.innerHTML += `
                        <div class="message user">
                            <div class="message-content">${message}</div>
                            <div class="message-time">${timeStr}</div>
                        </div>
                    `;
                    
                    chatInput.value = '';
                    
                    // Rolar para a parte inferior
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                    
                    // Simular resposta automática após 1 segundo
                    setTimeout(() => {
                        messagesContainer.innerHTML += `
                            <div class="message support">
                                <div class="message-content">
                                    Obrigado por entrar em contato. Um atendente responderá em breve.
                                </div>
                                <div class="message-time">${timeStr}</div>
                            </div>
                        `;
                        messagesContainer.scrollTop = messagesContainer.scrollHeight;
                    }, 1000);
                }
            }
            
            sendButton.addEventListener('click', sendMessage);
            chatInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') sendMessage();
            });
        }
    });
}

// Inicializar cards de jogos
function initGameCards() {
    const gameCards = document.querySelectorAll('.game-card');
    
    gameCards.forEach(card => {
        const playButton = card.querySelector('.play-now-btn');
        
        playButton.addEventListener('click', () => {
            const gameTitle = card.querySelector('.game-title').textContent;
            const gameId = card.getAttribute('data-game-id');
            
            // Iniciar o jogo
            launchGame(gameId, gameTitle);
        });
    });
}

// Função para carregar dados do usuário
function loadUserData() {
    // Verificar se o usuário está logado (verificando localStorage ou cookies)
    const userData = localStorage.getItem('megaCassinoUser');
    
    if (userData) {
        const user = JSON.parse(userData);
        updateUserInterface(user);
    }
}

// Atualizar interface com dados do usuário
function updateUserInterface(user) {
    const userMenu = document.querySelector('.user-menu');
    
    // Remover botões de login/registro
    userMenu.innerHTML = `
        <div class="user-profile">
            <div class="user-balance">R$ ${user.balance.toFixed(2)}</div>
            <div class="user-avatar">${user.username.charAt(0)}</div>
            <div class="user-dropdown">
                <ul>
                    <li><a href="#profile">Meu Perfil</a></li>
                    <li><a href="#deposit">Depositar</a></li>
                    <li><a href="#withdraw">Sacar</a></li>
                    <li><a href="#history">Histórico</a></li>
                    <li><a href="#" id="logout-btn">Sair</a></li>
                </ul>
            </div>
        </div>
    `;
    
    // Adicionar evento para logout
    document.getElementById('logout-btn').addEventListener('click', (e) => {
        e.preventDefault();
        localStorage.removeItem('megaCassinoUser');
        location.reload();
    });
    
    // Adicionar evento para mostrar/ocultar dropdown
    const userAvatar = document.querySelector('.user-avatar');
    const userDropdown = document.querySelector('.user-dropdown');
    
    userAvatar.addEventListener('click', () => {
        userDropdown.classList.toggle('show');
    });
    
    // Fechar dropdown ao clicar fora
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.user-profile')) {
            userDropdown.classList.remove('show');
        }
    });
}

// Função para lançar um jogo
function launchGame(gameId, gameTitle) {
    // Verificar se o usuário está logado
    const userData = localStorage.getItem('megaCassinoUser');
    
    if (!userData) {
        // Mostrar modal de login
        showLoginModal();
        return;
    }
    
    // Criar modal do jogo
    const gameModal = document.createElement('div');
    gameModal.className = 'game-modal';
    gameModal.innerHTML = `
        <div class="game-modal-content">
            <div class="game-modal-header">
                <h2>${gameTitle}</h2>
                <button class="close-game">&times;</button>
            </div>
            <div class="game-container" id="game-container-${gameId}">
                <div class="game-loading">
                    <div class="spinner"></div>
                    <p>Carregando jogo...</p>
                </div>
            </div>
        </div>
    `;
    
    document.body.appendChild(gameModal);
    
    // Prevenir rolagem do body
    document.body.style.overflow = 'hidden';
    
    // Adicionar evento para fechar o jogo
    gameModal.querySelector('.close-game').addEventListener('click', () => {
        gameModal.remove();
        document.body.style.overflow = '';
    });
    
    // Carregar o jogo específico com base no ID
    loadGameById(gameId);
}

// Carregar jogo pelo ID
function loadGameById(gameId) {
    // Aqui você pode fazer uma chamada AJAX para carregar o jogo
    // ou simplesmente carregar um script específico

    // Simulação de carregamento
    setTimeout(() => {
        const gameContainer = document.getElementById(`game-container-${gameId}`);
        
        // Remover spinner de carregamento
        gameContainer.querySelector('.game-loading').remove();
        
        // Carregar o jogo específico baseado no ID
        switch(gameId) {
            case 'fortune-tiger':
                loadFortuneTigerGame(gameContainer);
                break;
            case 'aviator':
                loadAviatorGame(gameContainer);
                break;
            case 'mines':
                loadMinesGame(gameContainer);
                break;
            case 'spaceman':
                loadSpacemanGame(gameContainer);
                break;
            default:
                gameContainer.innerHTML = '<p>Jogo não encontrado ou em manutenção.</p>';
        }
    }, 1500);
}

// Mostrar modal de login
function showLoginModal() {
    const loginModal = document.createElement('div');
    loginModal.className = 'login-modal';
    loginModal.innerHTML = `
        <div class="login-modal-content">
            <div class="login-modal-header">
                <h2>Entrar na sua conta</h2>
                <button class="close-login">&times;</button>
            </div>
            <div class="login-form">
                <div class="form-group">
                    <label for="login-email">E-mail</label>
                    <input type="email" id="login-email" placeholder="Seu e-mail">
                </div>
                <div class="form-group">
                    <label for="login-password">Senha</label>
                    <input type="password" id="login-password" placeholder="Sua senha">
                </div>
                <button class="form-btn" id="login-submit">Entrar</button>
                <div class="form-footer">
                    <p>Não tem uma conta? <a href="#" id="show-register">Cadastre-se</a></p>
                    <p><a href="#" id="forgot-password">Esqueceu sua senha?</a></p>
                </div>
            </div>
        </div>
    `;
    
    document.body.appendChild(loginModal);
    
    // Prevenir rolagem do body
    document.body.style.overflow = 'hidden';
    
    // Adicionar evento para fechar o modal
    loginModal.querySelector('.close-login').addEventListener('click', () => {
        loginModal.remove();
        document.body.style.overflow = '';
    });
}
    // Adicionar evento para submeter o login
    
    const faqItems = document.querySelectorAll('.faq-item');
    
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        
        question.addEventListener('click', () => {
            // Toggle active class on the clicked item
            item.classList.toggle('active');
            
            // Optional: Close other items when one is opened
            faqItems.forEach(otherItem => {
                if (otherItem !== item) {
                    otherItem.classList.remove('active');
                }
            });
        });
    });
