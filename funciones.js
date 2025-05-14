
document.addEventListener("DOMContentLoaded", function () {
    actualizarFecha();
    actualizarHora(); // Añadido: iniciar la actualización de la hora

    var fechaInput = document.getElementById('fechaInput');
    fechaInput.addEventListener('change', function() {
        actualizarFechaSeleccionada();
    });
    fechaInput.addEventListener('input', function() {
    
        setTimeout(function() {
            if (!fechaInput.value) {
                
                hoy();
            }
        }, 0);
    });

    
    fechaInput.addEventListener('click', function(event) {
        if (event.target.type === 'date' && !fechaInput.value) {
            
            hoy();
        }
    });
    
});



var fechaActual = new Date();

function hoy() {
    fechaActual = new Date();
    actualizarFecha();
}

function moverDia(dias) {
    fechaActual.setDate(fechaActual.getDate() + dias);
    actualizarFecha();

}

function actualizarFecha() {
    var fechaHeader = document.getElementById('fechaHeader');
    var opcionesFecha = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    var fechaFormateada = fechaActual.toLocaleDateString('es-ES', opcionesFecha);

    fechaHeader.textContent = fechaFormateada;
    diaActual.disabled = esFechaActual();
    guardarFechaEnCookie();
    cargarTablaEventosDesdePHP()

}

function esFechaActual() {
    var fechaHoy = new Date();
    return (
        fechaActual.getDate() === fechaHoy.getDate() &&
        fechaActual.getMonth() === fechaHoy.getMonth() &&
        fechaActual.getFullYear() === fechaHoy.getFullYear()
    );
}

function actualizarFechaSeleccionada() {
    var fechaInputValue = document.getElementById("fechaInput").value;
    fechaActual = new Date(fechaInputValue + 'T00:00:00');
    actualizarFecha();
}

function guardarFechaEnCookie() {
    var fechaFormateada = fechaActual.toLocaleDateString('en-CA');
    document.cookie = "fechaActual=" + encodeURIComponent(fechaFormateada);
    console.log("Fecha guardada en cookie:", fechaFormateada);
    console.log("Objeto Date:", fechaActual);
}


function cargarTablaEventosDesdePHP() {
    var spinner = document.getElementById('spinner2');
    var tabla = document.getElementById('tablaEventosBody');
    spinner.style.display = 'block';
    tabla.style.display = 'none';
    fetch('eventosAgenda.php')
    .then(response => response.text())
    .then(data => {
    
        tabla.innerHTML = data;
        spinner.style.display = 'none';
        tabla.style.display = '';
    })
    .catch(error => console.error('Error al cargar la tabla de eventos:', error));
}

// Funciones añadidas para actualizar la hora
function actualizarHora() {
    const ahora = new Date();
    const horas = ahora.getHours().toString().padStart(2, '0');
    const minutos = ahora.getMinutes().toString().padStart(2, '0');
    const segundos = ahora.getSeconds().toString().padStart(2, '0');
    
    const horaActual = `${horas}:${minutos}:${segundos}`;
    
    document.getElementById('horheader').textContent = horaActual;
}

// Actualizar la hora cada segundo
setInterval(actualizarHora, 1000);