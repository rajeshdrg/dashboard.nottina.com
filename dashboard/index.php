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
  
  
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
   
    <script type="text/javascript">
     
     
    function plota_grafico(item, index) {
        
                            
        var options = {
            legend: {position: 'none'}, };
        
        graficos=document.getElementById("graficos");
        var node = document.createElement("DIV"); 
      
        node.setAttribute("id", item[0][0]);
        node.setAttribute("style", 'border:solid;margin-bottom:10px;width:48%;');
        graficos.appendChild(node);
        
        var gdata = google.visualization.arrayToDataTable(item);  
        var chart = new google.charts.Line(node);
        chart.draw(gdata,google.charts.Line.convertOptions(options));
        
    }
     
    function drawDashboard(){

        post = new XMLHttpRequest();
        post.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var data = JSON.parse(this.responseText);
                data.forEach(plota_grafico);
            }
        };
        
       	post.open("POST", "js.php", true);
        //post.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	post.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	post.send("item[]=s0341-1&item[]=s0341-2");
    }

    // Load the Visualization API and the controls package.
    google.charts.load('current', {'packages':['corechart', 'controls']});
    google.charts.load('current', {'packages':['line']});
      
    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(drawDashboard);

  </script>
  <title>Painel PWA</title>

  
  <style>    
.discussion {
  list-style: none;
  background: #e5e5e5;
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
  background: white;
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
  color: black;
}
@media (min-width:150px) and (max-width:1060px){
    
.discussion {
  list-style: none;
  background: #e5e5e5;
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
        
        

   </script>



</head>
<body>


  <!--=================================
              CONTEUDO
   ===================================-->  

  <main class="main">

      
      <div id="graficos" style="display: flex;flex-direction: row;flex-wrap: wrap  "></div> 


</body>
</html>



