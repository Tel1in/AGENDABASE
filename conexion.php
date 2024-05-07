<?php 
    function conexion(){
     
        $servername = "127.0.0.1:3307";
        $username = "root";
        $password = "1234";
        $dbname = "causasis";
    
        $conn = new mysqli($servername, $username, $password, $dbname);

    
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }
    
    echo "";
    
    return $conn;

    };
   
?>