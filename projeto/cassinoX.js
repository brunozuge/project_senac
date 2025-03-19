// Espera o DOM carregar completamente
document.addEventListener('DOMContentLoaded', function() {

    // Funcionalidade para o caça-níqueis (slot machine)
    const spinButton = document.querySelector('.spin-btn');
    if (spinButton) {
        spinButton.addEventListener('click', function() {
            const reels = document.querySelectorAll('.reel');
            const symbols = ['🍒', '🍋', '🍇', '🍉', '💎', '7️⃣', '🎰'];
            let results = [];
            
            // Animar e alterar cada cilindro
            reels.forEach((reel, index) => {
                reel.style.animation = 'none';
                setTimeout(() => {
                    reel.style.animation = 'spin 0.5s ease-out';
                    
                    // Atraso progressivo para cada cilindro
                    setTimeout(() => {
                        const randomSymbol = symbols[Math.floor(Math.random() * symbols.length)];
                        reel.textContent = randomSymbol;
                        results[index] = randomSymbol;
                        
                        // Verificar resultado após o último cilindro parar
                        if (index === reels.length - 1) {
                            checkWinning(results);
                        }
                    }, 500 + (index * 300));
                }, 10);
            });
        });
    }
    
    // Verificar se o jogador ganhou
    function checkWinning(results) {
        const allEqual = results.every(symbol => symbol === results[0]);
        
        if (allEqual) {
            // Animação de vitória
            setTimeout(() => {
                const slotMachine = document.getElementById('slot-machine');
                slotMachine.classList.add('winner-animation');
                showWinMessage("Parabéns! Você ganhou!");
                
                setTimeout(() => {
                    slotMachine.classList.remove('winner-animation');
                }, 3000);
            }, 1000);
        }
    }
    
    // Mostrar mensagem de vitória
    function showWinMessage(message) {
        const messageDiv = document.createElement('div');
        messageDiv.className = 'win-message';
        messageDiv.textContent = message;
        
        document.getElementById('slot-machine').appendChild(messageDiv);
        
        setTimeout(() => {
            messageDiv.remove();
        }, 3000);
    }
    
    // Funcionalidade para as perguntas frequentes (FAQ)
    const faqQuestions = document.querySelectorAll('.faq-question');
    if (faqQuestions) {
        faqQuestions.forEach(question => {
            question.addEventListener('click', () => {
                // Fechar todas as outras respostas
                document.querySelectorAll('.faq-answer').forEach(answer => {
                    if (answer !== question.nextElementSibling) {
                        answer.style.display = 'none';
                    }
                });
                
                // Toggle da resposta atual
                const answer = question.nextElementSibling;
                if (answer.style.display === 'block') {
                    answer.style.display = 'none';
                    question.classList.remove('active');
                } else {
                    answer.style.display = 'block';
                    question.classList.add('active');
                }
            });
        });
    }
    
    // Funcionalidade para modais (login/registro)
    const loginBtn = document.querySelector('.login-btn');
    const registerBtn = document.querySelector('.register-btn');
    const closeModalBtns = document.querySelectorAll('.close-modal');
    const modals = document.querySelectorAll('.modal');
    
    if (loginBtn) {
        loginBtn.addEventListener('click', () => {
            document.getElementById('login-modal').style.display = 'flex';
        });
    }
    
    if (registerBtn) {
        registerBtn.addEventListener('click', () => {
            document.getElementById('register-modal').style.display = 'flex';
        });
    }
    
    if (closeModalBtns) {
        closeModalBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                modals.forEach(modal => {
                    modal.style.display = 'none';
                });
            });
        });
    }
    
    // Fechar modal ao clicar fora dele
    window.addEventListener('click', (e) => {
        modals.forEach(modal => {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
    });
    
    // Funcionalidade para filtrar jogos por categoria
    const categoryTabs = document.querySelectorAll('.category-tab');
    if (categoryTabs) {
        categoryTabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Remover classe active de todas as abas
                categoryTabs.forEach(t => {
                    t.classList.remove('active');
                });
                
                // Adicionar classe active na aba atual
                tab.classList.add('active');
                
                // Obter categoria selecionada
                const category = tab.getAttribute('data-category');
                
                // Filtrar jogos
                const gameCards = document.querySelectorAll('.game-card');
                gameCards.forEach(card => {
                    if (category === 'all' || card.getAttribute('data-category') === category) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    }
    
    // Funcionalidade para chat de suporte
    const chatSupport = document.querySelector('.chat-support');
    if (chatSupport) {
        chatSupport.addEventListener('click', () => {
            // Criar div do chat se não existir
            if (!document.getElementById('support-chat')) {
                const chatBox = document.createElement('div');
                chatBox.id = 'support-chat';
                chatBox.className = 'support-chat-box';
                
                chatBox.innerHTML = `
                    <div class="chat-header">
                        <h3>Suporte ao Cliente</h3>
                        <span class="close-chat">&times;</span>
                    </div>
                    <div class="chat-messages">
                        <div class="message support">
                            <p>Olá! Como posso ajudar você hoje?</p>
                            <span class="message-time">Agora</span>
                        </div>
                    </div>
                    <div class="chat-input">
                        <input type="text" placeholder="Digite sua mensagem...">
                        <button class="send-message">Enviar</button>
                    </div>
                `;
                
                document.body.appendChild(chatBox);
                
                // Remover notificação quando o chat for aberto
                const notification = document.querySelector('.notification');
                if (notification) {
                    notification.style.display = 'none';
                }
                
                // Funcionalidade para fechar o chat
                document.querySelector('.close-chat').addEventListener('click', () => {
                    chatBox.remove();
                });
                
                // Funcionalidade para enviar mensagens
                const sendBtn = document.querySelector('.send-message');
                const messageInput = document.querySelector('.chat-input input');
                const messagesContainer = document.querySelector('.chat-messages');
                
                sendBtn.addEventListener('click', sendMessage);
                messageInput.addEventListener('keypress', (e) => {
                    if (e.key === 'Enter') {
                        sendMessage();
                    }
                });
                
                function sendMessage() {
                    const message = messageInput.value.trim();
                    if (message) {
                        // Adicionar mensagem do usuário
                        const now = new Date();
                        const time = now.getHours() + ':' + (now.getMinutes() < 10 ? '0' : '') + now.getMinutes();
                        
                        messagesContainer.innerHTML += `
                            <div class="message user">
                                <p>${message}</p>
                                <span class="message-time">${time}</span>
                            </div>
                        `;
                        
                        // Limpar input
                        messageInput.value = '';
                        
                        // Scroll para a última mensagem
                        messagesContainer.scrollTop = messagesContainer.scrollHeight;
                        
                        // Simular resposta automática após 1s
                        setTimeout(() => {
                            messagesContainer.innerHTML += `
                                <div class="message support">
                                    <p>Obrigado pelo contato! Um atendente irá te responder em instantes.</p>
                                    <span class="message-time">${time}</span>
                                </div>
                            `;
                            messagesContainer.scrollTop = messagesContainer.scrollHeight;
                        }, 1000);
                    }
                }
            }
        });
    }
    
    // Funcionalidade para newsletter
    const newsletterForm = document.querySelector('.newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const emailInput = newsletterForm.querySelector('input[type="email"]');
            const email = emailInput.value.trim();
            
            if (email) {
                // Aqui você pode adicionar código para enviar o email para seu backend
                showNotification('Obrigado por se inscrever!', 'success');
                emailInput.value = '';
            } else {
                showNotification('Por favor, insira um email válido', 'error');
            }
        });
    }
    
    // Sistema de notificações
    function showNotification(message, type = 'info') {
        // Criar div de notificação se não existir
        if (!document.getElementById('notification-container')) {
            const container = document.createElement('div');
            container.id = 'notification-container';
            document.body.appendChild(container);
        }
        
        const notification = document.createElement('div');
        notification.className = `notification-toast ${type}`;
        notification.innerHTML = `
            <p>${message}</p>
            <span class="notification-close">&times;</span>
        `;
        
        document.getElementById('notification-container').appendChild(notification);
        
        // Fechar notificação ao clicar
        notification.querySelector('.notification-close').addEventListener('click', () => {
            notification.remove();
        });
        
        // Auto-fechar após 5 segundos
        setTimeout(() => {
            notification.classList.add('fade-out');
            setTimeout(() => {
                notification.remove();
            }, 500);
        }, 5000);
    }
    
    // Animação de crescimento para o valor do jackpot
    const jackpotValue = document.querySelector('.jackpot-value');
    if (jackpotValue) {
        let currentValue = 100000;
        const targetValue = 500000;
        const increment = 100;
        const intervalTime = 2000;
        
        setInterval(() => {
            currentValue += Math.floor(Math.random() * increment);
            if (currentValue > targetValue) {
                currentValue = targetValue;
            }
            
            jackpotValue.textContent = 'R$ ' + currentValue.toLocaleString('pt-BR');
            jackpotValue.classList.add('pulse-animation');
            
            setTimeout(() => {
                jackpotValue.classList.remove('pulse-animation');
            }, 1000);
        }, intervalTime);
    }
    
    // Inicializar o carrossel de ganhadores (ticker)
    const tickerContent = document.querySelector('.ticker-content');
    if (tickerContent) {
        // Duplicar os itens para criar um loop contínuo
        tickerContent.innerHTML += tickerContent.innerHTML;
    }
    
    // Funcionalidade para menu móvel
    const menuToggle = document.createElement('div');
    menuToggle.className = 'menu-toggle';
    menuToggle.innerHTML = '<span></span><span></span><span></span>';
    
    const header = document.querySelector('header');
    if (header) {
        // Apenas adicionar toggle de menu em telas menores
        if (window.innerWidth <= 768) {
            header.insertBefore(menuToggle, header.firstChild);
            
            const nav = document.querySelector('nav');
            nav.style.display = 'none';
            
            menuToggle.addEventListener('click', () => {
                menuToggle.classList.toggle('active');
                nav.style.display = nav.style.display === 'none' ? 'block' : 'none';
            });
        }
    }
    
    // Adicionar efeito de rolagem suave para links de âncora
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 100,
                    behavior: 'smooth'
                });
            }
        });
    });
});

// Adicionar animações de entrada ao rolar a página
document.addEventListener('DOMContentLoaded', function() {
    const animateElements = document.querySelectorAll('.benefit-card, .game-card, .feature-card, .testimonial-card, .promotion-card');
    
    function checkScroll() {
        animateElements.forEach(element => {
            const elementTop = element.getBoundingClientRect().top;
            const elementVisible = 150;
            
            if (elementTop < window.innerHeight - elementVisible) {
                element.classList.add('visible');
            }
        });
    }
    
    // Inicializar elementos visíveis na carga da página
    checkScroll();
    
    // Verificar ao rolar
    window.addEventListener('scroll', checkScroll);
});

// Detectar se o usuário está inativo e mostrar uma promoção
let inactivityTimer;

function resetInactivityTimer() {
    clearTimeout(inactivityTimer);
    inactivityTimer = setTimeout(showInactivePromo, 60000); // 60 segundos
}

function showInactivePromo() {
    // Apenas mostrar se não houver modais abertos
    const modalsOpen = Array.from(document.querySelectorAll('.modal')).some(modal => 
        modal.style.display === 'flex' || modal.style.display === 'block'
    );
    
    if (!modalsOpen && !document.getElementById('inactive-promo')) {
        const promo = document.createElement('div');
        promo.id = 'inactive-promo';
        promo.className = 'inactive-promo-modal';
        
        promo.innerHTML = `
            <div class="inactive-promo-content">
                <span class="close-promo">&times;</span>
                <h3>Oferta Especial!</h3>
                <p>Aproveite 50 rodadas grátis e 100% de bônus no seu próximo depósito!</p>
                <button class="hero-btn">Quero Aproveitar</button>
            </div>
        `;
        
        document.body.appendChild(promo);
        
        document.querySelector('.close-promo').addEventListener('click', () => {
            promo.remove();
        });
        
        document.querySelector('#inactive-promo .hero-btn').addEventListener('click', () => {
            promo.remove();
            // Redirecionar para a página de depósito ou registrar bônus
            // window.location.href = '/deposito';
        });
    }
}

// Iniciar timer de inatividade
document.addEventListener('mousemove', resetInactivityTimer);
document.addEventListener('keypress', resetInactivityTimer);
document.addEventListener('scroll', resetInactivityTimer);
document.addEventListener('click', resetInactivityTimer);

resetInactivityTimer();

// Adicionar também CSS extra para os novos elementos em JavaScript
const extraStyles = document.createElement('style');
extraStyles.textContent = `
    /* Estilos para o chat de suporte */
    .support-chat-box {
        position: fixed;
        bottom: 80px;
        right: 30px;
        width: 300px;
        height: 400px;
        background-color: var(--primary);
        border-radius: 8px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.5);
        display: flex;
        flex-direction: column;
        z-index: 100;
        overflow: hidden;
        animation: slideUp 0.3s ease-out;
    }
    
    @keyframes slideUp {
        from { transform: translateY(100%); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    
    .chat-header {
        background-color: var(--accent);
        padding: 0.8rem;
        color: var(--text-dark);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .close-chat {
        font-size: 1.5rem;
        cursor: pointer;
    }
    
    .chat-messages {
        flex: 1;
        padding: 1rem;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 0.8rem;
    }
    
    .message {
        padding: 0.8rem;
        border-radius: 8px;
        max-width: 80%;
        position: relative;
    }
    
    .message p {
        margin: 0;
    }
    
    .message-time {
        font-size: 0.7rem;
        color: rgba(255, 255, 255, 0.5);
        position: absolute;
        bottom: -15px;
        right: 5px;
    }
    
    .message.support {
        background-color: var(--secondary);
        color: var(--text-light);
        align-self: flex-start;
        border-bottom-left-radius: 0;
    }
    
    .message.user {
        background-color: var(--accent);
        color: var(--text-dark);
        align-self: flex-end;
        border-bottom-right-radius: 0;
    }
    
    .chat-input {
        display: flex;
        padding: 0.8rem;
        background-color: rgba(0, 0, 0, 0.3);
    }
    
    .chat-input input {
        flex: 1;
        padding: 0.5rem;
        border: none;
        border-radius: 4px;
        margin-right: 0.5rem;
    }
    
    .send-message {
        background-color: var(--accent);
        color: var(--text-dark);
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 4px;
        cursor: pointer;
    }
    
    /* Notificações */
    #notification-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1000;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    
    .notification-toast {
        min-width: 250px;
        padding: 1rem;
        border-radius: 4px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.3);
        animation: fadeIn 0.3s;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateX(50px); }
        to { opacity: 1; transform: translateX(0); }
    }
    
    .notification-toast.fade-out {
        animation: fadeOut 0.5s;
    }
    
    @keyframes fadeOut {
        from { opacity: 1; transform: translateX(0); }
        to { opacity: 0; transform: translateX(50px); }
    }
    
    .notification-toast.success {
        background-color: var(--success);
        color: white;
    }
    
    .notification-toast.error {
        background-color: var(--danger);
        color: white;
    }
    
    .notification-toast.info {
        background-color: var(--accent);
        color: var(--text-dark);
    }
    
    .notification-close {
        cursor: pointer;
        font-size: 1.2rem;
    }
    
    /* Promoção por inatividade */
    .inactive-promo-modal {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background-color: var(--primary);
        border-radius: 8px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.5);
        width: 300px;
        padding: 1.5rem;
        z-index: 100;
        animation: bounceIn 0.5s;
    }
    
    @keyframes bounceIn {
        0% { transform: scale(0.5); opacity: 0; }
        50% { transform: scale(1.05); }
        70% { transform: scale(0.9); }
        100% { transform: scale(1); opacity: 1; }
    }
    
    .inactive-promo-content h3 {
        color: var(--accent);
        margin-bottom: 0.5rem;
    }
    
    .close-promo {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 1.2rem;
        cursor: pointer;
        color: rgba(255, 255, 255, 0.7);
    }
    
    /* Animações de entrada */
    .benefit-card, .game-card, .feature-card, .testimonial-card, .promotion-card {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.6s ease, transform 0.6s ease;
    }
    
    .benefit-card.visible, .game-card.visible, .feature-card.visible, .testimonial-card.visible, .promotion-card.visible {
        opacity: 1;
        transform: translateY(0);
    }
    
    /* Menu móvel */
    .menu-toggle {
        display: none;
        flex-direction: column;
        justify-content: space-between;
        height: 24px;
        cursor: pointer;
    }
    
    .menu-toggle span {
        display: block;
        height: 3px;
        width: 30px;
        background-color: var(--text-light);
        border-radius: 3px;
        transition: all 0.3s;
    }
    
    .menu-toggle.active span:nth-child(1) {
        transform: translateY(10px) rotate(45deg);
    }
    
    .menu-toggle.active span:nth-child(2) {
        opacity: 0;
    }
    
    .menu-toggle.active span:nth-child(3) {
        transform: translateY(-10px) rotate(-45deg);
    }
    
    @media (max-width: 768px) {
        .menu-toggle {
            display: flex;
        }
    }
    
    /* Animação de vitória para o caça-níqueis */
    .winner-animation {
        animation: winnerPulse 0.5s infinite alternate;
    }
    
    @keyframes winnerPulse {
        from { box-shadow: 0 0 10px var(--accent); }
        to { box-shadow: 0 0 30px var(--accent); }
    }
    
    .win-message {
        background-color: var(--accent);
        color: var(--text-dark);
        text-align: center;
        padding: 0.8rem;
        margin-top: 1rem;
        border-radius: 4px;
        font-weight: bold;
        animation: bounce 0.5s;
    }
    
    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
        40% { transform: translateY(-20px); }
        60% { transform: translateY(-10px); }
    }
`;

document.head.appendChild(extraStyles);