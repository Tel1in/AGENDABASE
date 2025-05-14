import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import { cambiarVentanas } from './cambiarVentana';
import bootstrap5Plugin from '@fullcalendar/bootstrap5';

async function obtenerEventos() {
  const response = await fetch('eventosAgenda2.php');
  const eventos = await response.json();
  return eventos;
}

const fechaActual = new Date();

let calendarEl = document.getElementById('calendar');
let modal = document.getElementById('exampleModal');
let fechaEventoInput = document.getElementById('d1');
let modal1 = bootstrap.Modal.getOrCreateInstance(modal);

let calendar = new Calendar(calendarEl, {
  selectable: true,
  locale: 'es',
  aspectRatio: 2,
  themeSystem: 'bootstrap5',
  plugins: [bootstrap5Plugin, dayGridPlugin, interactionPlugin],
  dateClick: function(info) {
    const fechaSeleccionada = info.dateStr;
    fechaEventoInput.value = fechaSeleccionada;
    modal1.show();
  },
  initialView: 'dayGridMonth',
  events: async function (fetchInfo, successCallback, failureCallback) {
    try {
      const eventos = await obtenerEventos();
      const eventosFormateados = eventos.map(evento => ({
        ...evento,
        color: determinarColor(evento.start, evento.end)
      }));
      successCallback(eventosFormateados);
    } catch (error) {
      failureCallback(error);
    }
  },
  eventClick: function(info) {
    const idEven = info.event.id;
    let modal2 = document.getElementById('exampleModal3');
    let modal3 = bootstrap.Modal.getOrCreateInstance(modal2);

    function formatTime(minutes) {
        if (minutes < 60) {
            return `${minutes} minutos`;
        } else {
            let hours = Math.floor(minutes / 60);
            let remainingMinutes = minutes % 60;
            let hourText = hours > 1 ? 'horas' : 'hora';
            return remainingMinutes === 0
                ? `${hours} ${hourText}`
                : `${hours} ${hourText} ${remainingMinutes} minutos`;
        }
    }

    fetch('llenarform2.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: 'ideagendas=' + encodeURIComponent(idEven),
    })
    .then(response => response.json())
    .then(data => {
      console.log('Datos del evento recibidos:', data);
      document.getElementById('idE0').value = data.ideagendas;
      document.getElementById('nom2').value = data.nombreA;
      document.getElementById('des2').value = data.desA;
      document.getElementById('d100').value = data.fecha;
      document.getElementById('h100').value = data.hora;
      let select1 = document.getElementById('hs10');
      let optionGuardada = document.createElement('option');
      optionGuardada.value = data.tiempo;
      optionGuardada.textContent = formatTime(data.tiempo);
      optionGuardada.selected = true;

      let existingOption1 = select1.querySelector(`option[value="${data.tiempo}"]`);
      if (existingOption1) {
          select1.replaceChild(optionGuardada, existingOption1);
      } else {
          select1.appendChild(optionGuardada);
      }

      if (Array.isArray(data.tiempo)) {
          data.tiempo.forEach(function(item) {
              if (item.tiempo !== data.tiempo) {
                  let option = select1.querySelector(`option[value="${item.tiempo}"]`);
                  if (option) {
                      option.textContent = formatTime(item.tiempo);
                  } else {
                      option = document.createElement('option');
                      option.value = item.tiempo;
                      option.textContent = formatTime(item.tiempo);
                      select1.appendChild(option);
                  }
              }
          });
      }
      modal3.show();
    })
    .catch(error => console.error('Error al obtener los datos del evento:', error));
  }
});

function determinarColor(start, end) {
  const ahora = new Date();
  const evento = new Date(start);
  const finEvento = new Date(end);

  if (ahora < evento) {
    return 'green';
  } else if (ahora >= evento && ahora < finEvento) {
    return 'yellow';
  } else {
    return 'red';
  }
}


function adjustCalendar() {
  const isMobile = window.innerWidth < 768;
  calendar.setOption('aspectRatio', isMobile ? 0.8 : 1.35);
  calendarEl.style.fontSize = isMobile ? '12px' : '20px';
}

window.addEventListener('resize', adjustCalendar);
adjustCalendar(); // Ajuste inicial
window.calendar = calendar;
window.cambiarVentanas = cambiarVentanas; // Exportar la función cambiarVentanas a la ventana global

calendar.render();