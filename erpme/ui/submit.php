<?php

class submit {
	public $name;
	public $size;
	public $style;
	public $Text;
	public $Required;
	public $ValidateMessage;
	public $classe;
	public $maxlength;
	public $placeholder;
	public $label;
	public $br;

	
	public function submit($nome) {
		$this->name = $nome;
		$this->style=NULL;

		$this->Required=false;
	
		$this->maxlength=NULL;
                $this->label=NULL;
                $this->Text=NULL;
                $this->br=false;
	}
	
	public function ShowMe()
    {
      
    	
         if($this->label!=NULL)   
             print "<label for='$this->name'>$this->label</label>";
            
        print '<input type ="submit" name="'.$this->name.'"';
        print ' id="'.$this->name.'"';
        print " style='$this->style'";
        print ' value="'.$this->Text.'"';
        
        if(!empty($this->classe)) print " class='$this->classe' "; 
        print '>';

        if($this->br)   
            print "<br>";
                 
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