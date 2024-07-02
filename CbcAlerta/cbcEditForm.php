<?php

// Recuperar el ID de la URL de manera segura
$id_xml = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);

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
$tecnologia = $alerta['tecnologia'];
$status = isset($alerta['status']) ? $alerta['status'] : '';
$test = isset($alerta['test']) ? $alerta['test'] : '';
$routing = isset($alerta['routing']) ? $alerta['routing'] : '';

function getAlertaById($id_xml)
{
    // Carregar arquivo XML
    $file = $_SERVER['DOCUMENT_ROOT'] . "/CbcAlerta/cbcRelatorio1.xml";
    $xml = simplexml_load_file($file);

    // Pesquisar o alerta com o ID correspondente em todas as tecnologias
    foreach ($xml->tecnologias->tecnologia as $tecnologia) {
        foreach ($tecnologia->vpns->vpn as $vpn) {
            foreach ($vpn->operadoras->operadora as $operadora) {
                foreach ($operadora->alertas->cbcAlerta as $alerta) {
                    if ((string) $alerta['id'] === $id_xml) {
                        $estado = (string) $vpn->nome;
                        $operadora_nome = (string) $operadora->nome;
                        $mme = isset($alerta->mme_amf) ? (string) $alerta->mme_amf : null;
                        $tecnologia_nome = (string) $tecnologia->nome; // Corrigido para pegar o nome da tecnologia
                        $status = isset($alerta->status) ? (string) $alerta->status : null;
                        $test = isset($alerta->test_done) ? (string) $alerta->test_done : null;
                        $routing = isset($alerta->routing) ? (string) $alerta->routing : null;

                        return [
                            'estado' => $estado,
                            'operadora' => $operadora_nome,
                            'mme' => $mme,
                            'tecnologia' => $tecnologia_nome,
                            'status' => $status,
                            'test' => $test,
                            'routing' => $routing
                        ];
                    }
                }
            }
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
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET['id']); ?>"> <!-- ID do alerta -->
        <label for="estado">Estado/Região:</label>
        <input type="text" id="estado" name="estado" value="<?php echo htmlspecialchars($estado); ?>" readonly><br><br>

        <label for="operadora">Operadora:</label>
        <input type="text" id="operadora" name="operadora" value="<?php echo htmlspecialchars($operadora); ?>"
            readonly><br><br>

        <label for="mme">MME/AMF:</label>
        <input type="text" id="mme" name="mme" value="<?php echo htmlspecialchars($mme); ?>" readonly><br><br>

        <label for="tecnologia">Tecnologia:</label>
        <input type="text" id="tecnologia" name="tecnologia" value="<?php echo htmlspecialchars($tecnologia); ?>"
            readonly><br><br>

        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="OK" <?php echo $status === 'OK' ? 'selected' : ''; ?>>OK</option>
            <option value="Fora" <?php echo $status === 'Fora' ? 'selected' : ''; ?>>Fora</option>
        </select><br><br>

        <label for="test">Teste:</label>
        <input type="text" id="test" name="test" value="<?php echo htmlspecialchars($test); ?>" required><br><br>

        <label for="roteamento">Roteamento:</label>
        <select id="roteamento" name="roteamento">
            <option value="Sim" <?php echo $routing === 'Sim' ? 'selected' : ''; ?>>Sim</option>
            <option value="Não" <?php echo $routing === 'Não' ? 'selected' : ''; ?>>Não</option>
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

            console.log(formObject);

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
                console.log(response);

                const contentType = response.headers.get('content-type');

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                if (!contentType || !contentType.includes('application/json')) {
                    throw new Error('Esperava uma resposta JSON, mas recebeu outra coisa.');
                }

                const data = await response.json();
                console.log(data);

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
                        title: 'Error ao enviar dados',
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
            window.location.href = '/CbcAlerta/CbcAlerta.php';
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