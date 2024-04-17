<?php

class label {
	public $name;
	public $Text;
	public $classe;
        public $label;
        public $br;
	
	public function label($nome) {
		$this->name = $nome;
                   $this->label=NULL;
                $this->br=false;

	}
	
	public function ShowMe()
    {
    	  if($this->label!=NULL)   
             print "<label for='$this->name'>$this->label</label>";
          
        print '<span id="'.$this->name.'"';
        if(!empty($this->classe)) print " class='$this->classe' "; 
        print '>';
        print $this->Text;
        print '</span>';
         if($this->br)   
            print "<div style='clear:both;'></div>\n";

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