<?php

class inputfield {
	public $name;
	public $size;
	public $Text;
	public $Required;
	public $classe;
	public $label;
	public $LabelClass;
	public $LabelStyle;
	
	public function inputfield($nome) {
		$this->name  	 	= $nome;
		$this->label 	  	= ucwords( $nome);
		$this->classe	  	= null;
		$this->LabelClass   = null;
		$this->LabelStyle	= null;

		$this->size     = "50";
		$this->Required = false;
	}
	
	public function ShowMe()
    {
    	$lclass = "";
    	$lstyle = "";

    	if($this->Required) {
	    	if(!empty($this->classe)) 
		    	$this->classe .= " required ";
		    else 
		    	$this->classe = " required ";
    	}
    	
    	if(!empty($this->LabelClass) )
    		$lclass = "class='$this->LabelClass'";

    	if(!empty($this->LabelStyle) )
    		$lstyle = "style='$this->LabelStyle'";
    		
    	print "<label for='$this->name' $lclass $lstyle >$this->label</label>";
        print "<input name='$this->name' ";
        print " id='$this->name'";
        print " size='$this->size'";
        print " value='$this->Text'";
        if(!empty($this->classe)) 
        	print " class='$this->classe' "; 
		print ">";
    	if($this->Required) {
    		print "<span style='color:red;'>*</span>";
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