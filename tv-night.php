<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/erpme/seg/valida.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head> 
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <meta name="Painel" content="#254C75"/>
  
  <title>Painel PWA</title>

  <link rel="stylesheet" type="text/css" href="css/principal-night.css"/>
  <link rel="stylesheet" type="text/css" href="css/fontawesome-all.min.css"/> 
  <link rel="manifest" href="manifest.json"/> 
  
  
  <style>    
.discussion {
  list-style: none;
  background: #000000;
  box-sizing:border-box;
  width: 42%; 
  padding: 0 0 50px 0;
  float: left;

}
.discussion li {
  padding: 0.5rem;
  overflow: hidden;
  display: flex;
}
.discussion .avatar {
  width: 40px;
  position: relative;
}

.discussion .ufs {
   padding-top: 5px;
  width: 40px;
  height: 40px;
  position: relative;
  background-color:  #069;
   text-align: center;
   color:white;
}

.avatar:after {
  content: "";
  position: absolute;
  top: 0;
  right: 0;
  width: 0;
  height: 0;
  border: 5px solid white;
  border-left-color: transparent;
  border-bottom-color: transparent;
}

.messages {
  background: black;
  padding: 10px;
  border-radius: 2px;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
}
.messages p {
  font-size: 0.8rem;
  margin: 0 0 0.2rem 0;
}
.messages time {
  font-size: 0.7rem;
  color: #ccc;
}
@media (min-width:150px) and (max-width:1060px){
    
.discussion {
  list-style: none;
  background: #000000;
  margin: 0;
  padding: 0 0 50px 0;
  width: 100%;
  height: auto;
}    
    
    
}
  </style>
  
  
  <!-- ==== PWA === -->
    <meta name="mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="application-name" content="Painel"/>
    <meta name="apple-mobile-web-app-title" content="Painel"/>
    <meta name="theme-color" content="#254C75"/>
    <meta name="msapplication-navbutton-color" content="#254C75"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="msapplication-starturl" content="https://painel.abrtelecom.com.br/"/>

    <script>
        function voltar(){
        
        conteudo=document.getElementById("conteudo");
	conteudo.style.display = 'none';    
            
        menu=document.getElementById("menu");
        menu.style.display = 'block';   
    
        }
        
	function esms() {
     

	conteudo=document.getElementById("conteudo");
	conteudo.style.display = 'block';
	conteudo.innerHTML = "carregando";

	post = new XMLHttpRequest();

	post.onreadystatechange = function() {
        	if (this.readyState == 4 && this.status == 200) {
	            conteudo.innerHTML = this.responseText;
       		}
    	};
        
	post.open("POST", "get_xml.php", true);
	post.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	post.send("cod=1");

	
	}
        
	function gtloc() {


	conteudo=document.getElementById("conteudo");
	conteudo.style.display = 'block';
	conteudo.innerHTML = "carregando";

	post = new XMLHttpRequest();

	post.onreadystatechange = function() {
        	if (this.readyState == 4 && this.status == 200) {
	            conteudo.innerHTML = this.responseText;
       		}
    	};

	post.open("POST", "get_broker.php", true);
	post.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	post.send("cod=1");

	
	}
        function server() {


        conteudo=document.getElementById("conteudo");
        conteudo.style.display = 'block';
        conteudo.innerHTML = "carregando";

        post = new XMLHttpRequest();

        post.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    conteudo.innerHTML = this.responseText;
                }
        };

        post.open("POST", "get_server.php", true);
        post.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        post.send("cod=1");


        }

        
        function sinai(){

        	conteudo=document.getElementById("conteudo");
		conteudo.style.display = 'block';
		conteudo.innerHTML = "carregando";
        
	        post = new XMLHttpRequest();
        
        	post.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {
        	          conteudo.innerHTML = this.responseText;
            	}
        
	        };
        
        	post.open("POST", "get_sinai.php", true);
		post.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		post.send("cod=1");
        
        }

        function pre(){

        	conteudo=document.getElementById("conteudo");
		conteudo.style.display = 'block';
		conteudo.innerHTML = "carregando";
        
	        post = new XMLHttpRequest();
        
        	post.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {
        	          conteudo.innerHTML = this.responseText;
            	}
        
	        };
        
        	post.open("POST", "get_pre.php", true);
		post.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		post.send("cod=1");
        
        }
        
/*        function mpls(){
        	conteudo=document.getElementById("conteudo");
		conteudo.style.display = 'block';
		conteudo.innerHTML = "carregando";
        
	        post = new XMLHttpRequest();
        
        	post.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {
        	          conteudo.innerHTML = this.responseText;
            	}
        
	        };
        
        	post.open("POST", "get_mpls.php", true);
		post.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		post.send("cod=1");
        
        }
*/
        function sites(){
        	conteudo=document.getElementById("conteudo");
		conteudo.style.display = 'block';
		conteudo.innerHTML = "carregando";
        
	        post = new XMLHttpRequest();
        
        	post.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {
        	          conteudo.innerHTML = this.responseText;
            	}
        
	        };
        
        	post.open("POST", "get_www.php", true);
		post.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		post.send("cod=1");
        
        }
        function banco(){
        	conteudo=document.getElementById("conteudo");
		conteudo.style.display = 'block';
		conteudo.innerHTML = "carregando";
        
	        post = new XMLHttpRequest();
        
        	post.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {
        	          conteudo.innerHTML = this.responseText;
            	}
        
	        };
        
        	post.open("POST", "banco/get_banco.php", true);
		post.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		post.send("cod=1");
        
        }
	function nmp(){
                conteudo=document.getElementById("conteudo");
                conteudo.style.display = 'block';
                conteudo.innerHTML = "carregando";

                post = new XMLHttpRequest();

                post.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                          conteudo.innerHTML = this.responseText;
                }

                };

                post.open("POST", "nmp/index.php", true);
                post.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                post.send("cod=1");

        }

        
      var rotate = 1;  
      setInterval(function(){
          
         switch(rotate) {
              case 1:
                server(); 
                break;
            case 2:
                 esms();
                 break;
            
            case 3:
                 gtloc();
                 break;
            
            case 4:
                 sinai();
                 break;
            
            case 5:
                 pre();
                 break;
            
            case 6:
                 sites();
                 break;
            case 7:
                 banco();
                 break;
            case 8:
                 nmp();
                 break;
            }
            rotate++;
            if(rotate > 8) rotate = 1;
      }, 10000);
        
   </script>


</head>
<body>
    
  <!--=================================
           HEADER DESKTOP
   ===================================-->  
  <div class="topo">  
      <div style="width: 2%;height: 100%; float: left;">
          <button class="header_back" onclick="voltar();" style="margin:36px auto auto 8px; font-size: 15pt;">
              <i class="fa fa-arrow-left" style="color:#003366"></i>
          </button>
      </div>
      <div style="width: 30%;height: 100%; float: left;">
	  <img src="images/abr.png"   style="margin:auto auto auto 12px; width: 250px; height: 85px;"/>
      </div>
      <div style="width: 68%;height: 100%; float: left;">
          <a id="btnSair" href="sair.php" class="headerUser" style="width: 35px; height: 35px;margin-top: 50px;"><img src="images/logout_small.png"></a>
          <h4 class="headerUser"><?php print $nome; ?></h4>     
      </div>     
  </div>    
  
  <!--=================================
           HEADER MOBILE
   ===================================-->  
  <header class="header">
        <button class="header_back" onclick="voltar();"><i class="fa fa-arrow-left"></i></button>
        <h1 class="header__title">&nbsp;&nbsp;Painel ABR Telecom</h1>
        <a id="btnSair" href="sair.php"  class="headerButton" ></a>
  </header>
  
  <!--=================================
              CONTEUDO
   ===================================-->  

  <main class="main">
      
    <div class="header_mobile">
        <h3 style="background: #808080;"><?php print $nome; ?></h3>        
    </div>    
      

      <div id='conteudo' style='display:none;'></div>
  </main>


</body>
</html>

