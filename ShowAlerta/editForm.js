document.addEventListener("DOMContentLoaded", function () {
    var modal = document.getElementById("myModal");
    modal.style.display = "block";

    var today = new Date().toISOString().split('T')[0];
    var fechamentoInput = document.getElementById('fechamento');
    fechamentoInput.value = today; // Establecer el valor del campo `fechamento` a la fecha de hoy


    fetch('/ShowAlerta/selectAn.php?action=obter_analistas')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const analistaInput = document.getElementById('analista');
                const input = document.getElementById('cod_usuario');
                const cod_usuario = input.value;

                const analista = data.analistas.find(analista => analista.cod_usuario === cod_usuario);

                if (analista) {
                    analistaInput.value = analista.nome;
                } else {
                    console.error('Analista no encontrado.');
                }
            } else {
                console.error('Error al obtener analistas:', data.message);
            }
        })
        .catch(error => {
            console.error('Error al cargar analistas:', error);
        });

    // Prevenir la navegación hacia atrás y adelante
    history.pushState(null, null, location.href);
    window.addEventListener('popstate', function () {
        history.pushState(null, null, location.href);
    });

    // Prevenir el refresco de la página
    window.addEventListener("beforeunload", function (event) {
        event.preventDefault();
    });
});

var form = document.getElementById("editForm");

form.addEventListener("submit", event => {
    event.preventDefault(); // Impedir que la página se recargue al enviar el formulario

    var formData = new FormData(form);
    var formObject = {
        cod_alerta: formData.get('cod_alerta'),
        analista: formData.get('analista'),
        fechamento: formData.get('fechamento')

    };

    console.log("Datos a enviar:", formObject); // Depuración: Verificar datos antes de enviar

    Swal.fire({
        title: 'Tem certeza?',
        text: "Deseja atualizar os dados do alerta?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sim, atualizar',
        cancelButtonText: 'Não, cancelar'
    })
        .then((result) => {
            console.log(result);
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
                        console.log("HTTP response:", response);
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log(data);
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

// Función para deshabilitar botones de navegación
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
