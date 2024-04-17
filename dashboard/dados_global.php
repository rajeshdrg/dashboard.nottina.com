<?php

include "../erpme/banco/conecta.php" ;
include "../erpme/banco/sqlcommand.php" ;
include "../erpme/banco/sqldatareader.php" ;

$item = implode("', '",$_POST['item']);



$data_inicio = date("Y-m-d 00:00");

$Sql = new SqlCommand("Sql");
$Sql->connection = $conexao;

$Sql->query = "select spid,prestadora,item,to_char(m1.pit::time, 'HH24:MI') as px, m1.v3  m1 from measure m1 
        left outer join bind on m1.item = bind.smsc 
        where 
        m1.pit >= $1 and servico  = 'Global' and (modo = 'T'  or modo = 'TR' )  
        order by item,m1.pit";
$Sql->params = array($data_inicio);

$dr = $Sql->ExecuteReader();




$data = array();

$spid_ct = 0;
$item_ct = 1;

$item_anterior= "---";
$row_number = 0;
while($o=$dr->GetObject()) {


    $cl = 0;
    
    $spid_anterior=$o->spid;
    
    $item_anterior          = $o->item;
    if($item_ct==1)
        $data[$spid_ct][$cl][0]         = 'TPS ' . $o->prestadora;
    $data[$spid_ct][$cl][$item_ct]  = $o->item;
    $cl++;
    
    if($item_ct==1)
        $data[$spid_ct][$cl][0] = $o->px;
    
    $data[$spid_ct][$cl][$item_ct]  = floatval($o->m1);
    $cl++;
    
 
    
    while(($o=$dr->GetObject()) && $o->item==$item_anterior) {
        $row_number++;
      
            if($item_ct==1)
                $data[$spid_ct][$cl][0] = $o->px;
            $data[$spid_ct][$cl][$item_ct] = floatval($o->m1);
            $cl++;
    
    }

   
    $item_ct++;
    
    if($o!=false ) {
        if($spid_anterior!= $o->spid) {
        
            $item_ct=1;
            $spid_ct++;
        }
        //error_log( "$row_number $o->spid  $o->item" );
        pg_result_seek($dr->Result,  $row_number+1 );
    }
     
    $row_number++;
    
        
}

print json_encode($data);


