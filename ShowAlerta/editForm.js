document.addEventListener("DOMContentLoaded", init);

function init() {
    const modal = document.getElementById("myModal");
    modal.style.display = "block";

    const today = new Date().toISOString().split('T')[0];
    const fechamentoInput = document.getElementById('fechamento');
    fechamentoInput.value = today;
    fechamentoInput.disabled = true;

    fetchAnalistas();
    disableNavigationButtons();
}

function fetchAnalistas() {
    fetch('/ShowAlerta/selectAn.php?action=obter_analistas')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const select = document.getElementById('analista');
                const input = document.getElementById('cod_usuario');
                const cod_usuario = input.value;

                data.analistas.forEach((analista, index) => {
                    const option = document.createElement('option');
                    option.value = analista.cod_usuario;
                    option.textContent = analista.nome;
                    select.appendChild(option);
                });

                select.value = cod_usuario;
            } else {
                handleError('Erro ao obter analistas:', data.message);
            }
        })
        .catch(error => {
            handleError('Erro ao carregar analistas:', error);
        });
}

function disableNavigationButtons() {
    history.pushState(null, null, location.href);
    window.addEventListener('popstate', function () {
        history.pushState(null, null, location.href);
    });

    window.addEventListener("beforeunload", function (event) {
        event.preventDefault();
    });
}

function handleError(message, error) {
    console.error(message, error);
    Swal.fire({
        icon: 'error',
        title: 'Erro',
        text: error.message
    });
}

const form = document.getElementById("editForm");
form.addEventListener("submit", handleSubmit);

function handleSubmit(event) {
    event.preventDefault();

    const formData = new FormData(form);
    const analista = formData.get('analista');
    const fechamento = formData.get('fechamento');

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
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
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

var cancelButton = document.getElementById("cancelButton");
cancelButton.addEventListener("click", () => {
    window.location.href = '../index.php';
});


function disableNavigationButtons() {
    history.pushState(null, null, location.href);
    window.addEventListener('popstate', function () {
        history.pushState(null, null, location.href);
    });

    window.addEventListener("beforeunload", function (event) {

        var showWarning = true;
        if (showWarning) {
            event.preventDefault();

        }
    });




}

disableNavigationButtons();
