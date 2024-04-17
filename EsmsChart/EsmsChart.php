<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/modulo/modulo.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/alerta/alerta.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/GatewaySMS/GatewaySMS.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/Esms/EsmsAlerta.php";

class EsmsChart extends modulo {


	public $chart;
        public $data_inicio;
        public $data_fim;
 
    
    public function __construct() {
        
        
        parent::__construct();
        
        
        $this->name  = "EsmsChart";
        $this->sigla = "E-SMS Chart";
        $this->icone = "fa fa-mobile";
        
        $this->data_inicio = date("Y-m-d 00:00");
        $this->data_fim    = date("Y-m-d H:i");
        
    }
    
    public function get_data() {
        
        $hora = date('G');

        
    }
    
    public function front_call() {
        
        $js =  <<<EOT
     
        function plota_grafico(item, index) {
            var options = {legend: {position: 'none'}, };
            graficos=document.getElementById("graficos");
            if(graficos) {
                var node = document.createElement("DIV"); 
                node.setAttribute("id", item[0][0]);
                node.setAttribute("style", 'border:solid;margin:10px;width:48%;');
                graficos.appendChild(node);
                var gdata = google.visualization.arrayToDataTable(item);  
                var chart = new google.charts.Line(node);
                chart.draw(gdata,google.charts.Line.convertOptions(options));
            }
        }
                
        function drawDashboard(){
            graficos = document.getElementById("graficos");
            data_inicio = document.getElementById("data_inicio").value;
            data_fim = document.getElementById("data_fim").value;
            graficos.innerHTML = "";
            post = new XMLHttpRequest();
            post.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var data = JSON.parse(this.responseText);
                    data.forEach(plota_grafico);
                }
            };
            post.open("POST", "/dashboard/dados.php", true);
            //post.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            post.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            post.send("data_inicio="+data_inicio+"&data_fim="+data_fim);
        }
    
        function {$this->name}_front(){
          	menu=document.getElementById("menu");
	        menu.style.display = 'none';
        	conteudo=document.getElementById("conteudo");
		conteudo.style.display = 'block';
		conteudo.innerHTML = "carregando";
	        post = new XMLHttpRequest();
        	post.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {
                          conteudo.innerHTML = '<div id=alerta_grafico  style="display: block;"><div id=filtro><input type=text id=data_inicio name=data_inicio value="{$this->data_inicio}"> <input type=text id=data_fim name=data_fim value="{$this->data_fim}"><button onclick="drawDashboard();">Consultar</button></div><div id="graficos" style="display: flex;flex-direction: row;flex-wrap: wrap  "></div></div>';
                          drawDashboard();
                    }
                };                    
        
        
              	post.open("POST", "$this->name/$this->name.php?back", true);
		post.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		post.send("cod=1");
        };
EOT;

        print $js;

    }
    
    public function back_call() {
        $this->get_data();
    }
    
    public function ShowMe() {
        date_default_timezone_set ("America/Sao_Paulo");
        $hora = date('G');
        if($hora > 19 || $hora < 6 ) 
            $dark = "dark";
        else 
        	$dark = "";
        
        ?>

        <?php
    }    
    
}

$esmschart = new EsmsChart();

if(isset($_GET['back'])) {
    $esmschart->back_call();
    $esmschart->ShowMe();
}



