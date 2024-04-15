import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from 'https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.11/index.global.min.js';

document.addEventListener('DOMContentLoaded', function () {
  var calendarEl = document.getElementById('calendar');
  var calendar = new Calendar(calendarEl, {
    plugins: [dayGridPlugin],
    selectable : true ,
    dateClick : function(info) {
        alert('clicked ' + info.dateStr);   
    },
    select: function(info) {
        alert('selected ' + info.startStr + ' to ' + info.endStr);
      }
  });
  calendar.render();
  calendar.getOption('locale');
  calendar.setOption('locale', 'mx');
});

