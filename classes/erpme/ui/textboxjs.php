<?php

class textbox {
	public $name;
	public $size;
	public $Text;
	public $Required;
	public $ValidateMessage;
	
	public function textbox($nome) {
		$this->name = $nome;
		$this->size="50";
		$this->Required=false;
		$this->ValidateMessage = "O campo ".$this->name." é obrigatório.";


	}
	
	public function ShowMe()
    {
    	
        print '<input name='.$this->name.'';
        print ' id='.$this->name.'';
        print ' size='.$this->size.'';
        print ' value='.$this->Text.'';
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