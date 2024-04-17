<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/modulo/modulo.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/alerta/alerta.php";

class NMP extends modulo {


	public $usuarios;
	public $telefones;
	public $contatos;
	public $conexoes;

	public $usuariosF;
	public $telefonesF;
	public $contatosF;
	public $conexoesF;
        public $data_cloudF;
        public $hora_cloudF;
        public $data_eqF;
        public $hora_eqF;
    
    public function __construct() {
        
        parent::__construct();
        
        
        $this->name  = "NMP";
        $this->sigla = "NMP";
        $this->icone = "fas fa-headset";
        
        
    }
    
    public function get_data() {
        
        $hora = date('G');
        
        $cloud = $this->get_json_file("/dados/cap/status/nmp/nmp.json");
        $eq     = $this->get_json_file("/dados/cap/status/nmp/nmp_contato.json");

        
        $this->usuariosF    = number_format($cloud->cadastros, 0, ",", ".");
        $this->telefonesF   = number_format($cloud->telefones, 0, ",", ".");
        $this->conexoesF    = number_format($cloud->conexoes_sql, 0, ",", ".");
        $this->contatosF    = number_format($eq->contatos, 0, ",", ".");
        $this->data_cloudF  = $cloud->data;
        //$this->hora_cloudF  = $cloud->hora;
        
        $this->data_eqF  = $eq->data;
        $this->hora_eqF  = $eq->hora;
        
        
        $al = new alerta();
        
            if($cloud->cadastros <= 2  && $hora > 1 ) {
                $al->registra("nmp", "Usuarios", date('Y-m-d H:i'), "Volume baixo de usuarios", 1, 1);
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
                    <font color=black>NMP</font><br>
                </header>
                <div class='card-content'>
                    <table width=100%>
                        <tr>
                            <td><b>Usuarios</b></td>
                            <td><b>Telefones</b></td>
                            <td><b>Contato</b></td>
                            <td><b>Conexoes</b></td>
                        </tr>
                        <tr>
                            <td>{$this->usuariosF}</td>
                            <td>{$this->telefonesF}</td>
                            <td>{$this->contatosF}</td>
                            <td>{$this->conexoesF}</td>
                        </tr>
                        <tr>
                            <td>{$this->data_cloudF}</td>

                            <td>{$this->data_cloudF}</td>
                            <td>{$this->data_eqF}</td>                            
                            <td>{$this->data_cloudF}</td>
                        </tr>
                        <tr>
                            <td>{$this->hora_cloudF}</td>

                            <td>{$this->hora_cloudF}</td>
                            <td>{$this->hora_eqF}</td>                            
                            <td>{$this->hora_cloudF}</td>
                        </tr>
                    </table>
                            <p>
                            
                </div>
            </div>
        </div>
EOT;

    }
}

$nmp = new NMP();

if(isset($_GET['back']))
    $nmp->back_call();



