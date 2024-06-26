document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('sendDataButton').addEventListener('click', function () {
        let data = gatherData();
        sendDataToServer(data);
    });

    function gatherData() {
        let table = document.querySelector('.table.table-striped tbody');
        let rows = table.getElementsByTagName('tr');
        let data = [];

        for (let i = 0; i < rows.length; i++) {
            let cells = rows[i].getElementsByTagName('td');
            let rowData = {
                estado: cells[0].innerText,
                operadora: cells[1].innerText.split(' (')[0],
                mme: cells[2].innerText || '',
                amf: cells[3] ? cells[3].innerText : '',
                status: cells[4].querySelector('select') ? cells[4].querySelector('select').value : cells[4].innerText,
                teste: cells[5].querySelector('input') ? cells[5].querySelector('input').value : cells[5].innerText,
                roteamento: cells[6].querySelector('select') ? cells[6].querySelector('select').value : cells[6].innerText
            };
            data.push(rowData);
        }
        return data;
    }

    function sendDataToServer(data) {
        let xhr = new XMLHttpRequest();
        xhr.open('POST', '/erpme/banco/conection.php', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                alert('Dados enviados com sucesso!');
                window.location.reload();
            }
        };
        xhr.send(JSON.stringify(data));
    }
});
