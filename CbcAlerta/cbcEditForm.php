<?php
// Recuperar o ID da URL
$id_xml = isset($_GET['id']) ? $_GET['id'] : null;

// Verificar se foi fornecido um ID
if ($id_xml === null) {
    echo "ID da alerta não fornecido.";
    exit;
}

// Recuperar dados da alerta para edição usando o ID
$alerta = getAlertaById($id_xml);

// Certificar-se de que os dados da alerta foram encontrados
if ($alerta === null) {
    echo "Alerta não encontrada.";
    exit;
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
    $teste = $_POST['teste'];
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
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Alerta</title>
    <!-- Adicione seus estilos CSS aqui, se necessário -->
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>Editar Relatório CBC</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET['id']); ?>">

        <label for="estado">Estado/Região:</label>
        <input type="text" id="estado" name="estado" value="<?php echo htmlspecialchars($estado); ?>"><br><br>

        <label for="operadora">Operadora:</label>
        <input type="text" id="operadora" name="operadora" value="<?php echo htmlspecialchars($operadora); ?>"><br><br>

        <label for="mme">MME:</label>
        <input type="text" id="mme" name="mme" value="<?php echo htmlspecialchars($mme); ?>"><br><br>

        <?php if (!empty($amf)): ?>
            <label for="amf">AMF:</label>
            <input type="text" id="amf" name="amf" value="<?php echo htmlspecialchars($amf); ?>"><br><br>
        <?php endif; ?>

        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="ok">OK</option>
            <option value="fora">Fora</option>
        </select><br><br>

        <label for="teste">Teste:</label>
        <input type="text" id="teste" name="teste" required><br><br>

        <label for="roteamento">Roteamento:</label>
        <select id="roteamento" name="roteamento">
            <option value="sim">Sim</option>
            <option value="nao">Não</option>
        </select><br><br>

        <input type="submit" value="Guardar Alterações">
    </form>
</body>

</html>