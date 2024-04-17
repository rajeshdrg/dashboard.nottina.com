<?php

class label {
	public $name;
	public $Text;
	public $classe;
	
	public function textbox($nome) {
		$this->name = $nome;

	}
	
	public function ShowMe()
    {
    	
        print '<span id="'.$this->name.'"';
        if(!empty($this->classe)) print " class='$this->classe' "; 
        print '>';
        print $this->Text;
        print '</span>';

    } 
    
    
	public function __invoke()
    {
        $this->ShowMe();
    }
   
	public function Set($value)
    {
        $this->Text = $value;
    }
   
    
};
?>