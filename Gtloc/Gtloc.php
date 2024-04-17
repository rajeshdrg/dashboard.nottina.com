<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/modulo/modulo.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/alerta/alerta.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/Gtloc/VolumeGtloc.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/Gtloc/GtConex.php";

require_once $_SERVER["DOCUMENT_ROOT"]."/alerta/alerta.php";

class Gtloc extends modulo {


	public $server;
        public $gateway;
        public $operadora;
        public $conex;
        public $volume;
        public $atz_sp;
        public $atz_pr;
 
    
    public function __construct() {
        
       parent::__construct();
        
       $this->name  = "Gtloc";
       $this->sigla = "GTLOC";
       $this->icone = "fa fa-map-marker";

       $this->conex=array();
       $this->conex['Tim']          = new GtConex('TIM');
       $this->conex['Vivo']         = new GtConex('Vivo');
       //$this->conex['Sercomtel']    = new GtConex('Sercomtel');
       $this->conex['Algar']        = new GtConex('Algar');
       $this->conex['Claro']        = new GtConex('Claro');
       $this->conex['Oi']           = new GtConex('Oi');
       $this->conex['PC DF']        = new GtConex('PC DF');
       $this->conex['SSP/DF']       = new GtConex('SSP/DF');
       $this->conex['PM/SP']        = new GtConex('PM/SP');
       $this->conex['SSP/MT']       = new GtConex('SSP/MT');
       $this->conex['SSP/AL']       = new GtConex('SSP/AL');
       $this->conex['SSP/GO']       = new GtConex('SSP/GO');
       $this->conex['SSP/BA']       = new GtConex('SSP/BA');
       $this->conex['PM/SC']        = new GtConex('PM/SC');
       $this->conex['BM/SC']        = new GtConex('BM/SC');
       $this->conex['SSP/MG']       = new GtConex('SSP/MG');
       $this->conex['SSP/CE']       = new GtConex('SSP/CE');
       $this->conex['PM/PR']        = new GtConex('PM/PR');
//       $this->conex['SSP/AC']       = new GtConex('SSP/AC');
       $this->operadora=array();
       $this->operadora['TIM']          = new GtVolume('TIM');
       $this->operadora['Vivo']         = new GtVolume('Vivo');
       $this->operadora['Sercomtel']    = new GtVolume('Sercomtel');
       $this->operadora['Algar']        = new GtVolume('Algar');
       $this->operadora['Claro']        = new GtVolume('Claro');
       //$this->operadora['Nextel']       = new GtVolume('Nextel');
       $this->operadora['Oi']           = new GtVolume('Oi');

        
       $this->gateway["SP"] = "/dados/cap/status/conexoes_sp1.xml"; 
       $this->gateway["PR"] = "/dados/cap/status/conexoes_pr1.xml"; 
       
       $this->volume["SP"] = "/dados/cap/status/broker_sp.xml";
       $this->volume["PR"] = "/dados/cap/status/broker_pr.xml";
        
    }
    
    public function get_data() {
	date_default_timezone_set ("America/Sao_Paulo");
        
        $hora = date('G');
	$al = new alerta();

        foreach($this->gateway as $uf=>$gt) {

            $len = filesize($gt);
            $atualizacao =  date ( "d/m/Y H:i:s.", filemtime($gt));

            $arq = fopen($gt,"r");

            if($arq==null) {
                print "Erro: arquivo xml não encontrado<br>;";
                exit(0);
            }

            $xmlstr = fread($arq,$len);

            fclose($arq);

            $xmlc= new SimpleXMLElement($xmlstr);

            $site =  $xmlc->site;

            if($uf=="SP")
		    $this->atz_sp = $xmlc->atualizacao;

            if($uf=="PR")
                   $this->atz_pr = $xmlc->atualizacao;
            
            foreach($xmlc->item as $i) {
                if($uf=="SP")
			$this->conex["$i->operadora"]->conexao_sp  = $i->conexao;

                if($uf=="PR")
                    $this->conex["$i->operadora"]->conexao_pr  = $i->conexao;
	
		#if( $i->conexao != "OK" && $hora < 19 &&  $hora > 6 )  
		#    $al->registra("Gtloc","$i->operadora:$uf","$atualizacao", "GTLOC registre no INCBROKER", 1, 1);
		    
            }
        }
        // Volume
        foreach($this->volume as $uf=>$gt) {

            $len = filesize($gt);
            $atualizacao =  date ( "d/m/Y H:i:s.", filemtime($gt));

            $arq = fopen($gt,"r");

            if($arq==null) {
                print "Erro: arquivo xml não encontrado<br>;";
                exit(0);
            }

            $xmlstr = fread($arq,$len);

            fclose($arq);

            $xmlc= new SimpleXMLElement($xmlstr);

            $site =  $xmlc->site;
            
            foreach($xmlc->item as $i) {
                if($uf=="SP")
		    $this->operadora["$i->operadora"]->volume_sp  = $i->volume;;

                if($uf=="PR")
                    $this->operadora["$i->operadora"]->volume_pr  = $i->volume;;
            }
        }
        
        
    }
    
    public function front_call() {
        
         parent::front_call();


    }
    
    public function back_call() {
        $this->get_data();
    }
    
    public function ShowMe() {

	$MIGRADOS=" PM/SC TIM Oi Algar SSP/AL PM/PR SSP/AC SSP/GO PC DF SSP/CE PM/SP SSP/MT SSP/DF SSP/MG SSP/BA Vivo";

        date_default_timezone_set ("America/Sao_Paulo");
        $hora = date('G');
        if($hora > 19 || $hora < 6 ) 
            $dark = "dark";
        else 
        	$dark = "";

        
        print  "<div class='card $dark' style='width:auto;height:auto'>";
	print "<header class=r'card-header'>";
	print "<b>Conexões</b><br>";
        
        
        print "</header>";
	print "<div class='card-content'>";
        
        print "<span style='display:inline-block; width:120px;'><font color=blue> <b>Conexão</b> </font> </span>";
        print "<span style='display:inline-block; width:120px;'><font color=blue> <b>SP $this->atz_sp</b> </font> </span>";
        print "<span style='display:inline-block; width:120px;'><font color=blue> <b>PR $this->atz_pr</b> </font> </span>";
        
        foreach($this->conex as $cx) {
                    
                    
            print "<p>";
 
            print  "<span style='display:inline-block; width:120px;'><font color=blue>";
            print "<b>".$cx->nome."</b>";
            print "</font>";
            print "</span>";

            if($cx->conexao_sp == "OK")
                print  "<span style='display:inline-block; width:120px;'><font color=green>";
            else
                print  "<span style='display:inline-block; width:120px;'><font color=red>";
            print  $cx->conexao_sp;
            print "</font>";
            print "</span>";

            if($cx->conexao_pr == "OK") {
                print  "<span style='display:inline-block; width:120px;'><font color=green>";
		print  $cx->conexao_pr;
	    }
	    else{
		if(!strpos($MIGRADOS,$cx->nome)>0)
		    print  "<span style='display:inline-block; width:120px;'><font color=gray>-";	
		else{
		    print  "<span style='display:inline-block; width:120px;'><font color=red>";
		    print  $cx->conexao_pr;
		}

	    }
            print "</font>";
            print "</span>";
            print "</p>";

        }
        print "</div>";
        print "</div>";
       
    
    // volume
        
        print  "<div class='card $dark'>";
	print "<header class=r'card-header'>";
	print "<b>Conexões</b><br>";
        
        
        print "</header>";
	print "<div class='card-content'>";
        
        print "<table width='100%'>";
        print "<thead>";
        print "<th align=left>Operadora</th><th align=right>SP</th><th align=right>PR</th><th align=right>Total</th>";
        print "</thead>";
        print "<tbody>";
        
        
        foreach($this->operadora as $k =>$v) {
            print "<tr>";

            print "<td><b>".$k."</b></td>";

            print "<td align=right>".number_format((float) $v->volume_sp,0, ",",".")."</td>";
            print "<td align=right>".number_format((float) $v->volume_pr,0, ",",".")."</td>";
            print "<td align=right>".number_format((float) $v->volume_sp+ (float) $v->volume_pr,0, ",",".")."</td>";
            print "</tr>";
        }
        print "</table>";
    
    
    }
    
    
}

$gtloc = new Gtloc();

if(isset($_GET['back'])) {
    $gtloc->back_call();
    $gtloc->ShowMe();
}



