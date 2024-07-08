// cambiarVentanas.js
export function cambiarVentanas(x) {    
    var cal = document.getElementById('calendar');
    var tab = document.getElementById('tabla2');

  
    if (x === 'calendar') {
      cal.classList.remove('d-none');
      tab.classList.add('d-none');

      window.calendar.updateSize(); // Forzar la actualización del tamaño
      window.calendar.render(); // Forzar el renderizado del calendario
    } else if (x === 'tabla3') {
      cal.classList.add('d-none');
      tab.classList.add('d-none');
      ta3.classList.remove('d-none');
    } else {
      cal.classList.add('d-none');
      tab.classList.remove('d-none');
    }
  }