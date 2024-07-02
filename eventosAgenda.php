<?php
require_once 'funcionesSql.php';
require_once 'sesion.php';

// Manejar la solicitud POST para obtener datos del evento
if(isset($_POST['action']) && $_POST['action'] === 'obtenerDatos2') {
    $id_evento_agenda = $_POST['id_evento_agenda'];
    $evento = obtenerDatos2($id_evento_agenda);
    echo json_encode($evento);
    exit; 
}

$usuario = $_SESSION['usuario'];
$usuarioRegion = obtenerRegionYJuzgadoUsuario($usuario);
$regionEA = $usuarioRegion["region"];
$tipoEA = $usuarioRegion["tipo"];

function generarTablaEventos($region, $tipo, $usuario) {
    $horas_fijas = array("08:00am", "09:00am", "10:00am", "11:00am", "12:00pm", "13:00pm", "14:00pm", "15:00pm", "16:00pm", "17:00pm", "18:00pm", "19:00pm", "20:00pm", "21:00pm", "22:00pm", "23:00pm", "00:00am", "01:00am", "02:00am", "03:00am", "04:00am", "05:00am", "06:00am", "07:00pm");
    $fechaCookie = $_COOKIE['fechaActual'];



    foreach ($horas_fijas as $hora) {
        // Obtener los eventos para esta hora
        $eventosAmarillo = obtenerDatos3($hora, [1, 14, 5, 31, 26, 25, 27, 11], $fechaCookie,$region, $tipo, $usuario);
        $eventosRojo = obtenerDatos3($hora, [2, 23, 33, 32, 7, 17, 8, 9, 15], $fechaCookie,$region, $tipo, $usuario);
        $eventosAzul = obtenerDatos3($hora, [3, 35, 18, 10, 29], $fechaCookie,$region, $tipo, $usuario);
        $eventosVerde = obtenerDatos3($hora, [12, 40, 30], $fechaCookie,$region, $tipo, $usuario);
        $eventosRosa = obtenerDatos3($hora, [13,16], $fechaCookie,$region, $tipo, $usuario);
        $eventosAV = obtenerDatos3($hora, [19, 4, 34], $fechaCookie,$region, $tipo, $usuario);
        $eventosAC = obtenerDatos3($hora, [20], $fechaCookie,$region, $tipo, $usuario);
        $eventosMorado = obtenerDatos3($hora, [22], $fechaCookie,$region, $tipo, $usuario);
        $eventosGris = obtenerDatos3($hora, [21], $fechaCookie,$region, $tipo, $usuario);
        $eventosAM = obtenerDatos3($hora, [23,36],  $fechaCookie,$region, $tipo, $usuario);
        $eventosCT = obtenerDatos3($hora, [37],  $fechaCookie,$region, $tipo, $usuario);
        $eventosAO = obtenerDatos3($hora, [38],  $fechaCookie,$region, $tipo, $usuario);
        $eventosVO = obtenerDatos3($hora, [39],  $fechaCookie,$region, $tipo, $usuario);
        $eventosV1 = obtenerDatos3($hora, [6],  $fechaCookie,$region, $tipo, $usuario);
        $eventosV2 = obtenerDatos3($hora, [42],  $fechaCookie,$region, $tipo, $usuario);
        $eventosV3 = obtenerDatos3($hora, [43],  $fechaCookie,$region, $tipo, $usuario);

        // Imprimir la fila de la tabla para esta hora
        echo "<tr>";
        echo "<th>$hora</th>";
        echo "<td>";

        // Verificar si hay eventos para esta hora
        $eventos = array_merge($eventosAmarillo, $eventosRojo, $eventosAzul, $eventosVerde, $eventosRosa, $eventosAV, $eventosAC, $eventosMorado, $eventosGris, $eventosAM, $eventosCT, $eventosAO, $eventosVO,  $eventosV1,  $eventosV2,  $eventosV3);
        if (!empty($eventos)) {
            // Mostrar las divisiones con eventos y colores de fondo dentro del td
            echo '<div class="container">';
            echo '<div class="row">';
            foreach ($eventos as $evento) {
                // Determinar el color en función de la sala
                $color = '';
                if (in_array($evento, $eventosAmarillo)) {
                    $color = 'yellow';
                } else if (in_array($evento, $eventosRojo)) {
                    $color = 'red';
                } else if (in_array($evento, $eventosAzul)) {
                    $color = 'lightskyblue';
                } else if (in_array($evento, $eventosVerde)) {
                    $color = 'greenyellow';
                } else if (in_array($evento, $eventosRosa)) {
                    $color = 'pink';
                } else if (in_array($evento, $eventosAV)) {
                    $color = 'blueviolet';
                } else if (in_array($evento, $eventosAC)) {
                    $color = 'deepskyblue';
                } else if (in_array($evento, $eventosMorado)) {
                    $color = 'purple';
                } else if (in_array($evento, $eventosGris)) {
                    $color = 'gray';
                } else if (in_array($evento, $eventosAM)) {
                    $color = 'aquamarine';
                } else if (in_array($evento, $eventosCT)) {
                    $color = 'chartreuse';
                } else if (in_array($evento, $eventosAO)) {
                    $color = 'royalblue';
                } else if (in_array($evento, $eventosVO)) {
                    $color = 'lightseagreen';
                } else if (in_array($evento, $eventosV1)) {
                    $color = 'firebrick';
                } else if (in_array($evento, $eventosV2)) {
                    $color = 'fuchsia';
                } else if (in_array($evento, $eventosV3)) {
                    $color = 'goldenrod';
                }
                echo '<div class="col" onclick="abrirModal(' . $evento['id_evento_agenda'] . ')" style="border: 1px solid black; background-color: ' . $color . ' ;"><h6>' . $evento['eventoFN'] . '</h6></div>';

            }

            echo '</div>';
            echo '</div>';
        } else {
            // Mostrar un mensaje predeterminado si no hay eventos para esta hora
            echo "No hay evento";
        }

        echo "</td>";
        echo "</tr>";
    }
}

generarTablaEventos($regionEA , $tipoEA , $usuario);
?>