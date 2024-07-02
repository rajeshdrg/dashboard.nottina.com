<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta CBC Relatório</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        form {
            margin-bottom: 20px;
        }

        form label {
            margin-right: 10px;
        }

        form input,
        form select {
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <h1>Consulta CBC Relatório</h1>

    <form id="filterForm">
        <label for="estado">Estado:</label>
        <input type="text" id="estado" name="estado">

        <label for="operadora">Operadora:</label>
        <input type="text" id="operadora" name="operadora">

        <label for="tecnologia">Tecnologia:</label>
        <input type="text" id="tecnologia" name="tecnologia">

        <label for="data_inicio">Data Início:</label>
        <input type="date" id="data_inicio" name="data_inicio">

        <label for="data_fim">Data Fim:</label>
        <input type="date" id="data_fim" name="data_fim">

        <button type="button" onclick="fetchData()">Buscar</button>
    </form>

    <button type="button" onclick="window.location.href='/CbcAlerta/CbcAlerta.php'">Voltar</button>



    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Estado</th>
                <th>Operadora</th>
                <th>MME/AMF</th>
                <th>Tecnologia</th>
                <th>Status</th>
                <th>Teste</th>
                <th>Roteamento</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody id="results">

        </tbody>
    </table>

    <script>
        function fetchData() {
            const estado = document.getElementById('estado').value;
            const operadora = document.getElementById('operadora').value;
            const tecnologia = document.getElementById('tecnologia').value;
            const data_inicio = document.getElementById('data_inicio').value;
            const data_fim = document.getElementById('data_fim').value;

            const url = new URL('/CbcAlerta/searchCbc.php', window.location.origin);
            const params = { estado, operadora, tecnologia, data_inicio, data_fim };

            Object.keys(params).forEach(key => {
                if (params[key]) {
                    url.searchParams.append(key, params[key]);
                }
            });

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const results = data.results;
                        const tableBody = document.getElementById('results');
                        tableBody.innerHTML = '';

                        results.forEach(result => {
                            const row = document.createElement('tr');

                            row.innerHTML = `
                                <td>${result.id_xml}</td>
                                <td>${result.estado}</td>
                                <td>${result.operadora}</td>
                                <td>${result.mme_amf}</td>
                                <td>${result.tecnologia}</td>
                                <td>${result.status}</td>
                                <td>${result.teste}</td>
                                <td>${result.roteamento}</td>
                                <td>${result.created_at}</td>
                            `;

                            tableBody.appendChild(row);
                        });
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // Fetch initial data on page load
        fetchData();
    </script>
</body>

</html>