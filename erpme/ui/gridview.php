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
	public $header_td_class;
	public $class_cell;
	public $ShowNumber;
	public $LineStyle;
	public $edit;
        public $colunas_object;
	
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
		$this->LineStyle = "";
                $this->edit = false;

	}
	
	public function ShowMe()
    {
      //  print "<pre>";    
      //      print_r($this);
    	$this->header();
    	
    	if($this->SqlDataReader != null) {
        
	        $SqlDataReader = $this->SqlDataReader;
	        $Result = $SqlDataReader->Result;
        
	        for($i=0;$i<$this->SqlDataReader->Rows;$i++) {
                        if($this->LineStyle!=null) {
            	       		$ls = pg_fetch_result( $Result,$i,$this->LineStyle); 
	        		print "<tr class='$ls' >";
                                
                             //   error_log("<tr class='$ls'  $this->LineStyle >");
                        }
                        else {
                            if(isset($this->trClass)) {
	        		print "<tr class=\"$this->trClass\" >";
                            }
                            else {
		       		print "<tr>";
                            }
		       	}
	       		$datakey = pg_fetch_result( $Result,$i,$this->datakey); 
	       		
	       		if($this->ShowNumber) {
	       		$linha = $i+1;
	       			print "<td>$linha</td>";
	       		}
	       		

	        	if(isset($this->colunas_commands) && !$this->edit ){

	        		if(count($this->colunas_commands)) {
			    	    print "<td  align='center' width='12%'>";
	           			for($j=0;$j<count($this->colunas_commands);$j++) {
						if($datakey !=NULL) {
		        		 	
		        			print "<input type=\"image\"  src=\"".$this->colunas_commands_img[$j]."\" ";
		        			print "name = \"".$this->colunas_commands[$j]."\" ";
		        			print 'style="border:none;font-size:0;margin-left:0px" ';
		        			print "onclick=\"return command_argument('".$this->colunas_commands[$j]."','".$datakey."')\" >";
		        			}
		        	}
                            }
                        }
                          elseif($this->edit) {
                              print "<td>";
                              print "<input type=\"image\"  src=\"/images/delete.png\" onclick=\"$(this).closest('tr').hide(); $('#".$this->name."_acao_".$datakey."').val('excluir');return false;\" >";
                              print "</td>";
                        }
                        
                        $this->ShowLine($i);
		        
	        	print "</tr>\n";
	        }
        }
        $this->footer();

    } 
    
    public function ShowLine($linha) {
        $datakey        = pg_fetch_result(  $this->SqlDataReader->Result ,$linha,$this->datakey);
        print "<input type=hidden name=".$this->name."_acao_$datakey id=".$this->name."_acao_$datakey value=''>";
//        print "<td>";
  //      print $linha+1;
    //    print "</td>";
       	for($j=0;$j<count($this->colunas_header);$j++) {
                $fieldnumber    = pg_field_num(     $this->SqlDataReader->Result, $this->colunas[$j]);
                $fieldtype      = pg_field_type(    $this->SqlDataReader->Result, $fieldnumber);
        	$resultado      = pg_fetch_result(  $this->SqlDataReader->Result, $linha,$this->colunas[$j]);   
                if(isset($this->colunas_object[$j])) {
                    $object = $this->colunas_object[$j];
                    $object->name = $this->name."_".$this->colunas[$j]."[$datakey]";
                    $object->id   = $this->name."_".$this->colunas[$j]."_$datakey";
                    $object->set($resultado);
                    print "<td class='.$this->class_cel.'>";
                    $object->ShowMe();
                    print "</td>";
                }
                elseif($this->edit==true) {
                    $id     =$this->name."_".$this->colunas[$j]."_$datakey";
                    $name   =$this->name."_".$this->colunas[$j]."[$datakey]";
                    print "<td>";
                    if($fieldtype=='date')
                        print "<input class='data just' style='padding:0px 0px;border:solid 0px;margin-left:0px;' name=$name id=$id value='".$this->SqlCommand-> DateDBBR($resultado)."' />";
                    else
                        print "<input class='just' style='padding:0px 0px;border:solid 0px;margin-left:0px;' name=$name id=$id value='".$resultado."'/>";
                    print "</td>";
                }
        	elseif($this->Clickable==true) {
	        	print '<td><a href="#" class="'.$this->trClass.'">';
                        if($fieldtype=='date')
                            print $this->SqlCommand->DateDBBR($resultado);
			elseif($fieldtype=='timestamp')
                            print $this->SqlCommand->DateDBBRT($resultado);
                        else
                            print $resultado.'</a></td>';    	
        	}
        	else {
			print "<td>";
                        if($fieldtype=='date')
                            print $this->SqlCommand-> DateDBBR($resultado);
			elseif($fieldtype=='timestamp')
                            print $this->SqlCommand->DateDBBRT($resultado);
                        else
                            print $resultado;
			print "</td>";
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

	    if(isset($this->colunas_commands) ){
		    if(count($this->colunas_commands)> 0) {
		    	print "<td  ";
		        print " class=\"".$this->header_td_class."\" ";
		        print " >&nbsp;</td>";
		    }

	    }            
            
		
	    for($i=0;$i<count($this->colunas_header);$i++) {
		    print "<td class='".$this->header_td_class."' ";
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
        if($this->edit==true){
            print "<tr>";
	    for($j=0;$j<count($this->colunas_header);$j++) {       
                $fieldnumber    = pg_field_num(     $this->SqlDataReader->Result, $this->colunas[$j]);
                $fieldtype      = pg_field_type(    $this->SqlDataReader->Result, $fieldnumber);
                $id     =$this->name."_".$this->colunas[$j]."_novo";
                $name   =$this->name."_".$this->colunas[$j]."['novo']";
                  if(isset($this->colunas_object[$j])) {
                    $object = $this->colunas_object[$j];
                    $object->name = $this->name."_".$this->colunas[$j]."['novo']";
                    $object->id   = $this->name."_".$this->colunas[$j]."_novo";
                  
                    print "<td>";
                    $object->ShowMe();
                    print "</td>";
                }
                elseif($fieldtype=='date')
                    print "<td><input class='data just'  style='padding:0px 0px;border:solid 0px;margin-left:0px;'  name=$name id=$id value='".$this->SqlCommand-> DateDBBR($resultado)."' /></td>";
                else
                    print "<td><input class='just'  style='padding:0px 0px;border:solid 0px;margin-left:0px;'  name=$name id=$id value='".$resultado."'/></td>";
            }
            
        }
    	elseif($this->ShowFooter==true) {
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

		}
	    print "</tr>";

	    print "</table>";
    }  
};

?>
