<?php

// if($_SERVER['DOCUMENT_ROOT']!='..')
//     require_once $_SERVER["DOCUMENT_ROOT"]."/erpme/seg/valida.php";

// class propriedade {
//     public $nome;
//     public $valor;
// }

// class item {
//     public $nome;
//     public $propriedades;
// }

// class modulo {

//     public $name;
//     public $id;
//     public $icone;
//     public $sigla;
//     public $itens;

//     function __construct() {

//         if($_SERVER['DOCUMENT_ROOT']!='..') {

//             session_start();
//             if (!isset($_SESSION['login_userId']) ) {

//                 header('Location: /login.php');
//                 exit(0);
//             }
//         }


//         $this->propriedades = array();
//     }


//     function front_call() {
//           $js =  <<<EOT
//         function {$this->name}_front(){
//           	menu=document.getElementById("menu");
// 	        menu.style.display = 'none';
//         	conteudo=document.getElementById("conteudo");
// 		conteudo.style.display = 'block';
// 		conteudo.innerHTML = "carregando";
// 	        post = new XMLHttpRequest();
//         	post.onreadystatechange = function() {
// 	            if (this.readyState == 4 && this.status == 200) {
//         	          conteudo.innerHTML = this.responseText;
//                     }
//                 };                    


//               	post.open("POST", "$this->name/$this->name.php?back", true);
// 		post.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
// 		post.send("cod=1");
//         };
// EOT;

//         print $js;

//     }
//     function back_call() {

//     }

//     function get_data() {
//     }

//     function get_json_file($filename) {
//         $szJson =  file_get_contents($filename);
//         return json_decode($szJson);        
//     }


//     function validate() {
//     }

//    function Button() {
//        $html =  <<<EOT
// 		<div style='width:160px;margin:5px;' id="{$this->name}">
// 			<div class="dbox dbox--color-2">
// 				<div class="dbox__icon">
// 					<i class="{$this->icone}"></i>
// 				</div>
// 				<div class="dbox__body">
// 					<span class="dbox__count" id={$this->name}_count>{$this->valor}</span>
// 					<span class="dbox__title" id={$this->name}_title>{$this->texto}</span>
// 				</div>

// 				<div class="dbox__action">
// 					<button  onclick="{$this->name}_front();" class="dbox__action__btn">{$this->sigla}</button>
// 				</div>				
// 			</div>
// 		</div>       
// EOT;
//         print $html;
//    }    

//    function Oldbutton() {

//        $html =  <<<EOT
//                         <button id="{$this->name}" class="butCard" onclick="{$this->name}_front();"> 
//             	<div class="card-icon"><i class="{$this->icone}" style="font-size:50px;margin-bottom: 6px"></i></div>  
//              		{$this->sigla}
//                 </button>     

// EOT;
//         print $html;
//     }    

//     function formata_data($data) {

//         return substr($data,8,2)."/".substr($data,5,2)."/".substr($data,0,4).substr($data,10);

//     }

// }




if ($_SERVER['DOCUMENT_ROOT'] != '..')
    require_once $_SERVER["DOCUMENT_ROOT"] . "/erpme/seg/valida.php";

class propriedade
{
    public $nome;
    public $valor;
}

class item
{
    public $nome;
    public $propriedades;
}

class modulo
{

    public $name;
    public $id;
    public $icone;
    public $sigla;
    public $itens;
    public $valor;  // Añadido
    public $texto;  // Añadido

    function __construct()
    {

        if ($_SERVER['DOCUMENT_ROOT'] != '..') {

            session_start();
            if (!isset($_SESSION['login_userId'])) {

                header('Location: /login.php');
                exit(0);
            }
        }


        $this->propriedades = array();
    }


    function front_call()
    {
        $js = <<<EOT
        function {$this->name}_front(){
          	menu=document.getElementById("menu");
	        menu.style.display = 'none';
        	conteudo=document.getElementById("conteudo");
		conteudo.style.display = 'block';
		conteudo.innerHTML = "carregando";
	        post = new XMLHttpRequest();
        	post.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {
        	          conteudo.innerHTML = this.responseText;
                    }
                };                    
        
        
              	post.open("POST", "$this->name/$this->name.php?back", true);
		post.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		post.send("cod=1");
        };
EOT;

        print $js;

    }
    function back_call()
    {

    }

    function get_data()
    {
    }

    function get_json_file($filename)
    {
        $szJson = file_get_contents($filename);
        return json_decode($szJson);
    }


    function validate()
    {
    }

    function Button()
    {
        $html = <<<EOT
		<div style='width:160px;margin:5px;' id="{$this->name}">
			<div class="dbox dbox--color-2">
				<div class="dbox__icon">
					<i class="{$this->icone}"></i>
				</div>
				<div class="dbox__body">
					<span class="dbox__count" id={$this->name}_count>{$this->valor}</span>
					<span class="dbox__title" id={$this->name}_title>{$this->texto}</span>
				</div>
				
				<div class="dbox__action">
					<button  onclick="{$this->name}_front();" class="dbox__action__btn">{$this->sigla}</button>
				</div>				
			</div>
		</div>       
EOT;
        print $html;
    }

    function Oldbutton()
    {

        $html = <<<EOT
                        <button id="{$this->name}" class="butCard" onclick="{$this->name}_front();"> 
            	<div class="card-icon"><i class="{$this->icone}" style="font-size:50px;margin-bottom: 6px"></i></div>  
             		{$this->sigla}
                </button>     
               
EOT;
        print $html;
    }

    function formata_data($data)
    {

        return substr($data, 8, 2) . "/" . substr($data, 5, 2) . "/" . substr($data, 0, 4) . substr($data, 10);

    }

}
