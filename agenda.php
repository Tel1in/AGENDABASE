<?php
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (!isset($_SESSION['usuario'])) {
        header('Location: index.php');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="./src/calendar.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.1/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
    crossorigin="anonymous"></script> 
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.1/dist/sweetalert2.all.min.js"></script>
    


<script src="funciones.js"></script>

<!--LLAMADA A INSERTAR DATOS-->
<script>
    document.addEventListener("DOMContentLoaded", function() {
    var form = document.querySelector("#insertaForm");
    form.addEventListener("submit", function(event) {
        event.preventDefault();
        
        var formData = new FormData(form);
        fetch("insertarEvento.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            if (data.trim() === "Evento insertado correctamente.") {
                Swal.fire("Evento Insertado con Éxito", "CONTINUAR", "success")
                .then(() => {
                    location.reload();
                });
            } else {
                Swal.fire("Error", data, "error");
            }
        })
        .catch(error => {
            console.error("Error en la solicitud Fetch: " + error.message);
            Swal.fire("Error", "Hubo un error en la solicitud", "error");
            });
        });
    });
</script>

<!--LLAMADA A MODIFICAR DATOS-->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var modificarForm = document.getElementById("modificarFormulario");
        var modificarForm2 = document.getElementById("modificarFormulario2");

        modificarForm2.addEventListener("submit", function(event) {
            event.preventDefault();
            var formData = new FormData(modificarForm2);
            enviarFormulario(formData);
        });
       
        function enviarFormulario(formData) {
            fetch("modificar_evento.php", {
                method: "POST",
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Error en la solicitud: ${response.status} ${response.statusText}`);
                }
                return response.text();
            })
            .then(data => {
                if (!data.trim()) {
                    // Si la respuesta está vacía, mostramos un mensaje de éxito genérico
                    Swal.fire("Evento Modificado con Éxito", "CONTINUAR", "success")
                    .then(() => {
                        location.reload();
                    });
                } else if (data.trim() === "Evento modificado correctamente.") {
                    // Si la respuesta contiene el mensaje de éxito esperado
                    Swal.fire("Evento Modificado con Éxito", "CONTINUAR", "success")
                    .then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire("Error", data, "error");
                }
            })
            .catch(error => {
                console.error("Error en la solicitud Fetch: " + error.message);
                Swal.fire("Error", "Hubo un error en la solicitud", "error");
            });
        }
    });
</script>

<!--LLAMADA A ELIMINAR DATOS-->
<script>
  function eliminarDatos(ideagendas) {
        Swal.fire({
            title: "¿Estás seguro?",
            text: "Esta acción eliminará permanentemente el evento",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('eliminar_evento.php?ideagendas=' + ideagendas)
                    .then(response => response.text())
                    .then(data => {
                        Swal.fire("¡Eliminado!", "El evento ha sido eliminado correctamente.", "success")
                        .then(() => {
                            window.location.reload();
                        });
                    })
                    .catch(error => {
                        Swal.fire("Error", "Hubo un problema al eliminar el evento", "error");
                        console.error(error);
                    });
            } else {
                Swal.fire("Cancelado", "La eliminación del evento ha sido cancelada", "info");
            }
        });
    }
</script>

<!--CAMBIO DE BOOTNES MODAL-->
<script>
    
    document.addEventListener('DOMContentLoaded', function () {
        var modificarBtn1 = document.getElementById("modificarBtn2");
        var modalFooter1 = document.querySelector("#exampleModal3 .modal-footer");
        var inputs1 = document.querySelectorAll("#exampleModal3 input:not(#s100, #s1100, #s1200)"); 
        var selects1 = document.querySelectorAll("#exampleModal3 select:not(#s1200)"); 
        var horaInput = document.getElementById("h100"); 
        var modal = document.getElementById('exampleModal3');
        var inputs = document.querySelectorAll("#exampleModal3 input");
        var descripcionTextarea = document.getElementById("des2");

        // Agregar evento al botón "Modificar"
        function mostrarBotonesEdicion()  {
            modificarBtn1.removeEventListener('click', mostrarBotonesEdicion);
            // Habilitar la edición de los campos de entrada (excepto "Expediente", "Número" e "Imputado")
            for (var i = 0; i < inputs1.length; i++) {
                inputs1[i].readOnly = false;
            }

            for (var i = 0; i < selects1.length; i++) {
                selects1[i].disabled = false;
            }

            // Habilitar la edición del campo de hora
            horaInput.disabled = false;
            flatpickr("#h100", { enableTime: true, noCalendar: true, dateFormat: "H:i", time_24hr: true });

                 // Habilitar la edición del textarea de descripción
            descripcionTextarea.readOnly = false; // Añadimos esta línea
            
            // Crear botón "Cancelar"
            var cancelarBtn1 = document.createElement("button");
            cancelarBtn1.setAttribute("type", "button");
            cancelarBtn1.setAttribute("class", "btn btn-secondary");
            cancelarBtn1.textContent = "Cancelar";
            cancelarBtn1.addEventListener("click", function () {
                restaurarBotonesInicio();
                // Restaurar los campos de entrada a solo lectura
                for (var i = 0; i < inputs1.length; i++) {
                    inputs1[i].readOnly = true;
                }
                for (var i = 0; i < selects1.length; i++) {
                    selects1[i].disabled = true;
                }
                horaInput.disabled = true;
                descripcionTextarea.readOnly = true; // Añadimos esta línea
            });

            // Crear botón "Confirmar"
            var confirmarBtn1 = document.createElement("button");
            confirmarBtn1.setAttribute("type", "submit");
            confirmarBtn1.setAttribute("class", "btn btn-danger");
            confirmarBtn1.textContent = "Confirmar";
            confirmarBtn1.addEventListener("click", function () {
                // Este es el lugar donde podrías agregar la lógica para confirmar
                // Por ahora, no haremos nada al hacer clic en "Confirmar"
            });

            // Agregar botones "Cancelar" y "Confirmar" al pie de página del modal
            modalFooter1.innerHTML = "";
            modalFooter1.appendChild(cancelarBtn1);
            modalFooter1.appendChild(confirmarBtn1);
        }

        function restaurarBotonesInicio() {
            // Remover los botones actuales
            modalFooter1.innerHTML = "";

            descripcionTextarea.readOnly = true; 

            // Crear y agregar los botones estándar
            var cerrarBtn1 = document.createElement('button');
            cerrarBtn1.type = 'button';
            cerrarBtn1.classList.add('btn', 'btn-secondary');
            cerrarBtn1.dataset.bsDismiss = 'modal';
            cerrarBtn1.textContent = 'Cerrar';

            var modificarBtn1 = document.createElement('button');
            modificarBtn1.type = 'button';
            modificarBtn1.classList.add('btn', 'btn-primary');
            modificarBtn1.id = 'modificarBtn2';
            modificarBtn1.textContent = 'Modificar';
            modificarBtn1.addEventListener('click', mostrarBotonesEdicion);

            var eliminarBtn1 = document.createElement('button');
            eliminarBtn1.type = 'button';
            eliminarBtn1.classList.add('btn', 'btn-danger');
            eliminarBtn1.id = 'eleminarBtnModa';
            eliminarBtn1.textContent = 'Eliminar';
            eliminarBtn1.addEventListener('click', () => eliminarDatos(document.getElementById('idE0').value));

            modalFooter1.appendChild(cerrarBtn1);
            modalFooter1.appendChild(modificarBtn1);
            modalFooter1.appendChild(eliminarBtn1);
        }

        modificarBtn1.addEventListener('click', mostrarBotonesEdicion);

        modal.addEventListener('hidden.bs.modal', function () {
            modalFooter1.innerHTML = '';
            restaurarBotonesInicio();
        });

        // Agregar controlador de eventos al modal para inicializar los botones al mostrarse
        modal.addEventListener('shown.bs.modal', function () {
            restaurarBotonesInicio();
        });
    });
</script>

<!--LLAMADA A IMPIRMIR PANTALLA-->
<script>
   document.addEventListener('DOMContentLoaded', function () {
        var printButton = document.getElementById('printButton');
        var isPrinting = false;

        printButton.addEventListener('click', function () {
            if (!isPrinting) {
            setTimeout(function() {
                printContent('tabla2');
            }, 0);
            }
        });

        function printContent(elementId) {
            var printContents = document.getElementById(elementId);
            if (!printContents) {
            console.error('Element with id "' + elementId + '" not found.');
            return;
            }
            isPrinting = true;
            printContents = printContents.innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            isPrinting = false;
        }
        });
</script>


<title>AGENDA V2</title>
</head>

<body>
<div class="container-fluid" id="contenidoPrincipal">
    <div class="navbar ">
        <div class="container-fluid justify-content-start">
            <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-secondary" onclick="cambiarVentanas('calendar')">MES</button>
                <button type="button" class="btn btn-secondary" onclick="cambiarVentanas('tabla2')">DIA</button>
            </div>
        </div>

    </div>
    <div class="row-3";>
        <div class="col-12">
            <div id="calendar" class="d-none">
            </div>
            <div id="tabla2">
                <div class="navbar">
                    <div class="container">
                        <h2 id="fechaHeader" class="i" style="font-size:15px;"></h2>
                        <h2 id="horheader" class="i" ></h2>
                        <button type="button" class="btn btn-outline-secondary" id="printButton"><i class="bi bi-printer"></i>
                        </button>
                        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                            <div class="me-2" role="group" aria-label="First group">
                                <label for="fechaInput">Seleccione fecha:</label>
                                <input type="date" id="fechaInput" onchange="actualizarFecha()">
                            </div>
                            <div class="btn-group me-2" role="group" aria-label="First group">
                                <button type="button" class="btn btn-dark" onclick="hoy()"
                                    id="diaActual">today</button>
                            </div>
                            <div class="btn-group me-2" role="group" aria-label="First group">
                                <button type="button" class="btn btn-dark" onclick="moverDia(-1)"><i
                                        class="bi bi-chevron-left"></i></button>
                                <button type="button" class="btn btn-dark" onclick="moverDia(1)"><i
                                        class="bi bi-chevron-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                    <div class="container">
                        <div class="spinner-border text-primary position-fixed  start-50 " role="status" id="spinner2" style="display: none;">
                            <span class="visually-hidden">Cargando...</span>
                        </div>  
                        <table id="example" class="table table-bordered "
                            style="border-style:hidden; border-color: black;">
                            <thead>
                                <tr>
                                    <th style="width: 120px;">Hora</th>
                                    <th>Evento</th>
                                </tr>
                            </thead>
                            <tbody id="tablaEventosBody" style="style=display: none;">
                                    <?php
                                    require_once 'eventosAgenda.php'; 
                                    ?>

                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-4 mb-4">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" id="agregarEventoBtn" data-bs-target="#exampleModal">
                            Agregar Evento
                        </button>
                    </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div id="myModal">
                <div class="modal fade" id="exampleModal" aria-labelledby="exampleModalLabel" aria-modal="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">AGREGAR EVENTO</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="insertarEvento.php" method="post" id="insertaForm" name="insertaForm">
                                <div class="modal-body">
                                        <label for="nom">Nombre del evento</label>
                                        <input type="text" class="form-control" id="nom" name="nom">
                                        <label for="des">Descripcion</label>
                                        <textarea name="des" id="des" class="form-control" ></textarea>
                                        <label for="d1">Fecha</label>
                                        <input type="date" id="d1" name="d1" class="form-control" required>
                                        <label for="h1">Hora</label>
                                        <input type="time" pattern="[0-9]{2}:[0-9]{2}" step="1" class="form-control" name="h1" id="h1" required>
                                        <label for="hs1">Tiempo del evento</label>
                                        <select  id="hs1" name="hs1" class="form-select" required>
                                            <option value="" selected disabled>Selecciona un tiempo</option>
                                            <option value="30">30 minutos</option>
                                            <option value="60">1 hora</option>
                                            <option value="90">1 hora 30 minutos</option>
                                            <option value="120">2 horas</option>
                                            <option value="150">2 horas 30 minutos</option>
                                            <option value="180">3 horas</option>
                                            <option value="210">3 horas 30 minutos</option>
                                            <option value="240">4 horas</option>
                                        </select>          
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="reset" class="btn btn-danger">Limpiar Formulario</button>
                                    <button type="submit" class="btn btn-success">Insertar Datos</button>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="myModal3" >
            <div class="modal fade" id="exampleModal3" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">EVENTO</h5>

                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form action="modificar_evento.php" method="post" id="modificarFormulario2">
                            <div class="modal-body">
                                    <input type="hidden" id="modal2" name="modal" value="2">
                                    <input type="hidden" class="form-control" name="idE0" id="idE0">
                                    <label for="nom2">Nombre del evento</label>
                                    <input type="text"  class="form-control" id="nom2" name="nom2" readonly>
                                    <label for="des2">Descripcion</label>
                                    <textarea name="des2" id="des2" class="form-control" readonly></textarea>
                                    <label for="d100">Fecha</label>
                                    <input type="date" id="d100" name="d100" class="form-control" readonly>
                                    <label for="h100">Hora</label>
                                    <input type="time" min="00:00" max="23:59" pattern="[0-2][0-9]:[0-5][0-9]" class="form-select" name="h100" id="h100" disabled>
                                    <label for="hs10">Tiempo del evento</label>
                                    <select id="hs10" name="hs10" class="form-select" disabled>
                                        <option value="30">30 minutos</option>
                                        <option value="60">1 hora</option>
                                        <option value="90">1 hora 30 minutos</option>
                                        <option value="120">2 horas</option>
                                        <option value="150">2 horas 30 minutos</option>
                                        <option value="180">3 horas</option>
                                        <option value="210">3 horas 30 minutos</option>
                                        <option value="240">4 horas</option>
                                    </select>
                            </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="button" class="btn btn-success" id="modificarBtn2">Modificar</button>
                                    <button type="button" class="btn btn-danger" id="eleminarBtnModa" onclick="eliminarDatos(document.getElementById('idE0').value)">Eliminar</button>
                                </div>    
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

   


<script>
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

    function abrirModal(ideagendas) {
        fetch('eventosAgenda.php', {
            method: 'POST',
            body: new URLSearchParams({
                action: 'obtenerDatos2',
                ideagendas: ideagendas
            }),
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
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
            var modal = new bootstrap.Modal(document.getElementById('exampleModal3'));
            modal.show();
        })
        .catch(error => console.error('Error al obtener los datos del evento:', error));
    }
</script>
<script src="dist/bundle.js"></script>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    $(document).ready(function() {
        // Inicializar Select2 para s1
        var select2Instance1 = $('#s1').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder')
        });

        // Manejar el cambio de valor en Select2 para s1
        $('#s1').on('change', function() {
            var valorSeleccionado = $(this).val();
            cargarSegundoSelect(valorSeleccionado, '#s11');
            $('#s11').prop('disabled', false); 
        });

        // Inicializar Select2 para s11
        var select2Instance2 = $('#s11').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder')
        });
        $('#s11').prop('disabled', true);

        // Manejar el cambio de valor en Select2 para s11
        $('#s11').on('change', function() {
            var valorSeleccionado = $(this).val();
            cargarSegundoSelect(valorSeleccionado, '#s12');
            $('#s12').prop('disabled', false); 
        });

        var select2Instance3 = $('#s12').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: "Seleccione",
            multiple: true
        });
        $('#s12').prop('disabled', true); 

        // Manejar el cambio de valor en Select2 para s12
        $('#s12').on('change', function() {
            var valorSeleccionado = $(this).val();
        });

        // Cargar las opciones del segundo select basado en el valor seleccionado
        function cargarSegundoSelect(valorSeleccionado, selectId) {
            var url = '';
            if (selectId === '#s11') {
            url = 'llenarExp.php?id_tipo_expediente=' + valorSeleccionado;
            } else if (selectId === '#s12') {
            var idTipoExpediente = $('#s1').val();
            url = 'llenarExp2.php?id=' + valorSeleccionado + '&id_tipo_expediente=' + idTipoExpediente;
            }

            fetch(url)
            .then(response => response.text())
            .then(data => {
                $(selectId).html(data);
            })
            .catch(error => {
                console.error('Error al cargar las opciones:', error);
            });
        }

        var select2Instance4 = $('#s3').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder')
        });

        var select2Instance5 = $('#juez').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder')
        });
        
        var select2Instance6 = $('#s300').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder')
        });

        var select2Instance7 = $('#juez10').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder')
        });

        // Reiniciar Select2 cuando se presiona el botón "Limpiar Formulario"
        $('button[type="reset"]').on('click', function() {
            select2Instance1.val(null).trigger('change');
            select2Instance2.val(null).trigger('change');
            select2Instance3.val(null).trigger('change');
            select2Instance4.val(null).trigger('change');
            select2Instance5.val(null).trigger('change');
            $('#s11').prop('disabled', true); 
            $('#s12').prop('disabled', true); 
        });

        // Reiniciar Select2 cuando se cierra el modal
        $('#exampleModal').on('hidden.bs.modal', function() {
            select2Instance1.val(null).trigger('change');
            select2Instance2.val(null).trigger('change');
            select2Instance3.val(null).trigger('change');
            select2Instance4.val(null).trigger('change');
            select2Instance5.val(null).trigger('change');
            $('#s11').prop('disabled', true); 
            $('#s12').prop('disabled', true);
        });
    });
</script>
<script>
    flatpickr("#h1", {
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
    time_24hr: true
    });

    flatpickr("#h10", {
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
    time_24hr: true
    });

    flatpickr("#h100", {
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
    time_24hr: true,
    });
    
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Obtener la fecha actual
        var today = new Date();
        
        // Formatear la fecha como YYYY-MM-DD
        var date = today.getFullYear() + '-' + String(today.getMonth() + 1).padStart(2, '0') + '-' + String(today.getDate()).padStart(2, '0');
        
        // Formatear la hora como HH:MM
        var time = String(today.getHours()).padStart(2, '0') + ":" + String(today.getMinutes()).padStart(2, '0');
        
        // Establecer los valores predeterminados
        document.getElementById('d1').value = date;
        document.getElementById('h1').value = time;
    });
</script>


</body>

</html>