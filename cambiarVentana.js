
    var cal = document.getElementById('calendar');
    var tab = document.getElementById('tabla2');
    var ta3 = document.getElementById('tabla3');
    
    document.addEventListener("DOMContentLoaded",function() {
        calendar.style.display = 'none';
        tabla2.style.display = 'block';
        tabla3.style.display = 'none';

    });
   

    function cambiarVentanas(x) {
        if (x == 'tabla2') {
            calendar.style.display = 'none';
            tabla2.style.display = 'block';
            tabla3.style.display = 'none';
        } else if (x == 'tabla3') {
            calendar.style.display = 'none';
            tabla2.style.display = 'none';
            tabla3.style.display = 'block';
        } else {
            calendar.style.display = 'block';
            tabla2.style.display = 'none';
            tabla3.style.display = 'none';
        }
    };

