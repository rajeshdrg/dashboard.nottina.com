<?php

class Vitrine {
	public $name;
	public $size;
	public $SqlDataReader;
	public $SqlCommand;
	public $Value;
	public $Text;
	public $ShowHeader;
	public $trClass;
	public $Clickable;
	
	public $NewCommand;
	
	public function Vitrine($nome) {
		$this->name = $nome;
		$this->size="50";
		$this->SqlCommand=NULL;
		$this->Value = 0;
		$this->Text = 0;
		$this->Newcommand = "";
		$this->ShowHeader = true;
		$this->ShowFooter = true;
		$this->Clickable = false;

	}
	
	public function ShowMe()
    {
    	$this->header();
    	
    	if($this->SqlDataReader != null) {
        
	        $SqlDataReader = $this->SqlDataReader;
	        $Result = $SqlDataReader->Result;
	        $ct=0;
	        
       		print "<tr>";
	        
	        for($i=0;$i<$this->SqlDataReader->Rows;$i++) {
	       		$datakey = pg_fetch_result( $Result,$i,$this->datakey); 
	       		
	       		$resultado = pg_fetch_result( $this->SqlDataReader->Result,$i,$this->datakey);   
	       		$cod_produto = pg_fetch_result( $this->SqlDataReader->Result,$i,"cod_produto");
	       		$produto = pg_fetch_result( $this->SqlDataReader->Result,$i,"produto");
	       		$descricao = pg_fetch_result( $this->SqlDataReader->Result,$i,"descricao");   
	       		$valor = pg_fetch_result( $this->SqlDataReader->Result,$i,"valor");   
   



	       		print "<td class=\"cellVitrine\" align=\"center\" >";
	       		print "<img src=\"thumb.php?_cod=$resultado\">";
	       		print "<br>";
	       		print "$produto<br>";
	       		print "<a href=detalhes.php?_cod=$cod_produto>$descricao</a><br>";
	       		print "<p class=valor>R\$ $valor</p>";
	       		print "<input type=text name=qtd[$cod_produto] size=2 value=1><br>";
	       		print "<input name=\"comprar[$cod_produto]\" type=\"image\"img src=\"/images/comprar_df.jpg\">";
	       		
	       		print "</td>\n";
	        	
	        	$ct++;
	        	if($ct >2) {
		        	print "</tr>\n";
		        	
		        	$ct=0;
		       		print "<tr>";

		        }
	        }
        }
        $this->footer();
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
    
	
	    print "<table  id=\"".$this->name."\" ";
	    print "name=\"".$this->name."\" >\n";
    }
    function footer() {
	    print "</tr></table>\n";
    }  
};

?>