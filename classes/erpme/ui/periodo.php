<?php

class periodo {
	public $name;
	public $size;
	public $Text;
	public $Required;
	public $ValidateMessage;
	public $classe;
	
	public function periodo($inicio,$fim) {
		$this->inicio = $inicio;
		$this->fim   = $fim;
		$this->size="10";
		$this->Required=false;
		$this->ValidateMessage = "Os campos $this->inicio e $this->fim são obrigatórios.";
		
		$hoje = time();
		$ontem = $hoje - (1 * 24 * 60 * 60);

		$this->InicioSet(date('d/m/Y',$ontem));
		$this->FimSet(date('d/m/Y',$hoje));


	}
	
	public function ShowMe()
    {
    	print "De ";
        print "<input name='$this->inicio' id='$this->inicio' size='$this->size' ";
        print " value='$this->InicioText' ";
        
        if(!empty($this->classe)) print " class='$this->classe' "; 
        print '>';
   		if($this->Required == true) {
	   		print "<font color=red>*</font>";
	        print "<script language=\"javascript\">\n";
			print  "ValidateFunctions.push(function () { \n";
			print  'var x=document.forms["aspnetForm"]["'.$this->inicio.'"].value;'."\n";
			print "if (x==null || x==\"\")\n";
			print "  {\n";
			print "  return \"$this->ValidateMessage\";\n";
			print  "} \n";
			print  "else return null;\n";
			print  "});\n";
	        print "</script>\n";
		}
		
		print " a ";
		
        print "<input name='$this->fim' id='$this->fim' size='$this->size' ";
        print " value='$this->FimText'";
        
        if(!empty($this->classe)) print " class='$this->classe' "; 
        print '>';
   		if($this->Required == true) {
	   		print "<font color=red>*</font>";
	        print "<script language=\"javascript\">\n";
			print  "ValidateFunctions.push(function () { \n";
			print  'var x=document.forms["aspnetForm"]["'.$this->fim.'"].value;'."\n";
			print "if (x==null || x==\"\")\n";
			print "  {\n";
			print "  return \"$this->ValidateMessage\";\n";
			print  "} \n";
			print  "else return null;\n";
			print  "});\n";
	        print "</script>\n";
	        
	     }
	     print "<select name='erpme_data_comum' id='erpme_data_comum' onChange='erpme_periodo()'>";
	     print "<option value=0>Informe o período ou selecione uma de nossas sugestões</option>";
	     print "<option value=1>Somente hoje</option>";
	     print "<option value=2>Do começo do mês até hoje</option>";
	     print "<option value=3>Do começo do ano até hoje</option>";
	     print "<option value=4>Mês passado</option>";
	     print "</select>\n";


	     $hoje = date('d/m/Y',time());
	     $data = getdate ();
	     $mes = $data["mon"]-1;
	     $ano = $data["year"];
	     if($mes ==0) {
	     	$mes = 12;
	     	$ano--;
	     }
	     
	     $primeiro_dia = date("d/m/Y", strtotime("$mes/01/$ano"));
	     $ultimo_dia = date("t/m/Y", strtotime("$mes/01/$ano"));

	     

	     print "<script>\n";
	     print "function erpme_periodo() {switch(\$('#erpme_data_comum').val()) { case '1':periodo_hoje();break;case '2':periodo_mes();break;case '3':periodo_ano();break;case '4':periodo_mes_passado();break}}";
	     print "function periodo_mes() {\$('#$this->inicio').val('".date('01/m/Y',time())."');\$('#$this->fim').val('$hoje');}\n";
	     print "function periodo_hoje() {\$('#$this->inicio').val('$hoje');\$('#$this->fim').val('$hoje');}\n";
	     print "function periodo_ano() {\$('#$this->inicio').val('".date('01/01/Y',time())."');\$('#$this->fim').val('$hoje');}\n";
	     print "function periodo_mes_passado() {\$('#$this->inicio').val('$primeiro_dia');\$('#$this->fim').val('$ultimo_dia');}\n";
	     
	     print "</script>\n";


    } 
    
    
	public function __invoke()
    {
        $this->ShowMe();
    }
   
	public function InicioSet($value)
    {
        $this->InicioText = $value;
    }
   
	public function FimSet($value)
    {
        $this->FimText = $value;
    }
   
    
};
?>