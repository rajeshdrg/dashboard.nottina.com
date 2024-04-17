<?php

class GridView {
	public $name;
	public $size;
	public $SqlDataReader;
	public $SqlCommand;
	public $Value;
	public $Text;
	public $ShowHeader;
	public $trClass;
	public $Clickable;
	public $footer_class;
	public $header_class;
	public $ShowNumber;
	
	public $NewCommand;
	
	public function GridView($nome) {
		$this->name = $nome;
		$this->size="50";
		$this->SqlCommand=NULL;
		$this->Value = 0;
		$this->Text = 0;
		$this->Newcommand = "";
		$this->ShowHeader = true;
		$this->ShowFooter = true;
		$this->Clickable = false;
		$this->ShowNumber = false;

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
	       		
	       		if($this->ShowNumber) {
	       		$linha = $i+1;
	       			print "<td>$linha</td>";
	       		}
	       		
	        	$this->ShowLine($i);
	        	if(isset($this->colunas_commands) ){

	        		if(count($this->colunas_commands)) {
			    	    print "<td  align='center' width='12%'>";
	           			for($j=0;$j<count($this->colunas_commands);$j++) {
		        		 	
		        			print "<input type=\"image\"  src=\"".$this->colunas_commands_img[$j]."\" ";
		        			print "name = \"".$this->colunas_commands[$j]."\" ";
		        			print 'style="border:none;font-size:0;margin-left:0px" ';
		        			print "onclick=\"return command_argument('".$this->colunas_commands[$j]."','".$datakey."')\" >";
		        			
		        	}
		      	  }
		      	  print "</td>";
		        }
	        	print "</tr>\n";
	        }
        }
        $this->footer();
    } 
    
    public function ShowLine($linha) {
       	for($j=0;$j<count($this->colunas_header);$j++) {
                $fieldnumber = pg_field_num(  $this->SqlDataReader->Result, $this->colunas[$j]);
                $fieldtype = pg_field_type(   $this->SqlDataReader->Result, $fieldnumber);
        	$resultado = pg_fetch_result( $this->SqlDataReader->Result, $linha,$this->colunas[$j]);   
        	if($this->Clickable==true) {
	        	print '<td><a href="#" class="'.$this->trClass.'">';
                        if($fieldtype=='date')
                            print $this->SqlCommand->DateDBBR($resultado);
                        else
                            print $resultado.'</a></td>';    	
        	}
        	else {
                        if($fieldtype=='date')
                            print "<td>".$this->SqlCommand-> DateDBBR($resultado)."</td>";
                        else
                            print "<td>".$resultado."</td>";
        	}
        }

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
	    	
	    print "<tr ";
	    print " class=\"".$this->header_class."\" ";
		print " >";
		if($this->ShowNumber) {
	    	
	    	print "<td>&nbsp;</td>";
	    }

		
	    for($i=0;$i<count($this->colunas_header);$i++) {
		    print "<td ";
	        print " class=\"".$this->header_class."\" ";
	        print " >";
		    print $this->colunas_header[$i];
		    print "</td>";
	    }
	    if(isset($this->colunas_commands) ){
		    if(count($this->colunas_commands)> 0) {
		    	print "<td  ";
		        print " class=\"".$this->header_class."\" ";
		        print " >&nbsp;</td>";
		    }

	    }
	    print "</tr>\n";
    }
    function footer() {
    	if($this->ShowFooter==true) {
		    print "<tr>";
		    for($j=0;$j<count($this->colunas_header);$j++) {
		    	print "<td>";
		    	print "</td>";
		    }
		    if($this->NewCommand >"") {
			    print '<td align = "center">';
	   	        print "<input type=\"image\"  src=\"".$this->NewCommandImg."\" ";
		        print "name = \"".$this->NewCommand."\" ";
       			print 'style="border:none;" ';
		        print "onclick=\"command_argument('".$this->NewCommand."','')\" >";
		        print "</td>";
		    }
		    print "</tr>";
		}
		print "<tr>";
		print "<td colspan=$this->colunas_header ";
        print " class='$this->footer_class' >";
        print "<< < > >>";

		print "</td>";
		if($this->NewCommand >"") {
			print "<td  class='$this->footer_class' >&nbsp;</td>";
		}

		print "</tr>";


	    print "</table>";
    }  
};

?>