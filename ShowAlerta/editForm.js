
        document.addEventListener("DOMContentLoaded", function() {
            var modal = document.getElementById("myModal");
            modal.style.display = "block"; //Mostrar o modal ao carregar a página

            var closeButton = document.getElementsByClassName("close")[0];
            closeButton.addEventListener("click", function() {
                modal.style.display = "none"; // Ocultar o modal ao clicar no botão de fechamento
            });
        });


        var form = document.getElementById("editForm");

        form.addEventListener("submit", function(event) {
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
                            }).then(() => {
                                window.location.href = '../index.php';
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

                    
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    window.location.href = '../index.php';
                }
            });
        });
