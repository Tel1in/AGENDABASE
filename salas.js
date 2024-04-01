var usuarioP = "USER10";
var salaT = document.getElementById("n0");
var salaA = document.getElementById("n1");
var bahia = document.getElementById("n2");
var cjm = document.getElementById("n3");
var santi = document.getElementById("n4");
var ixtlan = document.getElementById("n5");
var salaTe = document.getElementById("n6");
var sanPa = document.getElementById("n7");
var sele = document.getElementById("s1")

document.addEventListener("DOMContentLoaded", function () {





    setTimeout(function () {
        mostrarNavbar();
    }, 1000);


    n0.style.display = 'none';
    n1.style.display = 'none';
    n2.style.display = 'none';
    n3.style.display = 'none';
    n4.style.display = 'none';
    n5.style.display = 'none';
    n6.style.display = 'none';
    n7.style.display = 'none';

    if (usuarioP === "USER1") {
        llenarSelectSegunUsuario();
    }
});

function mostrarNavbar() {

    var spinner = document.getElementById("spinner");
    spinner.style.display = 'none';
    if (usuarioP == "USER1") {
        n0.classList.remove("initial-hidden");
        n0.style.display = 'block';
    } else {
        n1.style.display = 'block';
    }

}
function llenarSelectSegunUsuario() {
    s1.innerHTML = "";

    var opcionesDisponibles = ["sala1", "sala2", "sala3"];


    for (var i = 0; i < opcionesDisponibles.length; i++) {
        var opcionValor = opcionesDisponibles[i];
        var opcionTexto = "Sala " + (i + 1);

        var opcion = document.createElement("option");
        opcion.value = opcionValor;
        opcion.text = opcionTexto;


        s1.appendChild(opcion);

     
        if (usuarioP === "USER1" && (opcionValor === "sala1" || opcionValor === "sala2")) {
            opcion.style.display = 'block';  
        } else {
            opcion.style.display = 'none';   
        }
    }
}