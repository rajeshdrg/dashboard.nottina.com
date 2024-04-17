<?php

class GetField {

	
    function string($field) {
        if(isset($_POST[$field])) {
            $raw = $_POST[$field];
        }
        else return NULL;
        
        return  $raw;
    }
    
    function int($field) {
        if(isset($_POST[$field])) {
            $raw = $_POST[$field];
        }
        else return NULL;
        
        return intval($raw);
    }
    function real($field) {
        if(isset($_POST[$field])) {
            $raw = $_POST[$field];
        }
        else return NULL;
        
        return floatval($raw);
    }
    function realbrdb($field) {
        if(isset($_POST[$field])) {
            $raw = $_POST[$field];
        }
        else return NULL;

        if(empty($raw))
            return NULL;
        return strtr ( $numero , "," , "." );
    }
    function realdbbr($field) {
        if(isset($_POST[$field])) {
            $raw = $_POST[$field];
        }
        else return NULL;

        if(empty($raw))
            return NULL;
        return strtr ( $numero , "." , "," );
    }
    function datedbbr($field) {
        if(isset($_POST[$field])) {
            $raw = $_POST[$field];
        }
        else return NULL;
        
        if(strlen($raw)!=10 ) {
            return(NULL);
        }
	list($y, $m, $d) = preg_split('/-/', $raw);
	return sprintf('%02d/%02d/%4d', $d, $m, $y);
    }
    function datebrdb($field) {
        if(isset($_POST[$field])) {
            $raw = $_POST[$field];
        }
        else return NULL;

        $raw = trim($raw);
        if(strlen($raw)!=10 ) 
            return NULL;
        
        list($d, $m, $y) = preg_split('/\//', $date);
        return sprintf('\'%4d%02d%02d\'', $y, $m, $d);
	}
    function shortdatebrdb($field) {
        if(isset($_POST[$field])) {
            $raw = $_POST[$field];
        }
        else return NULL;

        $raw = trim($raw);
        if(strlen($raw)!=8 ) 
            return NULL;
        
        list($d, $m, $y) = preg_split('-', $date);
        return sprintf('\'20%2d%02d%02d\'', $y, $m, $d);
	}	        
};
?>