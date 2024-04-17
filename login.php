<?php

$base = base64_encode(md5($_SERVER['SERVER_NAME'].'asdfkadfj723462q63rgiasdf'));
if(isset($_GET['motivo']))  {
        if($_GET['motivo']=="limite_login") {
            header('location:https://lcen.nottina.com/?e='.$base.'&ex=4');
            exit(0);
        }
        
}

header('location:https://lcen.nottina.com/?e='.$base);


