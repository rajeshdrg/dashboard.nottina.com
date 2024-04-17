<?php

class hidden {
	public $name;
	public $value;
	
	public function hidden($nome) {
		$this->name  	 	= $nome;
	}
	
	public function ShowMe()
    {
        print "<input type=hidden name='$this->name' ";
        print " id='$this->name'";
        print " value='$this->value' >";
    } 
    
	public function __invoke()
    {
        $this->ShowMe();
    }
   
	public function Set($value)
    {
        $this->value = $value;
    }
  
};
?>