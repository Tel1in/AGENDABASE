<?php
require_once 'funcionesSql.php';

if (isset($_GET['valor1'])) {
    $id = $_GET['valor1']; // Obtén el valor seleccionado del segundo select
    $exp3 = expediente3($id);

    echo "<option value='' selected disabled>Seleccione</option>";

    // Llena el tercer select con los datos obtenidos en expediente3
    foreach ($exp3 as $exp) {
        echo "<option value='" . $exp['idinvolucrado'] . "'>" . $exp['nombreInputado'] . "</option>";
    }
} else {
    echo "Error: No se proporcionó el valor del segundo select.";
}
?>