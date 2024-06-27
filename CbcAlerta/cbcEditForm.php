<?php
// Recuperar o ID da URL
$id_xml = isset($_GET['id']) ? $_GET['id'] : null;

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
    <form id="cbcForm">
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

    <script>
        let form = document.getElementById("editForm");

        form.addEventListener("submit", async (event) => {
            event.preventDefault(); // Impedir que a página seja recarregada ao enviar o formulário

            //Coletar dados do formulário
            const formData = new FormData(this);

            // Converte FormData em um objeto para que possa ser convertido em JSON
            const formObject = {};
            formData.forEach((value, key) => {
                formObject[key] = value;
            });

            // Enviando dados conection.php usando fetch
            const response = await fetch('/CbcAlerta/conection.php', {
                method: 'POST',
                mode: 'cors',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify([formObject]) // Aqui garantimos que ele seja enviado como um array
            })

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            const data = await response.json();
            console.log(data);
            if (data.success) {
                Swal.fire('Success', 'Dados enviados corretamente', 'success');
            } else {
                Swal.fire('Error', 'Erro ao enviar dados: ' + data.message, 'error');
            }

                .catch (error => {
                console.error('Erro ao enviar dados:', error);
                Swal.fire('Error', 'Erro ao enviar dados: ' + error.message, 'error');
            });

        });

        // Função para desativar botões de navegação
        function disableNavigationButtons() {
            history.pushState(null, null, location.href);
            window.addEventListener('popstate', function () {
                history.pushState(null, null, location.href);
            });

            window.addEventListener("beforeunload", function (event) {
                event.preventDefault();
            });
        }

        disableNavigationButtons();
    </script>
</body>

</html>