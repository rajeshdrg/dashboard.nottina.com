<?php
//======================================== copia 3 ==============================================
session_start(); // Inicias la sesión si no lo has hecho ya

class Cbc
{
    private $file;
    private $xml;
    private $file_date;

    public function __construct($file)
    {
        if (!file_exists($file)) {
            throw new Exception("Erro: O arquivo {$file} não existe");
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

    function sendData($data)
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

    public function ShowMe()
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

        echo "
        <script>
        function send(){
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('sendDataButton').addEventListener('click', function() {
                let data = gatherData();
                sendDataToServer(data);
            });
    }

            function gatherData() {
                let table = document.querySelector('.table.table-striped tbody');
                let rows = table.getElementsByTagName('tr');
                let data = [];

                for (let i = 0; i < rows.length; i++) {
                    let cells = rows[i].getElementsByTagName('td');
                    let rowData = {
                        estado: cells[0].innerText,
                        operadora: cells[1].innerText.split(' (')[0],
                        mme: cells[2].innerText || '',
                        amf: cells[3] ? cells[3].innerText : '',
                        status: cells[4].querySelector('select') ? cells[4].querySelector('select').value : cells[4].innerText,
                        teste: cells[5].querySelector('input') ? cells[5].querySelector('input').value : cells[5].innerText,
                        roteamento: cells[6].querySelector('select') ? cells[6].querySelector('select').value : cells[6].innerText
                    };
                    data.push(rowData);
                }
                return data;
            }

            function sendDataToServer(data) {
                let url = '/erpme/banco/conection.php';
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data),
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro ao enviar dados para conection.php');
                    }
                    console.log('Dados enviados para conection.php com sucesso');
                })
                .catch(error => {
                    console.error(error);
                });
            }
        });
        </script>
        ";

        echo "<input type='button' onclick='send()' value='Submit form'>";


        echo "</div>";
        echo "</div>";
    }

    private function showMMETable()
    {
        echo "<table class='table table-striped' style='margin-bottom: 20px;'>";
        echo "<caption>MME</caption>";
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

        foreach ($this->xml->cbcAlerta as $alerta) {
            $estado = (string) $alerta->estado;
            $operadora = (string) $alerta->cbcAlerta_operadora;
            $mme = isset($alerta->mme) ? (string) $alerta->mme : '';
            $status = in_array((string) $alerta->status, ['ok', 'fora']) ? (string) $alerta->status : '';
            $test_done = (string) $alerta->test_done;
            $routing = in_array((string) $alerta->routing, ['sim', 'não']) ? (string) $alerta->routing : '';

            if (empty($status) && empty($test_done) && empty($routing)) {
                continue;
            }

            $color = ($status === "ok") ? "green" : (($status === "fora") ? "red" : "black");

            echo "<tr>";
            echo "<td>" . htmlspecialchars($estado) . "</td>";
            echo "<td>" . htmlspecialchars($operadora) . "</td>";
            echo "<td>" . htmlspecialchars($mme) . "</td>";
            echo "<td style='color:$color; font-weight:bold;'>";
            if ($status === "fora") {
                echo "<select>
                        <option value='ok'" . ($status === "ok" ? " selected" : "") . ">ok</option>
                        <option value='fora'" . ($status === "fora" ? " selected" : "") . ">fora</option>
                      </select>";
            } else {
                echo htmlspecialchars($status);
            }
            echo "</td>";
            if ($status === "fora") {
                echo "<td><input type='text' value='" . htmlspecialchars($test_done) . "' /></td>";
                echo "<td><select>
                        <option value='não'" . ($routing === "não" ? " selected" : "") . ">não</option>
                        <option value='sim'" . ($routing === "sim" ? " selected" : "") . ">sim</option>
                      </select></td>";
            } else {
                echo "<td>" . htmlspecialchars($test_done) . "</td>";
                echo "<td>" . htmlspecialchars($routing) . "</td>";
            }
            echo "</tr>";

            // Enviar datos a conection.php
            $data = [
                'estado' => $estado,
                'operadora' => $operadora,
                'mme' => $mme,
                'amf' => '',
                'status' => $status,
                'teste' => $test_done,
                'roteamento' => $routing,
            ];
            $this->sendData($data);
        }

        echo "</tbody>";
        echo "</table>";
    }

    private function show5GTable()
    {
        echo "<table class='table table-striped'>";
        echo "<caption>Tecnología 5G</caption>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Estado/Região</th>";
        echo "<th>Operadora (Tecnologia 5G)</th>";
        echo "<th>AMF</th>";
        echo "<th>Status</th>";
        echo "<th>Teste</th>";
        echo "<th>Roteamento</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

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

                $color_tecnologia = ($status_tecnologia === "ok") ? "green" : (($status_tecnologia === "fora") ? "red" : "black");

                echo "<tr>";
                echo "<td>" . htmlspecialchars($estado) . "</td>";
                echo "<td>" . htmlspecialchars($operadora) . " ($tipo)</td>";
                echo "<td>" . htmlspecialchars($amf) . "</td>";
                echo "<td style='color:$color_tecnologia; font-weight:bold;'>";
                if ($status_tecnologia === "fora") {
                    echo "<select>
                            <option value='ok'" . ($status_tecnologia === "ok" ? " selected" : "") . ">ok</option>
                            <option value='fora'" . ($status_tecnologia === "fora" ? " selected" : "") . ">fora</option>
                          </select>";
                } else {
                    echo htmlspecialchars($status_tecnologia);
                }
                echo "</td>";

                if ($status_tecnologia === "fora") {
                    echo "<td><input type='text' value='" . htmlspecialchars($test_done_tecnologia) . "' /></td>";
                    echo "<td><select>
                            <option value='não'" . ($routing_tecnologia === "não" ? " selected" : "") . ">não</option>
                            <option value='sim'" . ($routing_tecnologia === "sim" ? " selected" : "") . ">sim</option>
                          </select></td>";
                } else {
                    echo "<td>" . htmlspecialchars($test_done_tecnologia) . "</td>";
                    echo "<td>" . htmlspecialchars($routing_tecnologia) . "</td>";
                }
                echo "</tr>";

                // Enviar datos a conection.php
                $data = [
                    'estado' => $estado,
                    'operadora' => $operadora,
                    'mme' => '',
                    'amf' => $amf,
                    'status' => $status_tecnologia,
                    'teste' => $test_done_tecnologia,
                    'roteamento' => $routing_tecnologia,
                ];
                $this->sendData($data);
            }
        }

        echo "</tbody>";
        echo "</table>";
    }
}


?>