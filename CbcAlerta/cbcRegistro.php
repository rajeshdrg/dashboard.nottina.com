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
    </style>
</head>

<body>
    <h1>Consulta CBC Relatório</h1>
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
            </tr>
        </thead>
        <tbody id="results">
            <!-- Los resultados se insertarán aquí -->
        </tbody>
    </table>

    <script>
        // Hacer una solicitud GET al archivo PHP para obtener los datos
        fetch('/CbcAlerta/searchCbc.php')  // Ajusta la ruta según sea necesario
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const results = data.results;
                    const tableBody = document.getElementById('results');

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
                        `;

                        tableBody.appendChild(row);
                    });
                } else {
                    console.error(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
    </script>
</body>

</html>