import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import { cambiarVentanas } from './cambiarVentana';


async function obtenerEventos() {
  const response = await fetch('eventosAgenda2.php');
  const eventos = await response.json();
  return eventos;
}

let calendarEl = document.getElementById('calendar');
let modal = document.getElementById('exampleModal');
let fechaEventoInput = document.getElementById('d1');
let modal1 = bootstrap.Modal.getOrCreateInstance(modal);


let calendar = new Calendar(calendarEl, {
  selectable: true,
  locale: 'es',
  aspectRatio: 2,
  plugins: [dayGridPlugin, interactionPlugin],
  dateClick: function (info) {
    const fechaSeleccionada = info.dateStr;
    fechaEventoInput.value = fechaSeleccionada;
    modal1.show();
  },
  initialView: 'dayGridMonth',
  events: async function (fetchInfo, successCallback, failureCallback) {
    try {
      const eventos = await obtenerEventos();
      successCallback(eventos);
    } catch (error) {
      failureCallback(error);
    }
  },
  eventClick: function(info){
    const idEven = info.event.id;
    let modal2 = document.getElementById('exampleModal3');
    let modal3 = bootstrap.Modal.getOrCreateInstance(modal2);
    fetch('llenarform2.php',{
      method : 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: 'id_evento_agenda=' + encodeURIComponent(idEven),
    })
    .then(response => response.json())
    .then(data => {
            console.log('Datos del evento recibidos:', data);
            document.getElementById('idE0').value = data.id_evento_agenda;
            document.getElementById('s100').value = data.nom_expediente;
            document.getElementById('s1100').value = data.numero;
            if (typeof data.nombreInv === 'string') {
                let id_involucrado = data.id_inv;
                let option = document.createElement('option');
                option.value = id_involucrado;
                option.textContent = data.nombreInv;
                document.getElementById('s1200').innerHTML = ''; 
                document.getElementById('s1200').appendChild(option);
            } else {
                console.error('nombre_inv no es una cadena de texto:', data.nombreInv);
            }

            let optionGuardada = document.createElement('option');
            optionGuardada.value = data.id_tipo_audiencia; 
            optionGuardada.textContent = data.nom_tipo_audiencia; 
            optionGuardada.selected = true; 
            document.getElementById('s300').appendChild(optionGuardada);

            // Verificar si nom_tipo_audiencia es un arreglo
            if (Array.isArray(data.nom_tipo_audiencia)) {
                // Iterar sobre cada tipo de audiencia en el arreglo
                data.nom_tipo_audiencia.forEach(function(audiencia) {
                    // Crear una opción para cada tipo de audiencia
                    var option = document.createElement('option');
                    option.value = audiencia.id_tipo_audiencia;
                    option.textContent = audiencia.nom_tipo_audiencia;

                    // Agregar la opción al select
                    document.getElementById('s300').appendChild(option);
                });
            } 

            let optionGuardada2 = document.createElement('option');
            optionGuardada2.value = data.id_sala; 
            optionGuardada2.textContent = data.nombre_sala; 
            optionGuardada2.selected = true; 
            document.getElementById('sala10').appendChild(optionGuardada2);

            // Verificar si nom_tipo_audiencia es un arreglo
            if (Array.isArray(data.nombre_sala)) {
                // Iterar sobre cada tipo de audiencia en el arreglo
                data.nombre_sala.forEach(function(sala) {
                    // Crear una opción para cada tipo de audiencia
                    let option = document.createElement('option');
                    option.value = sala.id_sala;
                    option.textContent = sala.nom_tipo_audiencia;

                    // Agregar la opción al select
                    document.getElementById('sala10').appendChild(option);
                });
            } 

            
            let optionGuardada3 = document.createElement('option');
            optionGuardada3.value = data.id_juez; 
            optionGuardada3.textContent = data.nom_juez; 
            optionGuardada3.selected = true; 
            document.getElementById('juez10').appendChild(optionGuardada3);

            // Verificar si nom_tipo_audiencia es un arreglo
            if (Array.isArray(data.nom_juez)) {
                data.nom_juez.forEach(function(juez) {
                    let option = document.createElement('option');
                    option.value = juez.id_juez;
                    option.textContent = juez.nom_juez;
                    // Agregar la opción al select
                    document.getElementById('juez10').appendChild(option);
                });
            } 

            document.getElementById('d100').value = data.fecha;
            document.getElementById('h100').value = data.hora;
            document.getElementById('evento10').value = data.evento;

            
            modal3.show();
          })
          .catch(error => console.error('Error al obtener los datos del evento:', error));
  }
});

window.calendar = calendar;
window.cambiarVentanas = cambiarVentanas; // Exportar la función cambiarVentanas a la ventana global

calendar.render();