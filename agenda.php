<?php
require_once 'funcionesSql.php';
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
    crossorigin="anonymous"></script> 
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    


<!--LLAMADA A INSERTAR DATOS-->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var form = document.querySelector("form");
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
                swal("Evento Insertado con Éxito", "CONTINUAR", "success")
                .then(() => {
                    location.reload();
                });
            } else {
                swal("Error", data, "error");
            }
            })
            .catch(error => {
            console.error("Error en la solicitud Fetch: " + error.message);
            swal("Error", "Hubo un error en la solicitud", "error");
            });
        });
   });
</script>


<!--LLAMADA A MODIFICAR DATOS-->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var modificarForm = document.getElementById("modificarFormulario");
        var modificarForm2 = document.getElementById("modificarFormulario2");

        modificarForm.addEventListener("submit", function(event) {
            event.preventDefault();
            var formData = new FormData(modificarForm);
            enviarFormulario(formData);
        });

        if (modificarForm2) {
            modificarForm2.addEventListener("submit", function(event) {
                event.preventDefault();
                var formData = new FormData(modificarForm2);
                enviarFormulario(formData);
            });
        }

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
                    swal("Evento Modificado con Éxito", "CONTINUAR", "success")
                    .then(() => {
                        location.reload();
                    });
                } else if (data.trim() === "Evento modificado correctamente.") {
                    // Si la respuesta contiene el mensaje de éxito esperado
                    swal("Evento Modificado con Éxito", "CONTINUAR", "success")
                    .then(() => {
                        location.reload();
                    });
                } else {
                    swal("Error", data, "error");
                }
            })
            .catch(error => {
                console.error("Error en la solicitud Fetch: " + error.message);
                swal("Error", "Hubo un error en la solicitud", "error");
            });
        }
    });
</script>

<!--LLAMADA A ELIMINAR DATOS-->
<script>
    function eliminarDatos(id_evento_agenda) {
    swal({
        title: "¿Estás seguro?",
        text: "Esta acción eliminará permanentemente el evento",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
        fetch('eliminar_evento.php?id_evento_agenda=' + id_evento_agenda)
            .then(response => response.text())
            .then(data => {
            swal("¡Eliminado!", "El evento ha sido eliminado correctamente.", "success")
                .then(() => {
                window.location.reload();
                });
            })
            .catch(error => {
            swal("Error", "Hubo un problema al eliminar el evento", "error");
            console.error(error);
            });
        } else {
        swal("Cancelado", "La eliminación del evento ha sido cancelada", "info");
        }
    });
    }
</script>

<!--LLAMADA A LLENAR FORM TABLA3-->
<script>
   document.addEventListener('DOMContentLoaded', function () {
        var modificarDatosBtns = document.querySelectorAll('.modificarDatosBtn');
        var modal = document.getElementById('exampleModal2');
        var form = modal.querySelector('form');

        modificarDatosBtns.forEach(function (btn) {
            btn.addEventListener('click', function () {
                var idEvento = this.getAttribute('data-id');
                console.log('ID del evento:', idEvento);

                fetch('llenarform.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'id_evento_agenda=' + encodeURIComponent(idEvento),
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Datos del evento recibidos:', data);
                    if (data && !data.error) {
                        form.querySelector('#idE').value = data.id_evento_agenda;
                        form.querySelector('#s10').value = data.nom_expediente;
                        form.querySelector('#s110').value = data.numero;

                        var id_inputado = data.idInputado;
                        var nombre_inputado = data.nombreInputado;
                        var option = document.createElement('option');
                        option.value = id_inputado;
                        option.textContent = nombre_inputado;
                        form.querySelector('#s120').innerHTML = '';
                        form.querySelector('#s120').appendChild(option);

                     
                        var optionGuardada = document.createElement('option');
                        optionGuardada.value = data.id_tipo_audiencia;
                        optionGuardada.textContent = data.nom_tipo_audiencia;
                        optionGuardada.selected = true;
                        form.querySelector('#s30').appendChild(optionGuardada);

                        var optionGuardada2 = document.createElement('option');
                        optionGuardada2.value = data.id_sala;
                        optionGuardada2.textContent = data.nombre_sala;
                        optionGuardada2.selected = true;
                        form.querySelector('#sala1').appendChild(optionGuardada2);

                        var optionGuardada3 = document.createElement('option');
                        optionGuardada3.value = data.id_juez;
                        optionGuardada3.textContent = data.nom_juez;
                        optionGuardada3.selected = true;
                        form.querySelector('#juez1').appendChild(optionGuardada3);

                        var optionGuardada4 = document.createElement('option');
                        optionGuardada4.value = data.idSolicitante;
                        optionGuardada4.textContent = data.TipoSolicitante;
                        optionGuardada4.selected = true;
                        form.querySelector('#sol11').appendChild(optionGuardada4);

                        form.querySelector('#d10').value = data.fecha;
                        form.querySelector('#h10').value = data.hora;
                        form.querySelector('#evento1').value = data.evento;
                    } else {
                        console.error('Error al obtener los datos del evento:', data.error);
                    }
                })
                .catch(error => {
                    console.error('Error al obtener los datos del evento:', error);
                });
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Escuchar el evento 'shown.bs.modal' para el modal 'exampleModal2'
        document.getElementById('exampleModal2').addEventListener('shown.bs.modal', function () {
            var modificarBtn = document.getElementById("modificarBtn");
            var modalFooter = document.querySelector("#exampleModal2 .modal-footer");
            var inputs = document.querySelectorAll("#exampleModal2 input");

            // Agregar evento al botón "Modificar"
            modificarBtn.addEventListener("click", function () {
                // Habilitar la edición de los campos de entrada
                for (var i = 0; i < inputs.length; i++) {
                    inputs[i].readOnly = false;
                }

                // Crear botón "Cancelar"
                var cancelarBtn = document.createElement("button");
                cancelarBtn.setAttribute("type", "button");
                cancelarBtn.setAttribute("class", "btn btn-secondary");
                cancelarBtn.textContent = "Cancelar";
                cancelarBtn.addEventListener("click", function () {
                    // Restaurar los campos de entrada a solo lectura
                    for (var i = 0; i < inputs.length; i++) {
                        inputs[i].readOnly = true;
                    }

                    // Restaurar el botón "Modificar"
                    modificarBtn.style.display = "inline-block";

                    // Eliminar el botón "Cancelar" y "Confirmar"
                    modalFooter.removeChild(cancelarBtn);
                    modalFooter.removeChild(confirmarBtn);
                });

                // Crear botón "Confirmar"
                var confirmarBtn = document.createElement("button");
                confirmarBtn.setAttribute("type", "submit");
                confirmarBtn.setAttribute("class", "btn btn-danger");
                confirmarBtn.textContent = "Confirmar";
                confirmarBtn.addEventListener("click", function () {
                    // Este es el lugar donde podrías agregar la lógica para confirmar
                    // Por ahora, no haremos nada al hacer clic en "Confirmar"
                });

                // Agregar botones "Cancelar" y "Confirmar" al pie de página del modal
                modalFooter.appendChild(cancelarBtn);
                modalFooter.appendChild(confirmarBtn);

                // Ocultar el botón "Modificar"
                modificarBtn.style.display = "none";
            });
        });
    });
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

                // Agregar los botones iniciales
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

<title>AGENDA V1</title>
</head>

<body>
    <div class="container-fluid">
        <div class="navbar ">
            <div class="container-fluid justify-content-start">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-secondary" onclick="cambiarVentanas('calendar')">MES</button>
                    <button type="button" class="btn btn-secondary" onclick="cambiarVentanas('tabla2')">DIA</button>
                    <button typr="button" class="btn btn-secondary" onclick="cambiarVentanas('tabla3')">EVENTO</button>
                </div>
            </div>

        </div>
        <div class="row-3";>
            <div class="col-10">
                <div id="calendar" class="d-none">
                </div>
                <div id="tabla2">
                    <div class="navbar">
                        <div class="container">
                            <h2 id="fechaHeader" class="i" style="font-size:27px;"></h2>
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
                        <div class="text-center">
                            <div class="spinner-border" role="status" id="spinner">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <div class="navbar initial-hidden" id="n0">
                            <div class="container">
                                <P>SALAS TEPIC</P>
                                <H5>S1</H5>
                                <i class="bi bi-circle-fill" style="color: yellow;"></i>
                                <H5>S2</H5>
                                <i class="bi bi-circle-fill" style="color: red;"></i>
                                <H5>S3</H5>
                                <i class="bi bi-circle-fill" style="color: blue;"></i>
                                <H5>S4</H5>
                                <i class="bi bi-circle-fill" style="color: green;"></i>
                                <H5>S5</H5>
                                <i class="bi bi-circle-fill" style="color:pink;"></i>
                                <H5>SV 1</H5>
                                <i class="bi bi-circle-fill" style="color:blueviolet;"></i>
                                <H5>SV 2</H5>
                                <i class="bi bi-circle-fill" style="color:deepskyblue;"></i>
                                <H5>SV 3</H5>
                                <i class="bi bi-circle-fill" style="color:gray;"></i>
                                <H5>SV 4</H5>
                                <i class="bi bi-circle-fill" style="color:purple;"></i>
                                <H5>SV 16</H5>
                                <i class="bi bi-circle-fill" style="color:aquamarine;"></i>
                                <H5>SV 17</H5>
                                <i class="bi bi-circle-fill" style="color:chartreuse;"></i>
                                <H5>SV 18</H5>
                                <i class="bi bi-circle-fill" style="color:darkblue;"></i>
                                <H5>SV 19</H5>
                                <i class="bi bi-circle-fill" style="color:darkcyan;"></i>
                            </div>
                        </div>
                        <div class="navbar initial-hidden" id="n1">
                            <div class="container">
                                <p>SALAS ADOLECENTES</p>
                                <H5>SALA ADOLECENTES</H5>
                                <i class="bi bi-circle-fill" style="color: yellow;"></i>
                                <H5>SALAV 5 ADOLECENTES</H5>
                                <i class="bi bi-circle-fill" style="color: red;"></i>
                                <H5>SALAV 15 ADOLECENTES</H5>
                                <i class="bi bi-circle-fill" style="color: blue;"></i>
                            </div>
                        </div>
                        <div class="navbar initial-hidden" id="n2">
                            <div class="container">
                                <P>SALAS BAHIA</P>
                                <H5>S1 BAHIA</H5>
                                <i class="bi bi-circle-fill" style="color: yellow;"></i>
                                <H5>S2 BAHIA</H5>
                                <i class="bi bi-circle-fill" style="color: red;"></i>
                                <H5>S10 BAHIA</H5>
                                <i class="bi bi-circle-fill" style="color: blue;"></i>
                                <H5>SV11 BAHIA</H5>
                                <i class="bi bi-circle-fill" style="color: green;"></i>
                                <H5>SV CJM BAHIA</H5>
                                <i class="bi bi-circle-fill" style="color: coral;"></i>
                                <H5>SV14 CJM BAHIA</H5>
                                <i class="bi bi-circle-fill" style="color: cyan;"></i>
                            </div>
                        </div>
                        <div class="navbar initial-hidden" id="n3">
                            <div class="container">
                                <P>SALAS CJM</P>
                                <H5>SALA DE MUJER TEPIC</H5>
                                <i class="bi bi-circle-fill" style="color: yellow;"></i>
                                <H5>SV13 CJM TEPIC</H5>
                                <i class="bi bi-circle-fill" style="color: red;"></i>
                                <H5>SALA EJECUCION</H5>
                                <i class="bi bi-circle-fill" style="color: blue;"></i>
                                <H5>SV20 CJM TEPIC</H5>
                                <i class="bi bi-circle-fill" style="color: green;"></i>
                            </div>
                        </div>
                        <div class="navbar initial-hidden" id="n4">
                            <div class="container">
                                <P>SALAS SANTIAGO</P>
                                <H5>SV6 SANTIAGO</H5>
                                <i class="bi bi-circle-fill" style="color: yellow;"></i>
                                <H5>SV12 SANITAGO</H5>
                                <i class="bi bi-circle-fill" style="color: blue;"></i>
                                <H5>SALA SANTIAGO</H5>
                                <i class="bi bi-circle-fill" style="color: red;"></i>
                            </div>
                        </div>
                        <div class="navbar initial-hidden" id="n5">
                            <div class="container">
                                <P>SALAS IXTLAN</P>
                                <H5>SALA VIRTUAL 8 IXTLAN</H5>
                                <i class="bi bi-circle-fill" style="color: yellow;"></i>
                                <H5>SALA IXTLAN</H5>
                                <i class="bi bi-circle-fill" style="color: red;"></i>
                            </div>
                        </div>
                        <div class="navbar initial-hidden" id="n6">
                            <div class="container">
                                <P>SALAS TECUALA</P>
                                <H5>SALA VIRTUAL 7 TECUALA</H5>
                                <i class="bi bi-circle-fill" style="color: yellow;"></i>
                                <H5>SALA TECUALA</H5>
                                <i class="bi bi-circle-fill" style="color: red;"></i>
                            </div>
                        </div>
                        <div class="navbar initial-hidden" id="n7">
                            <div class="container">
                                <P>SALAS SAN PEDRO</P>
                                <H5>SALA VIRTUAL 8 SAN PEDRO</H5>
                                <i class="bi bi-circle-fill" style="color: yellow;"></i>
                                <H5>SALA SAN PEDRO</H5>
                                <i class="bi bi-circle-fill" style="color: red;"></i>
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
                    <div>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Agregar Evento
                    </button>
                </div>
                </div>
                <div id="tabla3" class="d-none">
                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Exp</th>
                                <th scope="col">Numero</th>
                                <th scope="col">Involucrado</th>
                                <th scope="col">Audiencia</th>
                                <th scope="col">Sala</th>
                                <th scope="col">Juez</th>
                                <th scope="col">Solicitante</th>
                                <th scope="col">Hora</th>
                                <th scope="col">fecha</th>
                                <th scope="col">Evento</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <TBody>
                                <?php $result=obtenerDatos()?>
                                    <?php if ($result->num_rows > 0) { ?>
                                        <?php while ($row = $result->fetch_assoc()) { ?>
                                            <tr>
                                                <td><?php echo $row["id_evento_agenda"]?></td>
                                                <td><?php echo $row["nom_expediente"]?></td>
                                                <td><?php echo $row["numero"]?> </td>
                                                <td><?php echo $row["nombreInputado"]?> </td>
                                                <td><?php echo $row["nom_tipo_audiencia"]?> </td>
                                                <td><?php echo $row["nombre_sala"]?> </td>
                                                <td><?php echo $row["nom_juez"]?> </td>
                                                <td><?php echo $row["Solicitante"]?> </td>
                                                <td><?php echo $row["fecha"]?> </td>
                                                <?php $horaFormato12 = date("h:i A", strtotime($row["hora"]))?>
                                                <td><?php echo $horaFormato12 ?></td>
                                                <td><?php echo $row["evento"]?></td>
                                                        <td>                                                  
                                                            <button type='button' id='eliminarDatos' class='btn btn-outline-dark' onclick='eliminarDatos(<?php echo $row["id_evento_agenda"]; ?>)'><i class='bi bi-trash3' style='color:red'></i></button></div>          
                                                            <button type='button' id='modificarDatos' class='btn btn-outline-dark modificarDatosBtn' data-bs-toggle="modal" data-bs-target="#exampleModal2" data-id="<?php echo $row["id_evento_agenda"]; ?>">
                                                                <i class="bi bi-arrow-repeat" style='color:blue'></i>
                                                            </button>                                                                  
                                                        </td>
                                                    <?php } ?>
                                            </tr>
                                                <?php } else { ?>
                                                    <tr>
                                                        <td colspan="5" class="text-center">No se encontraron resultados</td>
                                                    </tr>
                                                <?php } ?>
                        </TBody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div id="myModal">
                    <div class="modal fade" id="exampleModal" aria-labelledby="exampleModalLabel" aria-modal="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">AGREGAR EVENTO</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="insertarEvento.php" method="post" id="insertaForm" name="insertaForm">
                                    <div class="modal-body row">
                                        <div class="col-md-6">
                                            <!-- Campos de la sección izquierda -->
                                            <label for="s1">Expediente</label>
                                            <select class="form-select" name="s1" id="s1" required>
                                                <option value="" selected disabled>Selecciona un tipo de expediente</option>
                                                <?php
                                                $exp = expediente();
                                                foreach ($exp as $exp1) {
                                                    echo "<option value='" . $exp1["id_tipo_expediente"] . "'>" . $exp1["nom_expediente"] . "</option>";
                                                }
                                                ?>
                                            </select>
                                            <label for="s11">Numero</label>
                                            <select class="form-select" name="s11" id="s11" required>
                                                <option value="" selected disabled>Seleccione</option>
                                            </select>
                                            <div class="form-text" id="basic-addon4">Seleccione un tipo de expediente para habilitar</div>
                                            <label for="s12">Imputado</label>
                                            <select class="form-select" name="s12" id="s12"  required>
                                                <option value="" selected disabled>Seleccione</option>
                                            </select>
                                            <div class="form-text" id="basic-addon4">Seleccione un numero para habilitar</div>
                                            <label for="sol1">Solicitante</label>
                                            <select name="sol1" id="sol1" class="form-select" required>
                                                <option value="" selected disabled>Seleccione un Tipo de Solicitante</option>
                                                <?php
                                                $solicitante = solicitante();
                                                foreach ($solicitante as $sol) {
                                                    echo "<option value='" . $sol["idSolicitante"] . "'>" . $sol["TipoSolicitante"] . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                        <label for="s3">Tipo Audiencia</label>
                                            <select name="s3" id="s3" class="form-select" required>
                                                <option value="" selected disabled>Selecciona una audiencia</option>
                                                <?php
                                                $audiencia = audiencias();
                                                foreach ($audiencia as $audi) {
                                                    echo "<option value='" . $audi["id_tipo_audiencia"] . "'>" . $audi["nom_tipo_audiencia"] . "</option>";
                                                }
                                                ?>
                                            </select>
                                            <label for="sala">Sala</label>
                                            <select name="sala" id="sala" class="form-select" required>
                                                <option value="" selected disabled>Selecciona una sala</option>
                                                <?php
                                                $salas = sala();
                                                foreach ($salas as $sal) {
                                                    echo "<option value='" . $sal["id_sala"] . "'>" . $sal["nombre_sala"] . "</option>";
                                                }
                                                ?>
                                            </select>
                                            <label for="juez">Juez</label>
                                            <select name="juez" id="juez" class="form-select" required>
                                                <option value="" selected disabled>Seleccione un juez</option>
                                                <?php
                                                $jueces = juez();
                                                foreach ($jueces as $juez) {
                                                    echo "<option value='" . $juez["id_juez"] . "'>" . $juez["nom_juez"] . "</option>";
                                                }
                                                ?>
                                            </select>
                                            <label for="d1">Fecha</label>
                                            <input type="date" id="d1" name="d1" class="form-control" required>
                                            <label for="h1">Hora</label>
                                            <input type="time" pattern="[0-9]{2}:[0-9]{2}" step="1" class="form-select" name="h1" id="h1" required>
                                            <label for="evento">Nombre Evento</label>
                                            <input id="evento" name="evento" type="text" required class="form-control">
                                        </div>
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

            <div id="myModal2" >
                <div class="modal fade" id="exampleModal2" aria-labelledby="exampleModalLabel">
                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">EVENTO</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="modificar_evento.php" method="post" id="modificarFormulario">                
                                <div class="modal-body row">
                                    <div class="col-md-6">
                                        <input type="hidden" id="modal1" name="modal" value="1">
                                        <input type="hidden" class="form-control" name="idE" id="idE">
                                        <label for="s10">Expediente</label>
                                        <input type="text" class="form-control" name="s10" id="s10" disabled>
                                        <label for="s110">Numero</label>
                                        <input type="text" class="form-control" name="s110" id="s110" disabled>                      
                                        <label for="s120">Imputado</label>
                                        <select  class="form-select" name="s120" id="s120" disabled>
                                        <option value="" selected disabled>Seleccione</option>
                                        </select>
                                        <label for="sol11">Solicitante</label>
                                        <select name="sol11" id="sol11" class="form-select" required>
                                        <option value="" selected disabled>Seleccione un Tipo de Solicitante</option>
                                            <?php
                                                $solicitante = solicitante();
                                                foreach ($solicitante as $sol) {
                                                    echo "<option value='". $sol["idSolicitante"] . "'>" . $sol["TipoSolicitante"] . "</option>";
                                                }
                                            ?>
                                        </select>
                                        <label for="s30">Tipo Audiencia</label>
                                        <select name="s30" id="s30" class="form-select" readonly>
                                        <option value="" selected disabled>Seleccione</option>
                                        <?php
                                                $audiencia = audiencias();
                                                foreach ($audiencia as $aud) {
                                                    echo "<option value='" . $aud["id_tipo_audiencia"] . "'>" . $aud["nom_tipo_audiencia"] . "</option>";
                                                }
                                        ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="sala1">Sala</label>
                                        <select name="sala1" id="sala1" class="form-select" readonly>
                                        <option value="" selected disabled>Seleccione</option>
                                        <?php
                                                $salas = sala();
                                                foreach ($salas as $sal) {
                                                    echo "<option value='" . $sal["id_sala"] . "'>" . $sal["nombre_sala"] . "</option>";
                                                }
                                        ?>
                                        </select>
                                        <label for="juez1">Juez</label>
                                        <select name="juez1" id="juez1" class="form-select" readonly>
                                        <option value="" selected disabled>Seleccione</option>
                                        <?php
                                                $jueces = juez();
                                                foreach ($jueces as $juec) {
                                                    echo "<option value='" . $juec["id_juez"] . "'>" . $juec["nom_juez"] . "</option>";
                                                }
                                            ?>
                                        </select>
                                        <label for="d10">Fecha</label>
                                        <input type="date" id="d10" name="d10" class="form-control" readonly>
                                        <label for="h10">Hora</label>
                                        <input type="text" class="form-select"name="h10" id="h10" required readonly>
                                        <label for="evento1">Nombre Evento</label>
                                        <input id="evento1" name="evento1" type="text" required class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="button" class="btn btn-success" id="modificarBtn">Modificar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div id="myModal3" >
                <div class="modal fade" id="exampleModal3" aria-labelledby="exampleModalLabel">
                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">EVENTO</h5>

                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="modificar_evento.php" method="post" id="modificarFormulario2">
                                <div class="modal-body row">
                                    <div class="col-md-6">
                                        <input type="hidden" id="modal2" name="modal" value="2">
                                        <input type="hidden" class="form-control" name="idE0" id="idE0">
                                        <label for="s100">Expediente</label>
                                        <input type="text" class="form-control" name="s100" id="s100" disabled>
                                        <label for="s1100">Numero</label>
                                        <input type="text" class="form-control" name="s1100" id="s1100" disabled>                      
                                        <label for="s1200">Imputado</label>
                                        <select  class="form-select" name="s1200" id="s1200" disabled>
                                        <option value="" selected disabled>Seleccione</option>
                                        </select>
                                        <label for="s300">Tipo Audiencia</label>
                                        <select name="s300" id="s300" class="form-select" disabled>
                                        <option value="" selected disabled>Seleccione</option>
                                        <?php
                                                $audiencia = audiencias();
                                                foreach ($audiencia as $aud) {
                                                    echo "<option value='" . $aud["id_tipo_audiencia"] . "'>" . $aud["nom_tipo_audiencia"] . "</option>";
                                                }
                                        ?>
                                        </select>
                                        <label for="sala10">Sala</label>
                                        <select name="sala10" id="sala10" class="form-select" disabled>
                                        <option value="" selected disabled>Seleccione</option>
                                        <?php
                                                $salas = sala();
                                                foreach ($salas as $sal) {
                                                    echo "<option value='" . $sal["id_sala"] . "'>" . $sal["nombre_sala"] . "</option>";
                                                }
                                        ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="juez10">Juez</label>
                                        <select name="juez10" id="juez10" class="form-select" disabled>
                                        <option value="" selected disabled>Seleccione</option>
                                        <?php
                                                $jueces = juez();
                                                foreach ($jueces as $jue) {
                                                    echo "<option value='" . $jue["id_juez"] . "'>" . $jue["nom_juez"] . "</option>";
                                                }
                                            ?>
                                        </select>
                                        <label for="sol111">Solicitante</label>
                                        <select name="sol111" id="sol111" class="form-select" disabled required>
                                        <option value="" selected disabled>Seleccione un Tipo de Solicitante</option>
                                            <?php
                                                $solicitante = solicitante();
                                                foreach ($solicitante as $sol) {
                                                    echo "<option value='". $sol["idSolicitante"] . "'>" . $sol["TipoSolicitante"] . "</option>";
                                                }
                                            ?>
                                        </select>
                                        <label for="d100">Fecha</label>
                                        <input type="date" id="d100" name="d100" class="form-control" readonly>
                                        <label for="h100">Hora</label>
                                        <input type="time" min="00:00" max="23:59" pattern="[0-2][0-9]:[0-5][0-9]" class="form-select" name="h100" id="h100" disabled>
                                        <label for="evento10">Nombre Evento</label>
                                        <input id="evento10" name="evento10" type="text" required class="form-control" readonly>
                                    </div>
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
        function abrirModal(id_evento_agenda) {
        fetch('eventosAgenda.php', {
            method: 'POST',
            body: new URLSearchParams({
                action: 'obtenerDatos2',
                id_evento_agenda: id_evento_agenda
            }),
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('Datos del evento recibidos:', data);
            document.getElementById('idE0').value = data.id_evento_agenda;
            document.getElementById('s100').value = data.nom_expediente;
            document.getElementById('s1100').value = data.numero;

            
            var id_involucrado = data.idInputado;
            var nombre_inputado = data.nombreInputado;
            var option = document.createElement('option');
            option.value = id_involucrado;
            option.textContent = nombre_inputado;
            document.getElementById('s1200').innerHTML = ''; 
            document.getElementById('s1200').appendChild(option);
        

            var optionGuardada = document.createElement('option');
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
                    document.getElementById('s300').appendChild(option);
                });
            } 

            var optionGuardada2 = document.createElement('option');
            optionGuardada2.value = data.id_sala; 
            optionGuardada2.textContent = data.nombre_sala; 
            optionGuardada2.selected = true; 
            document.getElementById('sala10').appendChild(optionGuardada2);

            // Verificar si nom_tipo_audiencia es un arreglo
            if (Array.isArray(data.nombre_sala)) {
                // Iterar sobre cada tipo de audiencia en el arreglo
                data.nombre_sala.forEach(function(sala) {
                    // Crear una opción para cada tipo de audiencia
                    var option = document.createElement('option');
                    option.value = sala.id_sala;
                    option.textContent = sala.nom_tipo_audiencia;
                    document.getElementById('sala10').appendChild(option);
                });
            } 

            
            var optionGuardada3 = document.createElement('option');
            optionGuardada3.value = data.id_juez; 
            optionGuardada3.textContent = data.nom_juez; 
            optionGuardada3.selected = true; 
            document.getElementById('juez10').appendChild(optionGuardada3);

            // Verificar si nom_tipo_audiencia es un arreglo
            if (Array.isArray(data.nom_juez)) {
                data.nom_juez.forEach(function(juez) {
                    var option = document.createElement('option');
                    option.value = juez.id_juez;
                    option.textContent = juez.nom_juez;
                    // Agregar la opción al select
                    document.getElementById('juez10').appendChild(option);
                });
            } 

            var optionGuardada4 = document.createElement('option');
            optionGuardada4.value = data.idSolicitante;
            optionGuardada4.textContent = data.TipoSolicitante;
            optionGuardada4.selected = true;
            document.getElementById('sol111').appendChild(optionGuardada4); 

            if (Array.isArray(data.TipoSolicitante)) {
                data.TipoSolicitante.forEach(function(solicitante) {
                    var option = document.createElement('option');
                    option.value = solicitante.idSolicitante;
                    option.textContent = solicitante.TipoSolicitante;
                    // Agregar la opción al select
                    document.getElementById('sol111').appendChild(option);
                });
            } 

            document.getElementById('d100').value = data.fecha;
            document.getElementById('h100').value = data.hora;
            document.getElementById('evento10').value = data.evento;
            


            var modal = new bootstrap.Modal(document.getElementById('exampleModal3'));
            modal.show();
        })
        .catch(error => console.error('Error al obtener los datos del evento:', error));
    }
</script>
<script src="dist/bundle.js"></script>
<script src="funciones.js"></script>
<script src="salas.js"></script>
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
            placeholder: $(this).data('placeholder')
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
            url = 'llenarExp2.php?valor1=' + valorSeleccionado;
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

        // Reiniciar Select2 cuando se presiona el botón "Limpiar Formulario"
        $('button[type="reset"]').on('click', function() {
            select2Instance1.val(null).trigger('change');
            select2Instance2.val(null).trigger('change');
            select2Instance3.val(null).trigger('change');
            $('#s11').prop('disabled', true); 
            $('#s12').prop('disabled', true); 
        });

        // Reiniciar Select2 cuando se cierra el modal
        $('#exampleModal').on('hidden.bs.modal', function() {
            select2Instance1.val(null).trigger('change');
            select2Instance2.val(null).trigger('change');
            select2Instance3.val(null).trigger('change');
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
</body>

</html>