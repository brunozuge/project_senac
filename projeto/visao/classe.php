<?php
class SalaDeAula {
    public $capacidade;
    public $ocupantes = 0;
    public $aberta = false;
    public $reservada = false;

    public function __construct($capacidade) {
        $this->capacidade = $capacidade;
    }

    public function abrir() {
        if (!$this->aberta) echo "Sala aberta!<br>";
        $this->aberta = true;
    }

    public function fechar() {
        if ($this->ocupantes == 0) {
            echo "Sala fechada!<br>";
            $this->aberta = false;
        } else {
            echo "Não pode fechar, sala ocupada!<br>";
        }
    }

    public function entrar() {
        if ($this->aberta && !$this->reservada && $this->ocupantes < $this->capacidade) {
            $this->ocupantes++;
            echo "Entrou na sala. Ocupantes: $this->ocupantes<br>";
        } else {
            echo "Não pode entrar!<br>";
        }
    }

    public function sair() {
        if ($this->aberta && $this->ocupantes > 0) {
            $this->ocupantes--;
            echo "Saiu da sala. Ocupantes: $this->ocupantes<br>";
        } else {
            echo "Não pode sair!<br>";
        }
    }

    public function reservar() {
        if (!$this->reservada) {
            $this->reservada = true;
            echo "Sala reservada!<br>";
        } else {
            echo "Já está reservada!<br>";
        }
    }

 
}


$sala = new SalaDeAula(5);
$sala->abrir();
$sala->entrar();
$sala->reservar();
$sala->sair();
$sala->cancelarReserva();
$sala->fechar();
?>