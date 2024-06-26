<?php

//========================================================original===============================================================
// class Cbc
// {
//     private $file;
//     private $xml;
//     private $file_date;

//     public function __construct($file)
//     {
//         if (!file_exists($file)) {
//             throw new Exception("Erro: arquivo não encontrado.");
//         }

//         $this->file = $file;
//         $this->get_data();
//     }

//     private function get_data()
//     {
//         // echo "<script>console.log('Carregando dados XML do arquivo: {$this->file}');</script>";

//         // Lê a data de modificação do arquivo
//         $this->file_date = date("d/m/Y H:i:s", filemtime($this->file));

//         // Lê o conteúdo do arquivo XML
//         $xmlstr = file_get_contents($this->file);

//         if ($xmlstr === false) {
//             throw new Exception("Erro: não foi possível ler o arquivo XML");
//         }

//         // Tentar carregar o XML
//         libxml_use_internal_errors(true); // Habilitar erros libxml
//         $this->xml = simplexml_load_string($xmlstr);

//         if ($this->xml === false) {
//             $errors = libxml_get_errors();
//             libxml_clear_errors();
//             throw new Exception("Erro: conteúdo XML inválido. Detalhes: " . implode(", ", $errors));
//         }

//         // echo "<script>console.log('Dados XML carregados com sucesso');</script>";
//     }

//     public function ShowMe()
//     {
//         date_default_timezone_set("America/Sao_Paulo");
//         $hora = date('G');
//         $dark = ($hora > 19 || $hora < 6) ? "dark" : "";

//         echo "<script>console.log('Mostrando dados XML');</script>";
//         echo "<div class='$dark' style='width:80%; margin: 20px auto;'>";
//         echo "<header class='card-header'>";
//         echo "<b>CBC</b><br>";
//         echo "<span>Última atualização: " . htmlspecialchars($this->file_date) . "</span>";
//         echo "</header>";
//         echo "<div class='card-content'>";

//         // Mostrar dados de MME
//         $this->showMMETable();

//         // Mostrar dados de tecnologia 5G
//         $this->show5GTable();

//         echo "</div>";
//         echo "</div>";
//     }

//     private function showMMETable()
//     {
//         echo "<table class='table table-striped' style='margin-bottom: 20px;'>";
//         echo "<caption>MME</caption>";
//         echo "<thead>";
//         echo "<tr>";
//         echo "<th>Estado/Região</th>";
//         echo "<th>Operadora</th>";
//         echo "<th>MME</th>";
//         echo "<th>Status</th>";
//         echo "<th>Teste</th>";
//         echo "<th>Roteamento</th>";
//         echo "</tr>";
//         echo "</thead>";
//         echo "<tbody>";

//         // Agrupar dados por estado e operadora para MME
//         foreach ($this->xml->cbcAlerta as $alerta) {
//             $estado = (string) $alerta->estado;
//             $operadora = (string) $alerta->cbcAlerta_operadora;

//             $mme = isset($alerta->mme) ? (string) $alerta->mme : '';
//             $status = (string) $alerta->status;
//             $test_done = (string) $alerta->test_done;
//             $routing = (string) $alerta->routing;

//             // Verifique se há dados em todos os campos
//             if (empty($mme) && empty($status) && empty($test_done) && empty($routing)) {
//                 //los campos test_done y routing no seran verficado
//                 continue;
//             }

//             $color = ($status === "ok") ? "green" : (($status === "fora") ? "red" : "black");

//             echo "<tr>";
//             echo "<td>" . htmlspecialchars($estado) . "</td>";
//             echo "<td>" . htmlspecialchars($operadora) . "</td>";
//             echo "<td>" . htmlspecialchars($mme) . "</td>";
//             echo "<td style='color:$color; font-weight:bold;'>" . htmlspecialchars($status) . "</td>";
//             echo "<td>" . htmlspecialchars($test_done) . "</td>";
//             echo "<td>" . htmlspecialchars($routing) . "</td>";
//             echo "</tr>";
//         }

//         echo "</tbody>";
//         echo "</table>";
//     }

//     private function show5GTable()
//     {
//         echo "<table class='table table-striped'>";
//         echo "<caption>Tecnologia 5G</caption>";
//         echo "<thead>";
//         echo "<tr>";
//         echo "<th>Estado/Região</th>";
//         echo "<th>Operadora (5G)</th>";
//         echo "<th>AMF</th>";
//         echo "<th>Status</th>";
//         echo "<th>Teste</th>";
//         echo "<th>Roteamento</th>";
//         echo "</tr>";
//         echo "</thead>";
//         echo "<tbody>";

//         // Agrupar dados por estado e operadora para tecnologia 5G
//         foreach ($this->xml->cbcAlerta as $alerta) {
//             if (isset($alerta->tecnologia)) {
//                 $estado = (string) $alerta->estado;
//                 $operadora = (string) $alerta->cbcAlerta_operadora;
//                 $tipo = (string) $alerta->tecnologia->tipo;
//                 $amf = (string) $alerta->tecnologia->amf;
//                 $status_tecnologia = (string) $alerta->tecnologia->status;
//                 $test_done_tecnologia = (string) $alerta->tecnologia->test_done;
//                 $routing_tecnologia = (string) $alerta->tecnologia->routing;

//                 // Verifique se há dados em todas as áreas da tecnologia
//                 if (empty($status_tecnologia) && empty($test_done_tecnologia) && empty($routing_tecnologia)) {
//                     continue;
//                 }

//                 $color_tecnologia = ($status_tecnologia === "ok") ? "green" : (($status_tecnologia === "fora") ? "red" : "black");

//                 echo "<tr>";
//                 echo "<td>" . htmlspecialchars($estado) . "</td>";
//                 echo "<td>" . htmlspecialchars($operadora) . " ($tipo)</td>";
//                 echo "<td>" . htmlspecialchars($amf) . "</td>";
//                 echo "<td style='color:$color_tecnologia; font-weight:bold;'>" . htmlspecialchars($status_tecnologia) . "</td>";
//                 echo "<td>" . htmlspecialchars($test_done_tecnologia) . "</td>";
//                 echo "<td>" . htmlspecialchars($routing_tecnologia) . "</td>";
//                 echo "</tr>";
//             }
//         }

//         echo "</tbody>";
//         echo "</table>";
//     }
// }
//======================================================== copai 1===============================================================







// class Cbc
// {
//     private $file;
//     private $xml;
//     private $file_date;

//     public function __construct($file)
//     {
//         if (!file_exists($file)) {
//             throw new Exception();
//         }

//         $this->file = $file;
//         $this->get_data();
//     }

//     private function get_data()
//     {
//         // echo "<script>console.log('Carregando dados XML do arquivo: {$this->file}');</script>";

//         // Lê a data de modificação do arquivo
//         $this->file_date = date("d/m/Y H:i:s", filemtime($this->file));

//         // Lẽ o conteudo do arquivo XML
//         $xmlstr = file_get_contents($this->file);

//         if ($xmlstr === false) {
//             throw new Exception("Erro: não foi possível ler o arquivo XML");
//         }

//         // Intentar carregar o XML
//         libxml_use_internal_errors(true); // Habilitar errores libxml
//         $this->xml = simplexml_load_string($xmlstr);

//         if ($this->xml === false) {
//             $errors = libxml_get_errors();
//             throw new Exception("Erro: conteúdo XML inválido. Detalhes: " . implode(", ", $errors));
//         }

//         echo "<script>console.log('Dados XML carregados com sucesso');</script>";
//     }

//     public function ShowMe()
//     {
//         date_default_timezone_set("America/Sao_Paulo");
//         $hora = date('G');
//         $dark = ($hora > 19 || $hora < 6) ? "dark" : "";

//         echo "<script>console.log('Mostrando dados XML');</script>";
//         echo "<div class='$dark' style='width:80%; margin: 20px auto;'>";
//         echo "<header class='card-header'>";
//         echo "<b>CBC</b><br>";
//         echo "<span>Última atualização: " . htmlspecialchars($this->file_date) . "</span>";
//         echo "</header>";
//         echo "<div class='card-content'>";

//         // Mostrar dados de MME
//         $this->showMMETable();

//         // Mostrar dados de tecnología 5G
//         $this->show5GTable();

//         echo "</div>";
//         echo "</div>";
//     }

//     private function showMMETable()
//     {
//         echo "<table class='table table-striped' style='margin-bottom: 20px;'>";
//         echo "<caption>MME</caption>";
//         echo "<thead>";
//         echo "<tr>";
//         echo "<th>Estado/Região</th>";
//         echo "<th>Operadora</th>";
//         echo "<th>MME</th>";
//         echo "<th>Status</th>";
//         echo "<th>Teste</th>";
//         echo "<th>Roteamento</th>";
//         echo "</tr>";
//         echo "</thead>";
//         echo "<tbody>";

//         //Agrupar dados por estado e operadora para MME

//         foreach ($this->xml->cbcAlerta as $alerta) {
//             $estado = (string) $alerta->estado;
//             $operadora = (string) $alerta->cbcAlerta_operadora;

//             $mme = isset($alerta->mme) ? (string) $alerta->mme : '';
//             $status = in_array((string) $alerta->status, ['ok', 'fora']) ? (string) $alerta->status : '';
//             $test_done = (string) $alerta->test_done;
//             $routing = in_array((string) $alerta->routing, ['sim', 'não']) ? (string) $alerta->routing : '';

//             // Verifique se há dados em todos os campos
//             if (empty($mme) && empty($status) && empty($test_done) && empty($routing)) {
//                 continue;
//             }

//             $color = ($status === "ok") ? "green" : (($status === "fora") ? "red" : "black");

//             echo "<tr>";
//             echo "<td>" . htmlspecialchars($estado) . "</td>";
//             echo "<td>" . htmlspecialchars($operadora) . "</td>";
//             echo "<td>" . htmlspecialchars($mme) . "</td>";
//             echo "<td style='color:$color; font-weight:bold;'>";
//             if ($status === "fora") {
//                 echo "<select>
//                         <option value='ok'" . ($status === "ok" ? " selected" : "") . ">ok</option>
//                         <option value='fora'" . ($status === "fora" ? " selected" : "") . ">fora</option>
//                       </select>";
//             } else {
//                 echo htmlspecialchars($status);
//             }
//             echo "</td>";
//             if ($status === "fora") {
//                 echo "<td><input type='text' value='" . htmlspecialchars($test_done) . "' /></td>";
//                 echo "<td><select>
//                         <option value='sim'" . ($routing === "sim" ? " selected" : "") . ">sim</option>
//                         <option value='não'" . ($routing === "não" ? " selected" : "") . ">não</option>
//                       </select></td>";
//             } else {
//                 echo "<td>" . htmlspecialchars($test_done) . "</td>";
//                 echo "<td>" . htmlspecialchars($routing) . "</td>";
//             }
//             echo "</tr>";
//         }

//         echo "</tbody>";
//         echo "</table>";
//     }

//     private function show5GTable()
//     {
//         echo "<table class='table table-striped'>";
//         echo "<caption>Tecnología 5G</caption>";
//         echo "<thead>";
//         echo "<tr>";
//         echo "<th>Estado/Região</th>";
//         echo "<th>Operadora (Tecnologia 5G)</th>";
//         echo "<th>AMF</th>";
//         echo "<th>Status</th>";
//         echo "<th>Teste</th>";
//         echo "<th>Roteamento</th>";
//         echo "</tr>";
//         echo "</thead>";
//         echo "<tbody>";

//         // Agrupar dados por estado e operadora para tecnologia 5G

//         foreach ($this->xml->cbcAlerta as $alerta) {
//             if (isset($alerta->tecnologia)) {
//                 $estado = (string) $alerta->estado;
//                 $operadora = (string) $alerta->cbcAlerta_operadora;
//                 $tipo = (string) $alerta->tecnologia->tipo;
//                 $amf = isset($alerta->tecnologia->amf) ? (string) $alerta->tecnologia->amf : '';
//                 $status_tecnologia = in_array((string) $alerta->tecnologia->status, ['ok', 'fora']) ? (string) $alerta->tecnologia->status : '';
//                 $test_done_tecnologia = (string) $alerta->tecnologia->test_done;
//                 $routing_tecnologia = in_array((string) $alerta->tecnologia->routing, ['sim', 'não']) ? (string) $alerta->tecnologia->routing : '';

//                 // Verifique se há dados em todas as áreas da tecnologia

//                 if (empty($status_tecnologia) && empty($test_done_tecnologia) && empty($routing_tecnologia)) {
//                     continue;
//                 }

//                 $color_tecnologia = ($status_tecnologia === "ok") ? "green" : (($status_tecnologia === "fora") ? "red" : "black");

//                 echo "<tr>";
//                 echo "<td>" . htmlspecialchars($estado) . "</td>";
//                 echo "<td>" . htmlspecialchars($operadora) . " ($tipo)</td>";
//                 echo "<td>" . htmlspecialchars($amf) . "</td>";
//                 echo "<td style='color:$color_tecnologia; font-weight:bold;'>";
//                 if ($status_tecnologia === "fora") {
//                     echo "<select>
//                             <option value='ok'" . ($status_tecnologia === "ok" ? " selected" : "") . ">ok</option>
//                             <option value='fora'" . ($status_tecnologia === "fora" ? " selected" : "") . ">fora</option>
//                           </select>";
//                 } else {
//                     echo htmlspecialchars($status_tecnologia);
//                 }
//                 echo "</td>";

//                 if ($status_tecnologia === "fora") {
//                     echo "<td><input type='text' value='" . htmlspecialchars($test_done_tecnologia) . "' /></td>";
//                     echo "<td><select>
//                             <option value='sim'" . ($routing_tecnologia === "sim" ? " selected" : "") . ">sim</option>
//                             <option value='não'" . ($routing_tecnologia === "não" ? " selected" : "") . ">não</option>
//                           </select></td>";
//                 } else {
//                     echo "<td>" . htmlspecialchars($test_done_tecnologia) . "</td>";
//                     echo "<td>" . htmlspecialchars($routing_tecnologia) . "</td>";
//                 }
//                 echo "</tr>";
//             }
//         }

//         echo "</tbody>";
//         echo "</table>";
//     }
// }


//==========================================copia 2 envios de datos============================


// class Cbc
// {
//     private $file;
//     private $xml;
//     private $file_date;

//     public function __construct($file)
//     {
//         if (!file_exists($file)) {
//             throw new Exception();
//         }

//         $this->file = $file;
//         $this->get_data();
//     }

//     private function get_data()
//     {
//         echo "<script>console.log('Intentando ler o arquivo: {$this->file}');</script>";
//         if (!file_exists($this->file)) {
//             throw new Exception("Erro: O arquivo {$this->file} não existe");
//         }
//         $this->file_date = date("d/m/Y H:i:s", filemtime($this->file));
//         $xmlstr = file_get_contents($this->file);

//         if ($xmlstr === false) {
//             throw new Exception("Erro: não foi possível ler o arquivo XML");
//         }

//         libxml_use_internal_errors(true);
//         $this->xml = simplexml_load_string($xmlstr);

//         if ($this->xml === false) {
//             $errors = libxml_get_errors();
//             throw new Exception("Erro: conteúdo XML inválido. Detalhes: " . implode(", ", $errors));
//         }

//         echo "<script>console.log('Dados XML carregados com sucesso');</script>";
//     }


//     private function sendData($data)
//     {
//         $url = $_SERVER['DOCUMENT_ROOT'] . '/erpme/banco/conection.php';
//         $options = [
//             'http' => [
//                 'header' => "Content-Type: application/json\r\n",
//                 'method' => 'POST',
//                 'content' => json_encode($data),
//             ],
//         ];
//         $context = stream_context_create($options);
//         $result = file_get_contents($url, false, $context);

//         if ($result === FALSE) {
//             echo "<script>console.error('Erro ao enviar dados para conection.php');</script>";
//         } else {
//             echo "<script>console.log('Dados enviados para conection.php com sucesso');</script>";
//         }
//     }


//     public function ShowMe()
//     {
//         date_default_timezone_set("America/Sao_Paulo");
//         $hora = date('G');
//         $dark = ($hora > 19 || $hora < 6) ? "dark" : "";

//         echo "<script>console.log('Mostrando dados XML');</script>";
//         echo "<div class='$dark' style='width:80%; margin: 20px auto;'>";
//         echo "<header class='card-header'>";
//         echo "<b>CBC</b><br>";
//         echo "<span>Última atualização: " . htmlspecialchars($this->file_date) . "</span>";
//         echo "</header>";
//         echo "<div class='card-content'>";

//         $this->showMMETable();
//         $this->show5GTable();

//         echo "
//         <script>
//         document.getElementById('sendDataButton').addEventListener('click', function() {
//             let data = gatherData();
//             sendDataToServer(data);
//         });

//         function gatherData() {
//             let table = document.querySelector('.table.table-striped tbody');
//             let rows = table.getElementsByTagName('tr');
//             let data = [];

//             for (let i = 0; i < rows.length; i++) {
//                 let cells = rows[i].getElementsByTagName('td');
//                 let rowData = {
//                     estado: cells[0].innerText,
//                     operadora: cells[1].innerText.split(' (')[0],
//                     mme: cells[2].innerText || '',
//                     amf: cells[3] ? cells[3].innerText : '',
//                     status: cells[4].querySelector('select') ? cells[4].querySelector('select').value : cells[4].innerText,
//                     teste: cells[5].querySelector('input') ? cells[5].querySelector('input').value : cells[5].innerText,
//                     roteamento: cells[6].querySelector('select') ? cells[6].querySelector('select').value : cells[6].innerText
//                 };
//                 data.push(rowData);
//             }
//             return data;
//         }

//         function sendDataToServer(data) {
//             let xhr = new XMLHttpRequest();
//             xhr.open('POST', '/erpme/banco/conection.php', true);
//             xhr.setRequestHeader('Content-Type', 'application/json');
//             xhr.onreadystatechange = function () {
//                 if (xhr.readyState == 4 && xhr.status == 200) {
//                     alert('Dados enviados com sucesso!');
//                     window.location.reload();
//                 }
//             };
//             xhr.send(JSON.stringify(data));
//         }
//         </script>
//         ";

//         echo "<button id='sendDataButton'>Enviar Informação</button>";



//         echo "</div>";
//         echo "</div>";
//     }


//     private function showMMETable()
//     {
//         echo "<table class='table table-striped' style='margin-bottom: 20px;'>";
//         echo "<caption>MME</caption>";
//         echo "<thead>";
//         echo "<tr>";
//         echo "<th>Estado/Região</th>";
//         echo "<th>Operadora</th>";
//         echo "<th>MME</th>";
//         echo "<th>Status</th>";
//         echo "<th>Teste</th>";
//         echo "<th>Roteamento</th>";
//         echo "</tr>";
//         echo "</thead>";
//         echo "<tbody>";

//         foreach ($this->xml->cbcAlerta as $alerta) {
//             $estado = (string) $alerta->estado;
//             $operadora = (string) $alerta->cbcAlerta_operadora;
//             $mme = isset($alerta->mme) ? (string) $alerta->mme : '';
//             $status = in_array((string) $alerta->status, ['ok', 'fora']) ? (string) $alerta->status : '';
//             $test_done = (string) $alerta->test_done;
//             $routing = in_array((string) $alerta->routing, ['sim', 'não']) ? (string) $alerta->routing : '';

//             if (empty($mme) && empty($status) && empty($test_done) && empty($routing)) {
//                 continue;
//             }

//             $color = ($status === "ok") ? "green" : (($status === "fora") ? "red" : "black");

//             echo "<tr>";
//             echo "<td>" . htmlspecialchars($estado) . "</td>";
//             echo "<td>" . htmlspecialchars($operadora) . "</td>";
//             echo "<td>" . htmlspecialchars($mme) . "</td>";
//             echo "<td style='color:$color; font-weight:bold;'>";
//             if ($status === "fora") {
//                 echo "<select>
//                         <option value='ok'" . ($status === "ok" ? " selected" : "") . ">ok</option>
//                         <option value='fora'" . ($status === "fora" ? " selected" : "") . ">fora</option>
//                       </select>";
//             } else {
//                 echo htmlspecialchars($status);
//             }
//             echo "</td>";
//             if ($status === "fora") {
//                 echo "<td><input type='text' value='" . htmlspecialchars($test_done) . "' /></td>";
//                 echo "<td><select>
//                         <option value='sim'" . ($routing === "sim" ? " selected" : "") . ">sim</option>
//                         <option value='não'" . ($routing === "não" ? " selected" : "") . ">não</option>
//                       </select></td>";
//             } else {
//                 echo "<td>" . htmlspecialchars($test_done) . "</td>";
//                 echo "<td>" . htmlspecialchars($routing) . "</td>";
//             }
//             echo "</tr>";

//             // Enviar datos a conection.php
//             $data = [
//                 'estado' => $estado,
//                 'operadora' => $operadora,
//                 'mme' => $mme,
//                 'amf' => '',
//                 'status' => $status,
//                 'teste' => $test_done,
//                 'roteamento' => $routing,
//             ];
//             $this->sendData($data);
//         }

//         echo "</tbody>";
//         echo "</table>";
//     }

//     private function show5GTable()
//     {
//         echo "<table class='table table-striped'>";
//         echo "<caption>Tecnología 5G</caption>";
//         echo "<thead>";
//         echo "<tr>";
//         echo "<th>Estado/Região</th>";
//         echo "<th>Operadora (Tecnologia 5G)</th>";
//         echo "<th>AMF</th>";
//         echo "<th>Status</th>";
//         echo "<th>Teste</th>";
//         echo "<th>Roteamento</th>";
//         echo "</tr>";
//         echo "</thead>";
//         echo "<tbody>";

//         foreach ($this->xml->cbcAlerta as $alerta) {
//             if (isset($alerta->tecnologia)) {
//                 $estado = (string) $alerta->estado;
//                 $operadora = (string) $alerta->cbcAlerta_operadora;
//                 $tipo = (string) $alerta->tecnologia->tipo;
//                 $amf = isset($alerta->tecnologia->amf) ? (string) $alerta->tecnologia->amf : '';
//                 $status_tecnologia = in_array((string) $alerta->tecnologia->status, ['ok', 'fora']) ? (string) $alerta->tecnologia->status : '';
//                 $test_done_tecnologia = (string) $alerta->tecnologia->test_done;
//                 $routing_tecnologia = in_array((string) $alerta->tecnologia->routing, ['sim', 'não']) ? (string) $alerta->tecnologia->routing : '';

//                 if (empty($status_tecnologia) && empty($test_done_tecnologia) && empty($routing_tecnologia)) {
//                     continue;
//                 }

//                 $color_tecnologia = ($status_tecnologia === "ok") ? "green" : (($status_tecnologia === "fora") ? "red" : "black");

//                 echo "<tr>";
//                 echo "<td>" . htmlspecialchars($estado) . "</td>";
//                 echo "<td>" . htmlspecialchars($operadora) . " ($tipo)</td>";
//                 echo "<td>" . htmlspecialchars($amf) . "</td>";
//                 echo "<td style='color:$color_tecnologia; font-weight:bold;'>";
//                 if ($status_tecnologia === "fora") {
//                     echo "<select>
//                             <option value='ok'" . ($status_tecnologia === "ok" ? " selected" : "") . ">ok</option>
//                             <option value='fora'" . ($status_tecnologia === "fora" ? " selected" : "") . ">fora</option>
//                           </select>";
//                 } else {
//                     echo htmlspecialchars($status_tecnologia);
//                 }
//                 echo "</td>";

//                 if ($status_tecnologia === "fora") {
//                     echo "<td><input type='text' value='" . htmlspecialchars($test_done_tecnologia) . "' /></td>";
//                     echo "<td><select>
//                             <option value='sim'" . ($routing_tecnologia === "sim" ? " selected" : "") . ">sim</option>
//                             <option value='não'" . ($routing_tecnologia === "não" ? " selected" : "") . ">não</option>
//                           </select></td>";
//                 } else {
//                     echo "<td>" . htmlspecialchars($test_done_tecnologia) . "</td>";
//                     echo "<td>" . htmlspecialchars($routing_tecnologia) . "</td>";
//                 }
//                 echo "</tr>";

//                 // Enviar datos a conection.php
//                 $data = [
//                     'estado' => $estado,
//                     'operadora' => $operadora,
//                     'mme' => '',
//                     'amf' => $amf,
//                     'status' => $status_tecnologia,
//                     'teste' => $test_done_tecnologia,
//                     'roteamento' => $routing_tecnologia,
//                 ];
//                 $this->sendData($data);
//             }
//         }

//         echo "</tbody>";
//         echo "</table>";
//     }
// }

//============================================ copia 3=======================================


class Cbc
{
    private $file;
    private $xml;
    private $file_date;

    public function __construct($file)
    {
        if (!file_exists($file)) {
            throw new Exception("Arquivo não encontrado: $file");
        }

        $this->file = $file;
        $this->get_data();
    }

    private function get_data()
    {
        echo "<script>console.log('Intentando ler o arquivo: {$this->file}');</script>";

        $this->file_date = date("d/m/Y H:i:s", filemtime($this->file));
        $xmlstr = file_get_contents($this->file);

        if ($xmlstr === false) {
            throw new Exception("Erro: não foi possível ler o arquivo XML");
        }

        libxml_use_internal_errors(true);
        $this->xml = simplexml_load_string($xmlstr);

        if ($this->xml === false) {
            $errors = libxml_get_errors();
            throw new Exception("Erro: conteúdo XML inválido. Detalhes: " . implode(", ", $errors));
        }

        echo "<script>console.log('Dados XML carregados com sucesso');</script>";
    }

    private function sendData($data)
    {
        $url = $_SERVER['DOCUMENT_ROOT'] . '/erpme/banco/conection.php';
        $options = [
            'http' => [
                'header' => "Content-Type: application/json\r\n",
                'method' => 'POST',
                'content' => json_encode($data),
            ],
        ];
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        if ($result === FALSE) {
            echo "<script>console.error('Erro ao enviar dados para conection.php');</script>";
        } else {
            echo "<script>console.log('Dados enviados para conection.php com sucesso');</script>";
        }
    }

    public function showMe()
    {
        date_default_timezone_set("America/Sao_Paulo");
        $hora = date('G');
        $dark = ($hora > 19 || $hora < 6) ? "dark" : "";

        echo "<script>console.log('Mostrando dados XML');</script>";
        echo "<div class='$dark' style='width:80%; margin: 20px auto;'>";
        echo "<header class='card-header'>";
        echo "<b>CBC</b><br>";
        echo "<span>Última atualização: " . htmlspecialchars($this->file_date) . "</span>";
        echo "</header>";
        echo "<div class='card-content'>";

        $this->showMMETable();
        $this->show5GTable();

        echo "<button id='sendDataButton'>Enviar Informação</button>";
        echo "</div>";
        echo "</div>";
    }

    private function showMMETable()
    {
        $this->renderTable('MME', $this->extractMMEData());
    }

    private function show5GTable()
    {
        $this->renderTable('Tecnología 5G', $this->extract5GData());
    }

    private function renderTable($title, $data)
    {
        echo "<table class='table table-striped' style='margin-bottom: 20px;'>";
        echo "<caption>$title</caption>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Estado/Região</th>";
        echo "<th>Operadora</th>";
        echo "<th>MME</th>";
        echo "<th>Status</th>";
        echo "<th>Teste</th>";
        echo "<th>Roteamento</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        foreach ($data as $row) {
            echo "<tr>";
            foreach ($row as $cell) {
                echo "<td>" . htmlspecialchars($cell) . "</td>";
            }
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
    }

    private function extractMMEData()
    {
        $data = [];
        foreach ($this->xml->cbcAlerta as $alerta) {
            $estado = (string) $alerta->estado;
            $operadora = (string) $alerta->cbcAlerta_operadora;
            $mme = isset($alerta->mme) ? (string) $alerta->mme : '';
            $status = in_array((string) $alerta->status, ['ok', 'fora']) ? (string) $alerta->status : '';
            $test_done = (string) $alerta->test_done;
            $routing = in_array((string) $alerta->routing, ['sim', 'não']) ? (string) $alerta->routing : '';

            if (empty($mme) && empty($status) && empty($test_done) && empty($routing)) {
                continue;
            }

            $data[] = [
                'estado' => $estado,
                'operadora' => $operadora,
                'mme' => $mme,
                'status' => $status,
                'test_done' => $test_done,
                'routing' => $routing,
            ];
        }
        return $data;
    }

    private function extract5GData()
    {
        $data = [];
        foreach ($this->xml->cbcAlerta as $alerta) {
            if (isset($alerta->tecnologia)) {
                $estado = (string) $alerta->estado;
                $operadora = (string) $alerta->cbcAlerta_operadora;
                $tipo = (string) $alerta->tecnologia->tipo;
                $amf = isset($alerta->tecnologia->amf) ? (string) $alerta->tecnologia->amf : '';
                $status_tecnologia = in_array((string) $alerta->tecnologia->status, ['ok', 'fora']) ? (string) $alerta->tecnologia->status : '';
                $test_done_tecnologia = (string) $alerta->tecnologia->test_done;
                $routing_tecnologia = in_array((string) $alerta->tecnologia->routing, ['sim', 'não']) ? (string) $alerta->tecnologia->routing : '';

                if (empty($status_tecnologia) && empty($test_done_tecnologia) && empty($routing_tecnologia)) {
                    continue;
                }

                $data[] = [
                    'estado' => $estado,
                    'operadora' => $operadora,
                    'tipo' => $tipo,
                    'amf' => $amf,
                    'status_tecnologia' => $status_tecnologia,
                    'test_done_tecnologia' => $test_done_tecnologia,
                    'routing_tecnologia' => $routing_tecnologia,
                ];
            }
        }
        return $data;
    }
}

