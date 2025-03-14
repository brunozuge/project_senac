<?php
class Carro {
    public $cor;
    public $marca;
    public $modelo;
    public $portaAberta = false;
    public $andando = false;

    public function __construct($cor, $marca, $modelo) {
        $this->cor = $cor;
        $this->marca = $marca;
        $this->modelo = $modelo;
    }

    public function abrirPorta() {
        if ($this->andando) {
            echo "Não pode abrir a porta enquanto o carro está andando!<br>";
        } else {
            $this->portaAberta = true;
            echo "Porta aberta!<br>";
        }
    }

    public function fecharPorta() {
        $this->portaAberta = false;
        echo "Porta fechada!<br>";
    }


    
}
 

// Exemplo de uso
$carro = new Carro();
$carro->abrirPorta();
$carro->andar();
$carro->fecharPorta();
$carro->andar();
$carro->abrirPorta();
$carro->parar();
$carro->abrirPorta();
?>
