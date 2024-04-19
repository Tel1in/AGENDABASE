<?php
require_once 'conexion.php';

    
    function expediente(){
        $conn = conexion();
        $sql = "SELECT id_tipo_expediente,nom_expediente from cat_tipo_expediente where agenda='Si'";
        $result = $conn->query($sql );
    
        $exp = array();
    
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $exp[] = $row;
            }
        } else {
            echo "Error en la consulta: " . $conn->error;
        }
    
        $conn->close();
    
        return $exp;
    }
    
    function audiencias() {
        $conn = conexion();
        
        $sql = "SELECT id_tipo_audiencia,nom_tipo_audiencia FROM tipo_audiencia";
        $result = $conn->query($sql);
    
        $audiencia = array();
    
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $audiencia[] = $row;
            }
        } else {
            echo "Error en la consulta: " . $conn->error;
        }
    
        $conn->close();
    
        return $audiencia;
    }
    
    function sala() {
        $conn = conexion();
        
        $sql = "SELECT id_sala,nombre_sala FROM sala";
        $result = $conn->query($sql);
    
        $salas = array();
    
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $salas[] = $row;
            }
        } else {
            echo "Error en la consulta: " . $conn->error;
        }
    
        $conn->close();
    
        return $salas;
    }
    
    function juez() {
        $conn = conexion();
        
        $sql = "SELECT id_juez,nom_juez FROM juez";
        $result = $conn->query($sql);
    
        $jueces = array();
    
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $jueces[] = $row;
            }
        } else {
            echo "Error en la consulta: " . $conn->error;
        }
    
        $conn->close();
    
        return $jueces;
    }
    
    function expediente2($id_tipo_expediente) {
        $conn = conexion();
        $sql = "";
    
        switch ($id_tipo_expediente) {
            case 1:
            case 12:
            case 13:
                $sql = "SELECT id_asunto as valor1, numero_asunto AS valor2 FROM asunto_penal";
                break;
            case 2:
            case 17:
            case 19:
            case 5:
            case 4:
            case 25: 
                $sql = "SELECT id_cuadernillo_constancia as valor1 ,numero_cuadernillo AS valor2 FROM cuadernilloS_constancia";
                break;
            case 23:
                $sql = "SELECT id_causa as valor1, num_causa AS valor2 FROM causa";
                break;
            case 8:
                $sql = "SELECT id_causa as valor1, num_causa AS valor2 FROM causa WHERE tipo_causa=1";
                break;
            case 10:
            case 11:
                $sql = "SELECT id_causa as valor1, num_causa AS valor2 FROM causa WHERE tipo_causa=2";
                break;
            case 9:
                $sql = "SELECT id_causa as valor1, num_causa AS valor2 FROM causa WHERE tipo_causa=3";
                break;
            case 14:
            case 15:
                $sql = "SELECT id_ejecucion as valor1, num_ejecucion AS valor2 FROM ejecucion";
                break;   
            default:
                echo "Error: Tipo de expediente no reconocido para nom_expediente = $id_tipo_expediente.";
                break;
        }
    
        
        $exp2 = array();
    
        if (!empty($sql)) {
            $result = $conn->query($sql);
    
            if (!$result) {
                echo "Error en la consulta SQL: " . $conn->error;
            } else {
                while ($row = $result->fetch_assoc()) {
                    $exp2[] = $row;
                }
            }
        } else {
            echo "Error: La consulta SQL está vacía.";
        }
    
        $conn->close();
    
        return $exp2;
    }
    
    function expediente3($id) {
        $conn = conexion();
        $sql = "";
    
        $sql = "SELECT id_inv , CONCAT(nombre_inv,' ',paterno_inv,' ',materno_inv) AS nombreInputado FROM involucrado WHERE causa_id = '$id'";
    
        $exp3 = array();
    
    
        if (!empty($sql)) {
            $result = $conn->query($sql);
    
            if (!$result) {
                echo "Error en la consulta SQL: " . $conn->error;
            } else {
                while ($row = $result->fetch_assoc()) {
                    $exp3[] = $row;
                }
            }
        } else {
            echo "Error: La consulta SQL está vacía.";
        }
    
        $conn->close();
    
        return $exp3;
    }
    
    
    
    function insertar($nom_expediente, $numero, $inputado, $tipoAud, $sala, $juez, $fecha, $hora, $evento)
    {
        $conn = conexion();
    
    
            $sql_insert = "INSERT INTO eventoAgenda (expediente,numero,inputado,tipoAudiencia,sala,juez,fecha,hora,evento)
                           VALUES ('$nom_expediente','$numero',$inputado,'$tipoAud','$sala','$juez', '$fecha', '$hora', '$evento')";
            if ($conn->query($sql_insert) === TRUE) {
            } else {
                echo "Error en la inserción del evento: " . $conn->error;
            }
       
        $conn->close();
    }
    
    
    function obtenerDatos(){
        $conn = conexion();
        $sql = "SELECT eventoagenda.id_evento_agenda,cat_tipo_expediente.nom_expediente,eventoagenda.numero,CONCAT(involucrado.nombre_inv,' ',involucrado.paterno_inv,' ',involucrado.materno_inv) as nombreInv,tipo_audiencia.nom_tipo_audiencia,sala.nombre_sala,juez.nom_juez,
                       eventoagenda.fecha,eventoagenda.hora,eventoagenda.evento 
                    from eventoagenda 
                    inner join cat_tipo_expediente on cat_tipo_expediente.id_tipo_expediente=eventoagenda.expediente
                    inner join involucrado on involucrado.id_inv = eventoagenda.inputado
                    inner join tipo_audiencia on tipo_audiencia.id_tipo_audiencia=eventoagenda.tipoAudiencia
                    inner join sala on sala.id_sala = eventoagenda.sala
                    inner join juez on juez.id_juez = eventoagenda.juez
                    ORDER BY eventoagenda.id_evento_agenda ASC;" ;
    
        $result = $conn->query($sql);
    
        $conn->close();
    
        return $result;
    }
    
    function obtenerDatos2($id_evento_agenda){
        $conn = conexion();
        $sql = "SELECT eventoagenda.id_evento_agenda,cat_tipo_expediente.nom_expediente,eventoagenda.numero,
                       CONCAT(involucrado.nombre_inv,' ',involucrado.paterno_inv,' ',involucrado.materno_inv) as nombreInv,involucrado.id_inv,tipo_audiencia.id_tipo_audiencia,
                       tipo_audiencia.nom_tipo_audiencia,sala.id_sala,sala.nombre_sala,
                       juez.nom_juez,juez.id_juez,
                       eventoagenda.fecha,eventoagenda.hora,eventoagenda.evento 
                    FROM eventoagenda 
                    INNER JOIN cat_tipo_expediente ON cat_tipo_expediente.id_tipo_expediente=eventoagenda.expediente
                    INNER JOIN involucrado ON involucrado.id_inv = eventoagenda.inputado
                    INNER JOIN tipo_audiencia ON tipo_audiencia.id_tipo_audiencia=eventoagenda.tipoAudiencia
                    INNER JOIN sala ON sala.id_sala = eventoagenda.sala
                    INNER JOIN juez ON juez.id_juez = eventoagenda.juez
                    WHERE eventoagenda.id_evento_agenda = '$id_evento_agenda';";
    
        $result = $conn->query($sql);
    
        $evento = array(); // Inicializamos un array para almacenar los datos del evento
    
        if ($result->num_rows > 0) {
            // Obtenemos los datos del primer (y único) evento encontrado
            $evento = $result->fetch_assoc();
        }
    
        $conn->close();
    
        return $evento; 
    }

  
    
    function obtenerDatos3($hora, $sala, $fecha) {
        $conn = conexion();  
        $subHora = substr($hora, 0, 2);
        $salas_str = implode(',', $sala); // Convertir el array de salas en una cadena separada por comas
        $sql = "SELECT id_evento_agenda, CONCAT(TIME_FORMAT(hora,'%H:%i'),' = ',numero) as eventoFN FROM eventoagenda WHERE hora LIKE '$subHora%' AND sala IN ($salas_str) AND fecha = '$fecha'";
        
        $result = $conn->query($sql);
        $eventos = array(); 
    
        if ($result->num_rows > 0) {
            // Si se encuentran eventos, los agregamos al array $eventos
            while ($row = $result->fetch_assoc()) {
                $eventos[] = $row; // Modificar para agregar el array asociativo completo
            }
        }
    
        $conn->close();
    
        return $eventos;
    }

    function obtenerDatos4() {
        $conn = conexion();
        $sql = "SELECT eventoagenda.id_evento_agenda AS idEvento,CONCAT(cat_tipo_expediente.tipo_expediente, '-', eventoagenda.numero) AS title, eventoagenda.fecha AS f
                FROM eventoagenda
                INNER JOIN cat_tipo_expediente ON eventoagenda.expediente = cat_tipo_expediente.id_tipo_expediente";
        $result = $conn->query($sql);
        $eventos = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $eventos[] = array(
                    'id' => $row['idEvento'],
                    'title' => $row['title'],
                    'date' => $row['f'],
                    'allDay' => true
                );
            }
        }
        $conn->close();
        return $eventos;
    }
    


     function eliminarDatos($id_evento_agenda){
        $conn = conexion();
        $sql = "DELETE FROM eventoagenda WHERE id_evento_agenda = '$id_evento_agenda'";
        $response = "";
    
        if ($conn->query($sql) === TRUE) {
            $response = "Evento eliminado correctamente";
        } else {
            $response = "Error al eliminar el evento: " . $conn->error;
        }
    
        $conn->close();
    
        return $response;
    }
    
    
     function modificarDatos($id_evento_agenda, $tipoAud, $sala, $juez, $fecha, $hora, $evento){
        $conn = conexion();
        $sql = "UPDATE eventoagenda
                SET  tipoAudiencia = '$tipoAud', sala = '$sala' , juez = '$juez' , fecha = '$fecha' , hora = '$hora' , evento = '$evento'
                WHERE id_evento_agenda = '$id_evento_agenda'";
        $response = "";

        if ($conn->query($sql) === TRUE) {
            $response = "Evento modificado correctamente";
        } else {
            $response = "Error al modificar el evento: " . $conn->error;
        }
    
        $conn->close();
    
        return $response;
     }
    


    
