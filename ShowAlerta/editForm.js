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