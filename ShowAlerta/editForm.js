document.addEventListener("DOMContentLoaded", function () {
    var modal = document.getElementById("myModal");
    modal.style.display = "block";


    var today = new Date().toISOString().split('T')[0];
    var fechamentoInput = document.getElementById('fechamento');
    fechamentoInput.setAttribute('min', today);

    // Set max date if needed, for example 1 year from today
    var maxDate = new Date();
    maxDate.setFullYear(maxDate.getFullYear() + 1);
    fechamentoInput.setAttribute('max', maxDate.toISOString().split('T')[0]);

    fetch('/ShowAlerta/selectAn.php?action=obter_analistas')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const select = document.getElementById('analista');
                data.analistas.forEach(analista => {
                    const option = document.createElement('option');
                    option.value = analista.cod_usuario;
                    option.textContent = analista.nome;
                    select.appendChild(option);
                });
            } else {
                console.error('Erro ao obter analistas:', data.message);
            }
        })
        .catch(error => {
            console.error('Erro ao carregar analistas:', error);
        });
});

var form = document.getElementById("editForm");

form.addEventListener("submit", event => {
    event.preventDefault(); // Impedir que a página seja recarregada ao enviar o formulário

    var formData = new FormData(form);
    var formObject = {
        cod_alerta: formData.get('cod_alerta'),
        analista: formData.get('analista'),
        fechamento: formData.get('fechamento')

    };
    // console.log("Datos del formulario:", formObject);

    Swal.fire({
        title: 'Tem certeza?',
        text: "Deseja atualizar os dados do alerta?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sim, atualizar',
        cancelButtonText: 'Não, cancelar'
    })
        .then((result) => {
            if (result.isConfirmed) {
                fetch('/ShowAlerta/guardar_edicion.php', {
                    method: 'POST',
                    mode: "cors",
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(formObject)
                })
                    .then(response => {
                        // console.log("HTTP response:", response);
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // console.log(data);
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Os campos foram alterados corretamente',
                                showConfirmButton: true,
                                confirmButtonText: 'Fechar'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = '../index.php';
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro',
                                text: data.message
                            }).then(() => {
                                window.location.href = '../index.php';
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro ao enviar solicitação',
                            text: 'Ocorreu um erro ao enviar a solicitação. Por favor, tente novamente mais tarde.'
                        }).then(() => {
                            window.location.href = '../index.php';
                        });
                    });
            } else {
                window.location.href = '../index.php';
            }
        });
});
