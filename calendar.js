import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import { cambiarVentanas } from './cambiarVentana';

// Función para obtener los eventos desde el servidor
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
  }
});

window.calendar = calendar;
window.cambiarVentanas = cambiarVentanas; // Exportar la función cambiarVentanas a la ventana global

calendar.render();