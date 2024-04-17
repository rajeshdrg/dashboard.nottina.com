<?php

class Disk {

    public $name;
    public $percentual;
    public $inodes;

    
    public function __construct($name,$percentual) {
        $this->name  = $name;
        $this->percentual = $percentual;
    }
    public function SetInodes($inodes) {
        $this->inodes = $inodes;
    }
}

