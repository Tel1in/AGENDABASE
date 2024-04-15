/*--JS PARA FUNCIONES DEL CALENDARIO -->*/

document.addEventListener("DOMContentLoaded",function(){
    var cal = document.getElementById("calendar");
    var cal1 = new FullCalendar.Calendar(cal, {
        selectable : true,
        headerToolbar: {
          },
          dateClick: function(info) {
            alert('clicked ' + info.dateStr);
          },
          select: function(info) {
            alert('selected ' + info.startStr + ' to ' + info.endStr);
          }
    });
    cal1.render();
});