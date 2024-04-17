<?php

class radio {
	public $name;
	public $checked;
	public $classe;
	public $group;
	
	public function radio($nome) {
		$this->name = $nome;
		$this->group = $nome;

	}
	
	public function ShowMe()
    {
        print "<input type='radio' name='$this->group'";
        print " id='$this->name' ";
        print " value='$this->name' ";
        if($this->checked==1) 
	        print " checked='checked' ";
        if(!empty($this->classe)) print " class='$this->classe' "; 
        print ">";
    } 
    
    
	public function __invoke()
    {
        $this->ShowMe();
    }
   
	public function Set($value)
    {
    	
        $this->checked = $value;
    }
   
    
};
?>