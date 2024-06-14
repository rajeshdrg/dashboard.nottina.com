document.addEventListener("DOMContentLoaded", function () {
    var modal = document.getElementById("myModal");
    modal.style.display = "block";

    var today = new Date().toISOString().split('T')[0];
    var fechamentoInput = document.getElementById('fechamento');
    fechamentoInput.value = today; // Defina o valor do campo `data` para a data de hoje


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

    //Impedir a navegação para frente e para trás
    history.pushState(null, null, location.href);
    window.addEventListener('popstate', function () {
        history.pushState(null, null, location.href);
    });

    // Impedir a atualização da página
    window.addEventListener("beforeunload", function (event) {
        event.preventDefault();
    });
});

var form = document.getElementById("editForm");

form.addEventListener("submit", async (event) => {
    event.preventDefault(); // Impedir que a página seja recarregada ao enviar o formulário

    var formData = new FormData(form);
    var formObject = {
        cod_alerta: formData.get('cod_alerta'),
        analista: formData.get('analista'),
        fechamento: formData.get('fechamento'),
        cod_usuario: formData.get('cod_usuario'),

    };

    //console.log("Datos a enviar:", formObject); //Depuração: verifique os dados antes de enviar

    // const result = await Swal.fire({
    //     title: 'Tem certeza?',
    //     text: "Deseja atualizar os dados do alerta?",
    //     icon: 'warning',
    //     showCancelButton: true,
    //     confirmButtonText: 'Sim, atualizar',
    //     cancelButtonText: 'Não, cancelar'
    // })

    // if (result.isConfirmed) {
    //     const response = await fetch('/ShowAlerta/guardar_edicion.php', {
    //         method: 'POST',
    //         mode: "cors",
    //         headers: {
    //             'Content-Type': 'application/json'
    //         },
    //         body: JSON.stringify(formObject)
    //     })

    //     if (!response.ok) {
    //         throw new Error('Network response was not ok');
    //     }

    //     const data = await response.json();
    //     if (data.success) {
    //         const result2 = await Swal.fire({
    //             icon: 'success',
    //             title: 'Os campos foram alterados corretamente',
    //             showConfirmButton: true,
    //             confirmButtonText: 'Fechar'
    //         })

    //         if (result2.isConfirmed) {
    //             window.location.href = '../index.php';
    //         }
    //     } else {
    //         const result3 = await Swal.fire({
    //             icon: 'error',
    //             title: 'Erro',
    //             text: data.message
    //         })
    //         window.location.href = '../index.php';
    //     }
    // }


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
