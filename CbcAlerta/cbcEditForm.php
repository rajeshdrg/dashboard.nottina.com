<?php

$id = isset($_GET['id']) ? $_GET['id'] : null;


if ($id === null) {
    echo "ID de alerta no proporcionado.";
    exit;
}

// Ejemplo de recuperación de datos para edición usando el ID (simulado, reemplaza con tus datos reales)
// Supongamos que tienes una función que recupera los datos de la alerta por su ID
$alerta = getAlertaById($id);

// Asegurarse de que se encontraron los datos de la alerta
if ($alerta === null) {
    echo "Alerta no encontrada.";
    exit;
}

// Asignar los datos de la alerta a variables
$estado = $alerta['estado'];
$operadora = $alerta['operadora'];
$mme = isset($alerta['mme']) ? $alerta['mme'] : '';
$amf = isset($alerta['amf']) ? $alerta['amf'] : null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Procesar los datos enviados por el formulario
    $estado = $_POST['estado'];
    $operadora = $_POST['operadora'];
    $mme = $_POST['mme'];
    $amf = isset($_POST['amf']) ? $_POST['amf'] : null;
    $status = $_POST['status'];
    $teste = $_POST['test'];
    $roteamento = $_POST['roteamento'];

    // Aquí puedes realizar validaciones adicionales antes de enviar los datos a la base de datos
    // Por ejemplo, asegurarte de que los campos obligatorios no estén vacíos, etc.

    // Preparar los datos para enviar a connection.php
    $data = [
        'id' => $id,
        'estado' => $estado,
        'operadora' => $operadora,
        'mme' => $mme,
        'amf' => $amf,
        'status' => $status,
        'teste' => $teste,
        'roteamento' => $roteamento
    ];

    // Enviar datos a connection.php usando JSON
    $jsonData = json_encode([$data]);

    // Puedes ajustar la URL según la ubicación de tu archivo connection.php
    $url = $_SERVER['DOCUMENT_ROOT'] . "/CbcAlerta/conection.php";

    // Configurar la solicitud HTTP POST
    $options = [
        'http' => [
            'header' => "Content-Type: application/json\r\n",
            'method' => 'POST',
            'content' => $jsonData
        ]
    ];

    // Realizar solicitud HTTP
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result === false) {

        echo "Error al enviar datos a connection.php";
    } else {
        // Procesar la respuesta del servidor (si se desea)
        $response = json_decode($result, true);
        if ($response['success']) {
            echo "Datos enviados correctamente";
        } else {
            echo "Error al enviar datos: " . $response['message'];
        }
    }

    // Opcionalmente, puedes redirigir o mostrar un mensaje de éxito al usuario
    exit;
}

// Función simulada para obtener datos de la alerta por ID (reemplazar con la lógica real)
function getAlertaById($id)
{
    // Simulación de datos
    $alertas = [
        "1" => [
            'estado' => "Estado Ejemplo",
            'operadora' => "Operadora Ejemplo",
            'mme' => "MME Ejemplo",
            'amf' => "AMF Ejemplo"
        ],
        // Agregar más alertas según sea necesario
    ];

    return isset($alertas[$id]) ? $alertas[$id] : null;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBC Relatorio</title>
    <link rel="stylesheet" href="styles.css">
    <script src=""></script>
</head>

<body>
    <h1>Editar CBC Relatorio </h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . urlencode($id); ?>" method="POST">
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