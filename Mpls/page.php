<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/modulo/modulo.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Planilha de Dados XML</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
</head>
<body>
<h2>Planilha de Dados XML</h2>
<table id="data-table">
    <thead>
    <tr>
        <th>Empresa</th>
        <th>Designação</th>
        <th>Wan</th>
        <th>Subrede</th>
        <th>Status</th>
        <th>endereco</th>
    </tr>
    </thead>
    <tbody>

    <?php
    $xml = simplexml_load_file('/dados/cap/status/mpls_abrv3-zabbix.abrtelecom.com.br.xml');

    foreach ($xml->circuito as $circuito) {
        echo "<tr>";
        echo "<td>" . $circuito->empresa . "</td>";
        echo "<td>" . $circuito->designacao . "</td>";
        echo "<td>" . $circuito->wan . "</td>";
        echo "<td>" . $circuito->subrede . "</td>";
        echo "<td>" . $circuito->status . "</td>";
        echo "<td>" . $circuito->endereco . "</td>";
        echo "</tr>";
    }
    ?>

    </tbody>
</table>

<script>
    $(document).ready(function () {
        $('#data-table').DataTable();
    });
</script>

</body>
</html>

