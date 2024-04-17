<?php

class CheckBoxList {
	public $name;
	public $size;
	public $SqlDataReader;
	public $SqlCommand;
	public $checked;
	public $text;
	public $ShowHeader;
	public $trClass;
	public $Clickable;
	public $footer_class;
	public $header_class;
	public $class;
	
	public $NewCommand;
	
	public function CheckBoxList($nome) {
		$this->name = $nome;
		$this->size="50";
		$this->SqlCommand=NULL;
		$this->Value = 0;
		$this->Text = 0;
		$this->Newcommand = "";
		$this->ShowHeader = true;
		$this->ShowFooter = true;
		$this->Clickable = false;
		$this->class = NULL;

	}
	
	public function ShowMe()
    {
    	$this->header();
    	
    	if($this->SqlDataReader != null) {
        
	        $SqlDataReader = $this->SqlDataReader;
	        $Result = $SqlDataReader->Result;
        
	        for($i=0;$i<$this->SqlDataReader->Rows;$i++) {
	        	if(isset($this->trClass)) {
	        		print "<tr class=\"$this->trClass\" >";
	        	}
	        	else {
		       		print "<tr>";
		       	}
	       		$datakey = pg_fetch_result( $Result,$i,$this->datakey); 
	       		$checked = pg_fetch_result( $Result,$i,$this->checked); 
	       		$text    = pg_fetch_result( $Result,$i,$this->text); 
	       		
	       		if($checked!=NULL) $checked= " checked='checked' ";
	       		
	       		print "<td><input type=checkbox name=$this->name"."[$datakey] id=$this->name"."[$datakey] $checked></td><td>$text</td>";
	        			      
	        	print "</tr>\n";
	        }
        }
        print "</table>";
    } 
    
      
    
 	public function __invoke()
    {
        $this->ShowMe();
    }
    public function bind() {
    		if($this->SqlCommand==null) {
	    		$this->SqlDataReader = null;
    			return;
    		}
    			
    		$SqlCommand = $this->SqlCommand;
    		$this->SqlDataReader = $SqlCommand->ExecuteReader();
  
    }
    public function header() {
    
	
	    print "<table class=\"".$this->class."\"   id=\"".$this->name."\" ";
	    print "name=\"".$this->name."\" >\n";
	    if($this->ShowHeader == false)
	    	return;
	    	
	
    }
 
};

?>