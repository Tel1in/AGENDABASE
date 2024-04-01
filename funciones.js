var cal = document.getElementById('calendar');
var tab = document.getElementById('tabla2');
var ta3 = document.getElementById('tabla3');
document.addEventListener("DOMContentLoaded", function () {
    cal;
    tab;
    ta3;
    calendar.style.display = 'none';
    tabla2.style.display = 'block';
    tabla3.style.display = 'none';
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


function cambiarVentana(x) {
    cal;
    tab;
    ta3;
    if (x == 'tabla2') {
        calendar.style.display = 'none';
        tabla2.style.display = 'block';
        tabla3.style.display = 'none';
    } else if(x == 'tabla3') {
        calendar.style.display = 'none';
        tabla2.style.display = 'none';
        tabla3.style.display = 'block';
    } else {
        calendar.style.display = 'block';
        tabla2.style.display = 'none';
        tabla3.style.display = 'none';
    }


}

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
    actualizarFecha();
}
