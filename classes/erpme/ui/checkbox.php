<?php

class checkbox {
	public $name;
	public $checked;
	public $Required;
	public $classe;
	
	public function checkbox($nome) {
		$this->name = $nome;
		$this->checked = '';
	}
	
	public function ShowMe()
    {
        print "<input type='checkbox' name='$this->name'";
        print " id='$this->name'";
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