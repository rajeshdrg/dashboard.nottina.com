
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


SELECT alerta.quando, alerta.cod_usuario, usuario.cod_usuario
FROM alerta 
LEFT OUTER JOIN usuario ON alerta.cod_usuario = usuario.cod_usuario 
WHERE alerta.fechamento IS NULL;
           quando           | cod_usuario | cod_usuario 
----------------------------+-------------+-------------
 2024-04-20 00:00:00        |           3 |            
 2024-01-29 15:30:01.291818 |           1 |            
 2023-07-19 15:00:01.498509 |           1 |            
 2023-08-11 05:30:01.221615 |           1 |            
 2023-10-18 02:16:52.717286 |           1 |            
 2023-10-07 01:40:01.219202 |           1 |            
 2023-10-07 01:40:01.22346  |           1 |            
 2023-12-22 01:40:01.585892 |           1 |            
 2023-12-21 05:40:01.686351 |           1 |            
 2024-01-29 16:27:29.12748  |           1 |            
 2024-02-01 15:47:54.860957 |           1 |            
 2024-02-27 18:55:22.031541 |           1 |            
 2024-02-05 11:50:01.835735 |           1 |            
(13 rows)
