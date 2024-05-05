document.addEventListener('DOMContentLoaded', function () {
    const editIcons = document.querySelectorAll('.edit');
    editIcons.forEach(function (icon) {
        icon.addEventListener('click', function () {
            const codAlert = icon.getAttribute('data-id');
            //Aqui puedes mostrar una alerta con ell formulario
            //Ejemplo:
            alert('Se abrira un formulario para editar...')
        });
    });
});



    // // Obtener la ventana modal
    // var modal = document.getElementById("myModal");

    // // Obtener el botón que abre la ventana modal
    // var btn = document.getElementById("myBtn");

    // // Obtener el botón para cerrar la ventana modal
    // var span = document.getElementsByClassName("close")[0];

    // // Cuando el usuario haga clic en el botón, abrir la ventana modal
    // btn.onclick = function() {
    //     modal.style.display = "block";
    // }

    // // Cuando el usuario haga clic en <span> (x), cerrar la ventana modal
    // span.onclick = function() {
    //     modal.style.display = "none";
    // }

    // // Cuando el usuario haga clic en cualquier lugar fuera de la ventana modal, cerrarla
    // window.onclick = function(event) {
    //     if (event.target == modal) {
    //         modal.style.display = "none";
    //     }
    // }
    
