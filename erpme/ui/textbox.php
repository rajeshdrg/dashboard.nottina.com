<?php

class textbox {
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
        public $readonly;

	
	public function textbox($nome) {
		$this->name = $nome;
		$this->size='50';
		$this->style=NULL;

		$this->Required=false;
		$this->ValidateMessage = 'O campo '.$this->name.' é obrigatório.';
		
		$this->maxlength=NULL;
                $this->label=NULL;
                $this->br=false;
                $this->readonly=false;
	}
	
	public function ShowMe()
    {
      
    	
         if($this->label!=NULL)   
             print "<label for='$this->name'>$this->label</label>";
            
        print "<input name='".$this->name."'";
        print " id='".$this->name."'";
        print ' size='.$this->size.'';
        print " style='$this->style'";
        print " value='".$this->Text."'";
        print " placeholder='".$this->placeholder."'";
        if($this->maxlength !=NULL) 
        	print " maxlength='$this->maxlength' ";
        
        if(!empty($this->classe)) print " class='$this->classe' "; 
        if($this->readonly) print " readonly ";
        print '>';
   		if($this->Required == true) {
	   		print "<font color=red>*</font>";
	        print "<script language=\"javascript\">\n";
			print  "ValidateFunctions.push(function () { \n";
			print  'var x=document.forms["aspnetForm"]["'.$this->name.'"].value;'."\n";
			print "if (x==null || x==\"\")\n";
			print "  {\n";
			print "  return \"$this->ValidateMessage\";\n";
			print  "} \n";
			print  "else return null;\n";
			print  "});\n";
	        print "</script>\n";
		}

        if($this->br)   
            print "\n<br>\n";
                 
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
