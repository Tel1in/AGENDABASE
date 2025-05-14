<?php
require_once 'conexion.php';

    
    function obtenerNombreUsuario($usuario){
        $conn = conexion();
        $sql = "SELECT nombreUser FROM user WHERE nombreUser = '$usuario'";
        $result = $conn->query($sql);
        if($result -> num_rows > 0){
            $row = $result->fetch_assoc();
            $user = $row["nombreUser"];
            return $user;
        }else {
            echo "No se encontró el usuario en la tabla.";
            return "";
        }
    }

    function verificarNIPEnBD($nip) {
        $conn = conexion();
        $stmt = $conn->prepare("SELECT nombreUser FROM user WHERE nip = ?");
        $stmt->bind_param("s", $nip);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row["nombreUser"];
        } else {
            echo "No se encontró el NIP en la tabla.";
            return "";
        }
    }
    
    function insertar($nombreA, $desA, $fecha, $hora, $tiempo, $user) {
        $conn = conexion();
    
        // Verificar si ya existe un evento en la misma fecha, hora y sala
        $sql_check = "SELECT COUNT(*) FROM eagendas WHERE fecha = '$fecha' AND hora = '$hora'";
        $result = $conn->query($sql_check);
        $row = $result->fetch_row();
        if ($row[0] > 0) {
            $response = "Error: Ya existe un evento con la misma fecha, hora";
            echo $response;
            $conn->close();
            return;
        }

        $sql_insert = "INSERT INTO eagendas (nombreA, desA, fecha, hora, tiempo, user) VALUES ('$nombreA', '$desA', '$fecha', '$hora', '$tiempo', '$user')";
        if ($conn->query($sql_insert) === TRUE) {
                $response = "Evento insertado correctamente.";
                echo $response;
            } else {
                $response = "Error en la inserción del evento: " . $conn->error;
                echo $response;
            }
    
        $conn->close();

    }

    function obtenerDatos3($hora, $fecha ,$user) {
        $conn = conexion();  
        $subHora = substr($hora, 0, 2);
        $sql = "SELECT ideagendas, CONCAT(TIME_FORMAT(hora,'%H:%i'),' ',nombreA) as eventoFN, fecha, hora , tiempo 
                FROM eagendas 
                WHERE hora LIKE '$subHora%' AND fecha = '$fecha' AND user = '$user'
                GROUP BY ideagendas";
       
        $result = $conn->query($sql);
        $eventos = array(); 
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $eventos[] = $row;
            }
        }
    
        $conn->close();
    
        return $eventos;
    }
   
    function obtenerDatos2($ideagendas){
        $conn = conexion();
        $sql = "SELECT *
                FROM  eagendas
                WHERE ideagendas = '$ideagendas';";

        $result = $conn->query($sql);
        $evento = array();

        if ($result->num_rows > 0) {
            $evento = $result->fetch_assoc();
        }

        $conn->close();
        return $evento;
    }

    function eliminarDatos($ideagendas){
        $conn = conexion();
        $sql = "DELETE FROM eagendas WHERE ideagendas = '$ideagendas'";
        $response = "";
    
        if ($conn->query($sql) === TRUE) {
            $response = "Evento eliminado correctamente";
        } else {
            $response = "Error al eliminar el evento: " . $conn->error;
        }
    
        $conn->close();
    
        return $response;
    }
    
    function modificarDatos($ideagendas, $nombreA, $desA, $fecha, $hora, $tiempo) {
        $conn = conexion();
    
        // Primero, obtenemos los datos actuales del evento
        $sql_actual = "SELECT fecha, hora FROM eagendas WHERE ideagendas = '$ideagendas'";
        $resultado_actual = $conn->query($sql_actual);
        $fila_actual = $resultado_actual->fetch_assoc();
    
        // Verificamos si la fecha o hora han cambiado
        if ($fecha != $fila_actual['fecha'] || $hora != $fila_actual['hora']) {
            // Solo verificamos conflictos si alguno de estos campos ha cambiado
            $sql_verificar = "SELECT COUNT(*) FROM eagendas WHERE fecha = '$fecha' AND hora = '$hora' AND ideagendas != '$ideagendas'";
            $resultado = $conn->query($sql_verificar);
            $fila = $resultado->fetch_row();
            if ($fila[0] > 0) {
                $response = "Error: Ya existe un evento con la misma fecha y hora.";
                echo $response;
                $conn->close();
                return;
            }
        }
    
        $sql = "UPDATE eagendas
                SET nombreA = '$nombreA', desA = '$desA', fecha = '$fecha', hora = '$hora', tiempo = '$tiempo'
                WHERE ideagendas = '$ideagendas'";
        
        $response = "";
        
        if ($conn->query($sql) === TRUE) {
            $response = "Evento modificado correctamente";
        } else {
            $response = "Error al modificar el evento: " . $conn->error;
        }
        
        $conn->close();
        
        return $response;
    }

    function obtenerDatos4($usuario) {
        $conn = conexion();
        $sql = "SELECT ideagendas AS idEvento, 
                    nombreA AS title, 
                    fecha AS f,
                    hora AS h,
                    tiempo AS duracion
                FROM eagendas
                WHERE user = '$usuario'";
        
        $result = $conn->query($sql);
        $eventos = array();
        
        if ($result->num_rows > 0) {
            $ahora = new DateTime('now', new DateTimeZone('America/Tijuana'));
            $fechaHoraActual = $ahora->format('Y-m-d H:i:s');
            
            while ($row = $result->fetch_assoc()) {
                $fechaHoraEvento = $row['f'] . ' ' . $row['h'];
                $fechaHoraFinEvento = (new DateTime($fechaHoraEvento))->modify('+' . $row['duracion'] . ' minutes')->format('Y-m-d H:i:s');
                $color = determinarColor($fechaHoraEvento, $fechaHoraFinEvento, $fechaHoraActual);
                
                $eventos[] = array(
                    'id' => $row['idEvento'],
                    'title' => $row['title'],
                    'start' => $fechaHoraEvento,
                    'end' => $fechaHoraFinEvento,
                    'allDay' => false,
                    'color' => $color
                );
            }
        }
        $conn->close();
        return $eventos;
    }
    
    function determinarColor($fechaHoraEvento, $fechaHoraFinEvento, $fechaHoraActual) {
        $evento = new DateTime($fechaHoraEvento);
        $finEvento = new DateTime($fechaHoraFinEvento);
        $actual = new DateTime($fechaHoraActual);
        
        if ($evento > $actual) {
            return 'green';
        } elseif ($actual >= $evento && $actual < $finEvento) {
            return 'yellow';
        } else {
            return 'red';
        }
    }



   
    
    
   
   