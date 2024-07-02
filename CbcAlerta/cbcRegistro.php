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
        <select name="estado" id="estado">
            <option value="">Selecione um Estaddo</option>
        </select>


        <label for="operadora">Operadora:</label>
        <select name="operadora" id="operadora">
            <option value="">Selecione uma Operadora</option>
        </select>


        <label for="tecnologia">Tecnologia:</label>
        <select name="tecnologia" id="tecnologia">
            <option value="">Selecione uma Tecnologia</option>
        </select>


        <label for="data_inicio">Data Início:</label>
        <input type="date" id="data_inicio" name="data_inicio">

        <label for="data_fim">Data Fim:</label>
        <input type="date" id="data_fim" name="data_fim">

        <button type="button" onclick="fetchData()">Buscar</button>
    </form>

    <button type="button" onclick="window.location.href='../index.php'">Voltar</button>


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
        const tableBody = document.getElementById('cbc-results');
        const loadingIndicator = document.getElementById('loading-indicator');
        const errorElement = document.getElementById('error-message');

        function fetchData() {
            const estado = document.getElementById('estado').value;
            const operadora = document.getElementById('operadora').value;
            const tecnologia = document.getElementById('tecnologia').value;
            const data_inicio = document.getElementById('data_inicio').value;
            const data_fim = document.getElementById('data_fim').value;

            // Show loading indicator
            loadingIndicator.style.display = 'block';

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
                    // Hide loading indicator
                    loadingIndicator.style.display = 'none';

                    if (data.success) {
                        const results = data.results;
                        tableBody.innerHTML = '';

                        if (results.length === 0) {
                            // Display no results message
                            tableBody.innerHTML = '<tr><td colspan="9">No results found.</td></tr>';
                        } else {
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
                        }
                    } else {
                        // Display error message
                        errorElement.textContent = data.message;
                        errorElement.style.display = 'block';
                    }
                })
                .catch(error => {
                    // Display error message
                    errorElement.textContent = 'Error: ' + error.message;
                    errorElement.style.display = 'block';
                });
        }

        // Fetch initial data on page load
        fetchData();
    </script>

    <!-- Add loading indicator and error message elements -->
    <div id="loading-indicator" style="display: none;">Loading...</div>
    <div id="error-message" style="display: none; color: red;"></div>
</body>

</html>