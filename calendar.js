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
    themeSystem : 'bootstrap5',
    eventColor : '#009846',
    plugins: [bootstrap5Plugin ,dayGridPlugin, interactionPlugin],
    dateClick: function(info) {
        const fechaSeleccionada = info.dateStr;
        
        // Obtenemos los datos del usuario
        fetch('juezRel.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('La respuesta de la red no fue ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Datos del usuario:', data); // Para depuración

                const tipoUsuario = data.tipo;
                const relacionadoConJuez = data.relacionadoConJuez;

                console.log('Tipo de usuario:', tipoUsuario); // Para depuración
                console.log('Relacionado con juez:', relacionadoConJuez); // Para depuración

                // Aplicamos la misma condición que para el botón
                if ((tipoUsuario === 'scausa' || tipoUsuario === 'admin') && relacionadoConJuez) {
                    console.log('Usuario no autorizado para agregar eventos');
                    // Aquí puedes mostrar un mensaje al usuario si lo deseas
                    // Por ejemplo: alert('No tienes permisos para agregar eventos');
                } else {
                    console.log('Usuario autorizado para agregar eventos');
                    fechaEventoInput.value = fechaSeleccionada;
                    modal1.show();
                }
            })
            .catch(error => {
                console.error('Error al obtener los datos del usuario:', error);
            });
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
                
                let id_involucrado = data.idInputado;
                let nombre_inputado = data.nombreInputado;
                let option = document.createElement('option');
                option.value = id_involucrado;
                option.textContent = nombre_inputado;
                document.getElementById('s1200').innerHTML = ''; 
                document.getElementById('s1200').appendChild(option);
            
                // TIPO DE AUDIENCIA
                let select1 = document.getElementById('s300');
                let optionGuardada = document.createElement('option');
                optionGuardada.value = data.id_tipo_audiencia;
                optionGuardada.textContent = data.nom_tipo_audiencia;
                optionGuardada.selected = true;
                let existingOption1 = select1.querySelector(`option[value="${data.id_tipo_audiencia}"]`);
                if (existingOption1) {
                    select1.replaceChild(optionGuardada, existingOption1);
                } else {
                    select1.appendChild(optionGuardada);
                }
                if (Array.isArray(data.nom_tipo_audiencia)) {
                    data.nom_tipo_audiencia.forEach(function(audiencia) {
                        if (audiencia.id_tipo_audiencia !== data.id_tipo_audiencia) {
                            let option = select1.querySelector(`option[value="${audiencia.id_tipo_audiencia}"]`);
                            if (option) {
                                option.textContent = audiencia.nom_tipo_audiencia;
                            } else {
                                option = document.createElement('option');
                                option.value = audiencia.id_tipo_audiencia;
                                option.textContent = audiencia.nom_tipo_audiencia;
                                select1.appendChild(option);
                            }
                        }
                    });
                }

                // SALA
                let select2 = document.getElementById('sala10');
                let optionGuardada2 = document.createElement('option');
                optionGuardada2.value = data.id_sala;
                optionGuardada2.textContent = data.nombre_sala;
                optionGuardada2.selected = true;
                let existingOption2 = select2.querySelector(`option[value="${data.id_sala}"]`);
                if (existingOption2) {
                    select2.replaceChild(optionGuardada2, existingOption2);
                } else {
                    select2.appendChild(optionGuardada2);
                }
                if (Array.isArray(data.nombre_sala)) {
                    data.nombre_sala.forEach(function(sala) {
                        if (sala.id_sala !== data.id_sala) {
                            let option = select2.querySelector(`option[value="${sala.id_sala}"]`);
                            if (option) {
                                option.textContent = sala.nombre_sala;
                            } else {
                                option = document.createElement('option');
                                option.value = sala.id_sala;
                                option.textContent = sala.nombre_sala;
                                select2.appendChild(option);
                            }
                        }
                    });
                }

                // JUEZ
                let select3 = document.getElementById('juez10');
                let optionGuardada3 = document.createElement('option');
                optionGuardada3.value = data.id_juez;
                optionGuardada3.textContent = data.nom_juez;
                optionGuardada3.selected = true;
                let existingOption3 = select3.querySelector(`option[value="${data.id_juez}"]`);
                if (existingOption3) {
                    select3.replaceChild(optionGuardada3, existingOption3);
                } else {
                    select3.appendChild(optionGuardada3);
                }
                if (Array.isArray(data.nom_juez)) {
                    data.nom_juez.forEach(function(juez) {
                        if (juez.id_juez !== data.id_juez) {
                            let option = select3.querySelector(`option[value="${juez.id_juez}"]`);
                            if (option) {
                                option.textContent = juez.nom_juez;
                            } else {
                                option = document.createElement('option');
                                option.value = juez.id_juez;
                                option.textContent = juez.nom_juez;
                                select3.appendChild(option);
                            }
                        }
                    });
                }


                // SOLICITANTE 
                let select = document.getElementById('sol111');
                let optionGuardada4 = document.createElement('option');
                optionGuardada4.value = data.idSolicitante;
                optionGuardada4.textContent = data.Solicitante;
                optionGuardada4.selected = true;
                let existingOption = select.querySelector(`option[value="${data.idSolicitante}"]`);
                if (existingOption) {
                    select.replaceChild(optionGuardada4, existingOption);
                } else {
                    select.appendChild(optionGuardada4);
                }
                if (Array.isArray(data.Solicitante)) {
                    data.Solicitante.forEach(function(solicitante) {
                        if (solicitante.idSolicitante !== data.idSolicitante) {
                            let option = select.querySelector(`option[value="${solicitante.idSolicitante}"]`);
                            if (option) {
                                option.textContent = solicitante.Solicitante;
                            } else {
                                option = document.createElement('option');
                                option.value = solicitante.idSolicitante;
                                option.textContent = solicitante.Solicitante;
                                select.appendChild(option);
                            }
                        }
                    });
                }

                document.getElementById('d100').value = data.fecha;
                document.getElementById('h100').value = data.hora;


                
                modal3.show();
            })
            .catch(error => console.error('Error al obtener los datos del evento:', error));
    }
    });

window.calendar = calendar;
window.cambiarVentanas = cambiarVentanas; // Exportar la función cambiarVentanas a la ventana global

calendar.render();