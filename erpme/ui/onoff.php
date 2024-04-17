<?php

class onoff {
	public $name;
	public $checked;
	
	public function onoff($nome) {
		$this->name = $nome;
		$this->checked = NULL;

	}
	
	public function ShowMe()
    {
    	
      print "<div class='onoffswitch' style='width:62px;'>\n";
      print "	<input  style='width:30px;'  type='checkbox' name='$this->name' class='onoffswitch-checkbox' id='$this->name' $this->checked>\n";
      print "	<label class='onoffswitch-label' style='width:60px;' for='$this->name'>\n";
      print "		 <div class='onoffswitch-inner' ></div>\n";
      print "	 	 <div class='onoffswitch-switch' ></div>\n";
      print " 	</label>\n";
      print "</div>\n";
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