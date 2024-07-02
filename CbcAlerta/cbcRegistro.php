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
            table-layout: auto;

        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
            min-width: 50px;

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
            padding: 8px 12px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        /* Media query para ajustar el contenedor */
        @media (max-width: 768px) {
            .container {
                width: 90%;
            }
        }
    </style>
</head>

<body>
    <h1>Consulta CBC Relatório</h1>

    <form id="filterForm">
        <label for="estado">Estado:</label>
        <select name="estado" id="estado">
            <option value="">Selecione um Estado</option>
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

    <button type="button" onclick="window.location.href='/CbcAlerta/index.php'">Voltar</button>

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
        function fetchOptions() {
            fetch('/CbcAlerta/cbcGetOptions.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const { estados, operadoras, tecnologias } = data.options;

                        const estadoSelect = document.getElementById('estado');
                        const operadoraSelect = document.getElementById('operadora');
                        const tecnologiaSelect = document.getElementById('tecnologia');

                        estados.forEach(estado => {
                            const option = document.createElement('option');
                            option.value = estado;
                            option.text = estado;
                            estadoSelect.appendChild(option);
                        });

                        operadoras.forEach(operadora => {
                            const option = document.createElement('option');
                            option.value = operadora;
                            option.text = operadora;
                            operadoraSelect.appendChild(option);
                        });

                        tecnologias.forEach(tecnologia => {
                            const option = document.createElement('option');
                            option.value = tecnologia;
                            option.text = tecnologia;
                            tecnologiaSelect.appendChild(option);
                        });
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function fetchData() {
            const estado = document.getElementById('estado').value.toUpperCase();
            const operadora = document.getElementById('operadora').value.toUpperCase();
            const tecnologia = document.getElementById('tecnologia').value;
            const data_inicio = document.getElementById('data_inicio').value;
            const data_fim = document.getElementById('data_fim').value;

            const params = {};
            if (estado) params.estado = estado;
            if (operadora) params.operadora = operadora;
            if (tecnologia) params.tecnologia = tecnologia;
            if (data_inicio) params.data_inicio = data_inicio;
            if (data_fim) params.data_fim = data_fim;

            const url = new URL('/CbcAlerta/searchCbc.php', window.location.origin);
            Object.keys(params).forEach(key => {
                url.searchParams.append(key, params[key]);
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
                            <td>${result.created_at.split(' ')[0]}</td>
                        `;

                            tableBody.appendChild(row);
                        });
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        document.addEventListener('DOMContentLoaded', () => {
            fetchOptions();
            fetchData();
        });
    </script>
</body>

</html>