<?php

class dates {
    
    var $date;
    
    function dates($date) {
        $this->date = $date;
    }
	
    function data_parcela($parcela)
    {

        $ano = substr($this->date,0,4);
        $mes = substr($this->date,5,2);
        $dia = substr($this->date,8,2);

        $addmes = $ano*12 + $mes + $parcela-1;
        $ano = (int) ($addmes / 12);

        $mes =  $addmes % 12;

        $ultimo =  date("t", mktime(0,0,0,$mes,'01',$ano));
        if($dia > $ultimo ) $dia = $ultimo;

        return( date("Y-m-d", mktime(0,0,0,$mes,$dia,$ano)));

    }
  
};
?>