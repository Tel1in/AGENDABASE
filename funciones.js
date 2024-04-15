
document.addEventListener("DOMContentLoaded", function () {
    
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
    actualizarFecha();
    
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
    var fechaSeleccionada = new Date(fechaInputValue + 'T00:00:00');
    fechaActual = fechaSeleccionada;
    actualizarFecha();
}

function guardarFechaEnCookie() {
    var fechaFormateada = fechaActual.toISOString().split('T')[0];
    document.cookie = "fechaActual=" + encodeURIComponent(fechaFormateada);
    console.log(fechaActual);
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

