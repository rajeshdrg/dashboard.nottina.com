
// Obtiene la ventana modal y el botón de abrir
var modal = document.getElementById("myModal");
var openModalBtn = document.getElementById("openModalBtn");
var closeBtn = document.getElementsByClassName("close")[0];

// Abre la ventana modal cuando se hace clic en el botón
openModalBtn.onclick = function () {
    modal.style.display = "block";
}

// Cierra la ventana modal cuando se hace clic en el botón de cerrar
closeBtn.onclick = function () {
    modal.style.display = "none";
}

// Cierra la ventana modal cuando se hace clic fuera de ella
window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

// Envía el formulario al servidor
var form = document.getElementById("editForm");
form.addEventListener("submit", function (event) {
    event.preventDefault(); // Evita que se recargue la página al enviar el formulario
    // Aquí puedes agregar el código para enviar los datos del formulario al servidor utilizando AJAX
    // Por ejemplo, puedes usar fetch() o XMLHttpRequest
});


