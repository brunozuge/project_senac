let balance = 1000;

function placeBet() {
    const betAmount = parseInt(document.getElementById('bet-amount').value);
    const betNumber = parseInt(document.getElementById('bet-number').value);
    const resultMessage = document.getElementById('result-message');
    
    if (betAmount > balance) {
        resultMessage.textContent = "Saldo insuficiente para esta aposta.";
        return;
    }

    if (betNumber < 1 || betNumber > 10) {
        resultMessage.textContent = "Escolha um número entre 1 e 10.";
        return;
    }
    
    const drawnNumber = Math.floor(Math.random() * 10) + 1;
    
    if (drawnNumber === betNumber) {
        const winnings = betAmount * 10;
        balance += winnings;
        resultMessage.textContent = `Parabéns! O número sorteado foi ${drawnNumber}. Você ganhou ${winnings} créditos!`;
    } else {
        balance -= betAmount;
        resultMessage.textContent = `Que pena! O número sorteado foi ${drawnNumber}. Você perdeu ${betAmount} créditos.`;
    }
    
    document.getElementById('balance').textContent = balance;

    if (balance <= 0) {
        resultMessage.textContent += " Seu saldo chegou a zero. Jogo encerrado.";
        document.querySelector('button[onclick="placeBet()"]').disabled = true;
    }
}

function addCredits() {
    const addAmount = parseInt(document.getElementById('add-credits').value);
    if (addAmount > 0) {
        balance += addAmount;
        document.getElementById('balance').textContent = balance;
        document.getElementById('result-message').textContent = `${addAmount} créditos foram adicionados ao seu saldo.`;
        
        // Reativar o botão de aposta se o saldo for maior que zero
        if (balance > 0) {
            document.querySelector('button[onclick="placeBet()"]').disabled = false;
        }
    } else {
        document.getElementById('result-message').textContent = "Por favor, insira um valor válido para adicionar créditos.";
    }
}

