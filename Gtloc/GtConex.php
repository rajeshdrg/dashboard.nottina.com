<?php

class GtConex {
    public $nome;
    public $conexao_SP;
    public $conexao_pr;
    
    public function __construct($nome) {
        $this->nome = $nome;
    }
}


class GtVolume {
    public $nome;
    public $volume_SP;
    public $volume_pr;
    
    public function __construct($nome) {
        $this->nome = $nome;
    }
}


