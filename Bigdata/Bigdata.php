<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/modulo/modulo.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/alerta/alerta.php";

class Bigdata extends modulo {
    
    public function __construct() {
        
        parent::__construct();
        
        
        
        $this->name  = "Bigdata";
        $this->sigla = "BIG";
        $this->icone = "fas fa-hashtag";
        
    }
    
    public function get_data() {
        
        $hora = date('G');
        
        $vivo = $this->get_json_file("/dados/cap/status/bigdata/vivo.json");

        if($vivo->quando >= Date("Y-m-d"))
            $vivo->status = "OK";
        else 
            $vivo->status = "Não OK";
        
   
        $claro = $this->get_json_file("/dados/cap/status/bigdata/claro.json");

        if($claro->quando >= Date("Y-m-d"))
            $claro->status = "OK";
        else 
            $claro->status = "Não OK";
                

        $oi = $this->get_json_file("/dados/cap/status/bigdata/oi.json");

        if($oi->quando >= Date("Y-m-d"))
            $oi->status = "OK";
        else 
            $oi->status = "Não OK";        
        
        $tim = $this->get_json_file("/dados/cap/status/bigdata/tim.json");

        if($tim->quando >= Date("Y-m-d"))
            $tim->status = "OK";
        else 
            $tim->status = "Não OK";   
        
        
        $claro->volumeF = number_format($claro->volume, 0, ",", ".");
        $vivo->volumeF = number_format($vivo->volume, 0, ",", ".");
        $oi->volumeF = number_format($oi->volume, 0, ",", ".");
        $tim->volumeF = number_format($tim->volume, 0, ",", ".");
        
        
        $claro->quandoF = $this->formata_data($claro->quando);
        $vivo->quandoF = $this->formata_data($vivo->quando);
        $tim->quandoF = $this->formata_data($tim->quando);
        $oi->quandoF = $this->formata_data($oi->quando);        
        
        
        $this->itens['vivo' ]   = $vivo;
        $this->itens['claro']   = $claro;
        $this->itens['tim'  ]   = $tim;
        $this->itens['oi'   ]   = $oi;
        
        $al = new alerta();
        
        foreach($this->itens as $item => $obj) {
            if($obj->status=='Não OK' && $hora > 10 ) {
    //            $al->registra("bigdata", $item, $obj->quando, "Arquivo não carregado ou ausente", 1, 1);
            }
            
        }
        
    }
    

    
    public function front_call() {
        
         parent::front_call();

    }
    public function back_call() {
        date_default_timezone_set ("America/Sao_Paulo");
        $hora = date('G');
        if($hora > 19 || $hora < 6 ) 
            $dark = "dark";
        else 
        	$dark = "";
        

        $this->get_data();
        
        
        echo <<<EOT

        <div class='xcard $dark'>
            <div >
                <header class=r'card-header'>
                    <font color=black>BIGDATA</font><br>
                </header>
                <div class='card-content'>
                    <table width=100%>
                        <tr>
                            <td><b>Operadora</b></td>
                            <td><b>Volume</b></td>
                            <td><b>Data do Arquivo</b></td>
                            <td><b>Status</b></td>
                        </tr>
                        <tr>
                            <td><b>Claro</b></td>
                            <td>{$this->itens['claro']->volumeF}</td>
                            <td>{$this->itens['claro']->quandoF}</td>
                            <td>{$this->itens['claro']->status}</td>
                        </tr>
                        <tr>
                            <td><b>Oi</b></td>
                            <td>{$this->itens['oi']->volumeF}</td>
                            <td>{$this->itens['oi']->quandoF}</td>
                            <td>{$this->itens['oi']->status}</td>
                        </tr>
                        <tr>
                            <td><b>TIM</b></td>
                            <td>{$this->itens['tim']->volumeF}</td>
                            <td>{$this->itens['tim']->quandoF}</td>
                            <td>{$this->itens['tim']->status}</td>
                        </tr>
                        <tr>
                            <td><b>Vivo</b></td>
                            <td>{$this->itens['vivo']->volumeF}</td>
                            <td>{$this->itens['vivo']->quandoF}</td>
                            <td>{$this->itens['vivo']->status}</td>
                        </tr>
                    </table>
                            <p>
                            
                    <table width=100%>
                        <tr>
                            <td><b>Brasil</b></td>
                            <td><b>Dia (D)</b></td>
                            <td><b>Índice</b></td>
                            <td><b>D-1</b></td>
                            <td><b>D-7</b></td>
                        </tr>
                            
EOT;

        $brasil = fopen("/dados/cap/status/bigdata/painel_brasil.csv","r");
        $linha = fgets($brasil);
        $linha = fgets($brasil);
        fclose($brasil);
        list($dia,$indice,$delta,$mostra,$delta8 ) = explode("|",$linha);
      
        print"<tr>";
        print "<td> - </td>";
        print "<td>".$this->formata_data($dia)."</td>";
        print "<td>".number_format($indice,2,",",".")."</td>";
        print "<td>".number_format($delta,2,",",".")."</td>";
        print "<td>".number_format($delta8,2,",",".")."</td>";
        print"<tr>";
        echo <<<EOT
            <tr>
            <td><b>UF</b></td>
            <td><b>Dia (D)</b></td>
            <td><b>Índice</b></td>
            <td><b>D-1</b></td>
            <td><b>D-7</b></td>
            </tr>
EOT;
        $fuf = fopen("/dados/cap/status/bigdata/painel_uf.csv","r");
        
        $linha = fgets($fuf);
        $linha = fgets($fuf);
        while(!feof($fuf)) {
           
            list($suf,$dia,$uf,$indice,$delta,$mostra,$delta8,$cod_uf,$uf2,$nm_estado) = explode("|",$linha);
            print"<tr>";
            print "<td>$suf</td>";
            print "<td>".$this->formata_data($dia)."</td>";
            print "<td>".number_format($indice,2,",",".")."</td>";
            print "<td>".number_format($delta,2,",",".")."</td>";
            print "<td>".number_format($delta8,2,",",".")."</td>";
            print"<tr>";
             $linha = fgets($fuf);
        }
        
        fclose($fuf);
        echo <<<EOT
            <tr>
            <td><b>CIDADE</b></td>
            <td><b>Dia (D)</b></td>
            <td><b>Índice</b></td>
            <td><b>D-1</b></td>
            <td><b>D-7</b></td>
            </tr>
EOT;
        $capital = fopen("/dados/cap/status/bigdata/painel_capital.csv","r");
        
        $linha = fgets($capital);
        $linha = fgets($capital);
        while(!feof($capital)) {
           
            list($cidade,$dia,$codmun,$indice,$delta,$mostra,$delta8) = explode("|",$linha);
            print"<tr>";
            print "<td>$cidade</td>";
            print "<td>".$this->formata_data($dia)."</td>";
            print "<td>".number_format($indice,2,",",".")."</td>";
            print "<td>".number_format($delta,2,",",".")."</td>";
            print "<td>".number_format($delta8,2,",",".")."</td>";
            print"<tr>";
             $linha = fgets($capital);
        }
        
        fclose($capital);
                    
        echo <<<EOT
                    </table>
                </div>
            </div>
        </div>
EOT;

    }
}

$big = new Bigdata();

if(isset($_GET['back']))
    $big->back_call();



