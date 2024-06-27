<?php
// Recuperar o ID da URL
$id_xml = isset($_GET['id']) ? $_GET['id'] : null;
echo "ID recibido: " . $id_xml;

// Verificar se foi fornecido um ID
if ($id_xml === null) {
    exit("ID da alerta não fornecido.");
}

// Recuperar dados da alerta para edição usando o ID
$alerta = getAlertaById($id_xml);

// Certificar-se de que os dados da alerta foram encontrados
if ($alerta === null) {
    exit("Alerta não encontrada.");
}

// Atribuir os dados da alerta às variáveis
$estado = $alerta['estado'];
$operadora = $alerta['operadora'];
$mme = isset($alerta['mme']) ? $alerta['mme'] : '';
$amf = isset($alerta['amf']) ? $alerta['amf'] : null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Processar os dados enviados pelo formulário
    $id_xml = $_POST['id'];
    $estado = $_POST['estado'];
    $operadora = $_POST['operadora'];
    $mme = $_POST['mme'];
    $amf = isset($_POST['amf']) ? $_POST['amf'] : null;
    $status = $_POST['status'];
    $teste = $_POST['test']; // Ajustado a 'test' en lugar de 'teste' para coincidir con el nombre del campo en el formulario
    $roteamento = $_POST['roteamento'];

    // Aqui você pode realizar validações adicionais antes de enviar os dados para o banco de dados
    // Por exemplo, garantir que os campos obrigatórios não estejam vazios, etc.

    // Preparar os dados para enviar a connection.php
    $data = [
        'id' => $id_xml,
        'estado' => $estado,
        'operadora' => $operadora,
        'mme' => $mme,
        'amf' => $amf,
        'status' => $status,
        'teste' => $teste,
        'roteamento' => $roteamento
    ];

    // Enviar dados para connection.php usando JSON
    $jsonData = json_encode([$data]);

    // Ajustar a URL conforme a localização do seu arquivo connection.php
    $url = $_SERVER['DOCUMENT_ROOT'] . "/CbcAlerta/conection.php";

    // Configurar a solicitação HTTP POST
    $options = [
        'http' => [
            'header' => "Content-Type: application/json\r\n",
            'method' => 'POST',
            'content' => $jsonData
        ]
    ];

    // Realizar a solicitação HTTP
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result === false) {
        // Lidar com o erro se a solicitação falhar
        echo "Erro ao enviar dados para connection.php";
    } else {
        // Processar a resposta do servidor (se desejado)
        $response = json_decode($result, true);
        if ($response['success']) {
            echo "Dados enviados corretamente";
        } else {
            echo "Erro ao enviar dados: " . $response['message'];
        }
    }

    // Opcionalmente, você pode redirecionar ou mostrar uma mensagem de sucesso ao usuário
    exit;
}

function getAlertaById($id_xml)
{
    // Carregar o arquivo XML
    $file = $_SERVER['DOCUMENT_ROOT'] . "/CbcAlerta/cbcRelatorio.xml";
    $xml = simplexml_load_file($file);

    // Procurar a alerta com o ID correspondente
    foreach ($xml->cbcAlerta as $index => $alerta) {
        if ((string) $alerta['id'] === $id_xml) {
            $estado = (string) $alerta->estado;
            $operadora = (string) $alerta->cbcAlerta_operadora;
            $mme = isset($alerta->mme) ? (string) $alerta->mme : null;
            $amf = isset($alerta->tecnologia->amf) ? (string) $alerta->tecnologia->amf : null;

            return [
                'estado' => $estado,
                'operadora' => $operadora,
                'mme' => $mme,
                'amf' => $amf
            ];
        }
    }

    return null;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Alerta</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/js/sweetalert2.all.js"></script>
</head>

<body>
    <h1>Editar Relatório CBC</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $_GET['id']); ?>" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET['id']); ?>">
        <label for="estado">Estado/Região:</label>
        <input type="text" id="estado" name="estado" value="<?php echo htmlspecialchars($estado); ?>" readonly><br><br>

        <label for="operadora">Operadora:</label>
        <input type="text" id="operadora" name="operadora" value="<?php echo htmlspecialchars($operadora); ?>"
            readonly><br><br>

        <label for="mme">MME:</label>
        <input type="text" id="mme" name="mme" value="<?php echo htmlspecialchars($mme); ?>" readonly><br><br>

        <?php if (!empty($amf)): ?>
            <label for="amf">AMF:</label>
            <input type="text" id="amf" name="amf" value="<?php echo htmlspecialchars($amf); ?>" readonly><br><br>
        <?php endif; ?>

        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="ok">OK</option>
            <option value="fora">Fora</option>
        </select><br><br>

        <label for="test">Teste:</label>
        <input type="text" id="test" name="test" required><br><br>

        <label for="roteamento">Roteamento:</label>
        <select id="roteamento" name="roteamento">
            <option value="sim">Sim</option>
            <option value="nao">Não</option>
        </select><br><br>

        <input type="submit" value="Enviar">
    </form>
</body>

</html>