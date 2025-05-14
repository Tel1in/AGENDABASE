<?php
require_once 'funcionesSql.php';
require_once 'sesion.php';

// Manejar la solicitud POST para obtener datos del evento
if(isset($_POST['action']) && $_POST['action'] === 'obtenerDatos2') {
    $ideagendas = $_POST['ideagendas'];
    $evento = obtenerDatos2($ideagendas);
    echo json_encode($evento);
    exit;
}

function generarTablaEventos() {
    $horas_fijas = array(
        "00:00", "01:00", "02:00", "03:00", "04:00", "05:00", "06:00", "07:00",
        "08:00", "09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00",
        "16:00", "17:00", "18:00", "19:00", "20:00", "21:00", "22:00", "23:00"
    );
    
    $fechaCookie = isset($_COOKIE['fechaActual']) ? $_COOKIE['fechaActual'] : date('Y-m-d');
    $ahora = new DateTime('now', new DateTimeZone('America/Tijuana'));
    $fechaHoraActual = new DateTime($ahora->format('Y-m-d H:i:s'), new DateTimeZone('America/Tijuana'));
    $fechaActual = $fechaHoraActual->format('Y-m-d');
    $usuario = $_SESSION['usuario'];

    
    echo "<script>console.log('Fecha Cookie: " . $fechaCookie . "');</script>";
    echo "<script>console.log('Fecha y Hora Actual: " . $fechaHoraActual->format('Y-m-d H:i:s') . "');</script>";
    echo "<script>console.log('Fecha Actual: " . $fechaActual . "');</script>";

    foreach ($horas_fijas as $hora) {
        $eventos = obtenerDatos3($hora, $fechaCookie, $usuario);
        
        echo "<tr>";
        echo "<th>$hora</th>";
        echo "<td>";
        
        if (!empty($eventos)) {
            echo '<div class="container"><div class="row">';
            foreach ($eventos as $evento) {
                $fechaEvento = $evento['fecha'];
                $fechaHoraEvento = new DateTime($evento['fecha'] . ' ' . $evento['hora']);
                $horaEvento = new DateTime($evento['hora']);

                $duracionEvento = (int)$evento['tiempo']; 
                $horaFinEvento = clone $horaEvento;
                $horaFinEvento->modify('+' . $duracionEvento . ' minutes');
                $horaActual = new DateTime($ahora->format('H:i:s'));
                
                echo "<script>console.log('Evento: " . $evento['eventoFN'] . "');</script>";
                echo "<script>console.log('Hora Evento: " . $horaEvento->format('H:i:s') . "');</script>";
                echo "<script>console.log('Hora Fin Evento: " . $horaFinEvento->format('H:i:s') . "');</script>";
                echo "<script>console.log('Hora Actual: " . $horaActual->format('H:i:s') . "');</script>";
                
                if ($fechaEvento < $fechaActual) {
                    $color = 'red';
                } elseif ($fechaEvento > $fechaActual) {
                    $color = 'green';
                } else {
                    if ($horaActual < $horaEvento) {
                        $color = 'green';
                        echo "<script>console.log('Color asignado: verde');</script>";
                    } elseif ($horaActual >= $horaEvento && $horaActual < $horaFinEvento) {
                        $color = 'yellow';
                        echo "<script>console.log('Color asignado: amarillo');</script>";
                    } else {
                        $color = 'red';
                        echo "<script>console.log('Color asignado: rojo');</script>";
                    }
                }

                $colorTexto = ($color == 'yellow') ? 'black' : 'white';
                echo '<div class="col" onclick="abrirModal(' . $evento['ideagendas'] . ')" style="border: 1px solid black; background-color: ' . $color . ';">';
                echo '<h6 style="color: ' . $colorTexto . ';">' . $evento['eventoFN'] . '</h6>';
                echo '</div>';
            }
            echo '</div></div>';
        } else {
            echo "No hay evento";
            echo "<script>console.log('No hay evento para la hora: " . $hora . "');</script>";
        }
        
        echo "</td></tr>";
    }
}

generarTablaEventos();
?>
