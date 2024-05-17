document.addEventListener("DOMContentLoaded", function () {
    // Mostrar o modal no carregamento da página

    var modal = document.getElementById("myModal");

    modal.style.display = "block";

    // Carregue os analistas do backend e preencha o select 
    fetch('/ShowAlerta/selectAn.php?action=obtener_analistas')

        .then(response => response.json())

        .then(data => {
            console.log(data);
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

form.addEventListener("submit", function (event) {
    event.preventDefault(); // Impedir que a página seja recarregada ao enviar o formulário

    var formData = new FormData(form);
    console.log("Datos del formulario:", {
        cod_alerta: formData.get('cod_alerta'),
        analista: formData.get('analista'),
        fechamento: formData.get('fechamento')
    });

    Swal.fire({
        title: 'Tem certeza?',
        text: "Deseja atualizar os dados do alerta?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sim, atualizar',
        cancelButtonText: 'Não, cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('/ShowAlerta/guardar_edicion.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
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
                    console.error('Erro ao enviar solicitação:', error);
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

