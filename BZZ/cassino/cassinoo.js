function spinSlots() {
    const symbols = ["🍒", "🍋", "🍊", "🍇", "🍉"];
    
    const slot1 = symbols[Math.floor(Math.random() * symbols.length)];
    const slot2 = symbols[Math.floor(Math.random() * symbols.length)];
    const slot3 = symbols[Math.floor(Math.random() * symbols.length)];
    
    document.getElementById("slot1").textContent = slot1;
    document.getElementById("slot2").textContent = slot2;
    document.getElementById("slot3").textContent = slot3;
    
    if (slot1 === slot2 && slot2 === slot3) {
        document.getElementById("slot-result").textContent = "Você ganhou!";
    } else {
        document.getElementById("slot-result").textContent = "Tente novamente!";
    }
}

function rollDice() {
    const diceResult = Math.floor(Math.random() * 6) + 1;
    document.getElementById("dice-result").textContent = `Você rolou um ${diceResult}`;
}
