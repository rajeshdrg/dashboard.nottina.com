<!DOCTYPE html>
<html lang="pt-br">
<head>
<link href="jquery.dataTables.min.css" rel="stylesheet">
<script src="jquery-3.2.1.min.js"></script>
  <script src="jquery.dataTables.min.js"></script>
  <meta charset="UTF-8">
  <title>teste table</title>
<script>

$(document).ready(function() {
    $('#example').DataTable( {
        "processing": true,
        "ajax": "data.xml",
        "columns": [
            { "data": "name" },
            { "data": "hr.position" },
            { "data": "contact.0" },
            { "data": "contact.1" },
            { "data": "hr.start_date" },
	    { "data": "hr.salary" }
        ]
    } );
} );

<?php
print "teste";
?>

</script> 
</head>
<body>
<table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Extn.</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Extn.</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </tfoot>
    </table>
</body>
</html>
