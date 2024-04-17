<?php

class textarea {
	public $name;
	public $colunas;
	public $linhas;
	public $Text;
	public $Required;
	public $ValidateMessage;
	
	public function textarea($nome) {
		$this->name = $nome;
		$this->colunas="50";
		$this->linhas="5";
		$this->Required=false;
		$this->ValidateMessage = "O campo ".$this->name." é obrigatório.";


	}
	
	public function ShowMe()
    {
    	
        print '<textarea name="'.$this->name.'"';
        print ' id="'.$this->name.'"';
        print ' cols="'.$this->colunas.'"';
        print ' rows='.$this->linhas.'"';
        print ' class="tinymce">';
        print $this->Text;
        print '</textarea>';

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