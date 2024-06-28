<?php

// Recuperar el ID de la URL de manera segura
$id_xml = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
$id_xml = (int) $id_xml;
if ($id_xml <= 0) {
    header('Location: index.php');
    exit;
}

if ($id_xml === null) {

    exit("ID da alerta não fornecido ou inválido.");
}

// Obtener datos de la alerta para edición usando el ID
$alerta = getAlertaById($id_xml);

if ($alerta === null) {
    exit("Alerta não encontrada.");
}

// Atribuir los datos de la alerta a las variables
$estado = htmlspecialchars($alerta['estado']);
$operadora = htmlspecialchars($alerta['operadora']);
$mme = isset($alerta['mme']) ? htmlspecialchars($alerta['mme']) : '';
$amf = isset($alerta['amf']) ? htmlspecialchars($alerta['amf']) : '';

function getAlertaById($id_xml)
{
    // Cargar el archivo XML de manera segura
    $file = $_SERVER['DOCUMENT_ROOT'] . "/CbcAlerta/cbcRelatorio.xml";
    if (!file_exists($file)) {
        return null;
    }

    // Intentar cargar el XML
    $xml = simplexml_load_file($file);
    if ($xml === false) {
        return null;
    }

    // Buscar la alerta con el ID correspondiente
    foreach ($xml->cbcAlerta as $alerta) {
        if ((string) $alerta['id'] === $id_xml) {
            return [
                'estado' => (string) $alerta->estado,
                'operadora' => (string) $alerta->cbcAlerta_operadora,
                'mme' => isset($alerta->mme) ? (string) $alerta->mme : null,
                'amf' => isset($alerta->tecnologia->amf) ? (string) $alerta->tecnologia->amf : null
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
    <form id="cbcForm" method="post" action="conection.php">
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

        <button type="submit">Enviar</button>
        <button type="button" id="cancelButton">Cancelar</button>
    </form>
    <script>
        let form = document.getElementById("cbcForm");

        form.addEventListener("submit", async (event) => {
            event.preventDefault(); // Impedir que a página seja recarregada ao enviar o formulário

            //Coletar dados do formulário
            const formData = new FormData(form);

            // Converte FormData em um objeto para que possa ser convertido em JSON
            const formObject = {};
            formData.forEach((value, key) => {
                formObject[key] = value;
            });
            console.log("Datos a enviar:", formObject); //Depuração: verifique os dados antes de enviar

            // Enviando dados conection.php usando fetch
            try {
                const response = await fetch('/CbcAlerta/conection.php', {
                    method: 'POST',
                    mode: 'cors',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(formObject) // Aqui garantimos que ele seja enviado como um array

                });

                const contentType = response.headers.get('content-type');

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                if (!contentType || !contentType.includes('application/json')) {
                    throw new Error('Esperava uma resposta JSON, mas recebeu outra coisa.');
                }

                const data = await response.json();

                if (data.success) {
                    await Swal.fire({
                        icon: 'success',
                        title: 'Dados enviados corretamente',
                        showConfirmButton: true,
                        confirmButtonText: 'Fechar'
                    });
                } else {
                    await Swal.fire({
                        icon: 'error',
                        title: 'Erro ao enviar dados',
                        text: data.message,
                    });
                }
            } catch (error) {
                console.error('Erro ao enviar dados:', error);
                await Swal.fire({
                    icon: 'error',
                    title: 'Erro ao enviar dados',
                    text: error.message,
                });
            }
        });

        let cancelButton = document.getElementById("cancelButton");
        cancelButton.addEventListener("click", () => {
            window.location.href = '../index.php';
        });


        // Função para desativar botões de navegação
        // function disableNavigationButtons() {
        //     history.pushState(null, null, location.href);
        //     window.addEventListener('popstate', function () {
        //         history.pushState(null, null, location.href);
        //     });

        //     window.addEventListener("beforeunload", function (event) {
        //         event.preventDefault();
        //     });
        // }

        // disableNavigationButtons();
    </script>
</body>

</html>