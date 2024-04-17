<?php
class 
$result = pg_query_params($dbconn, 'SELECT * FROM shops WHERE name = $1', array("Joe's Widgets"));
?>

