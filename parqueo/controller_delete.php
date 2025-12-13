<?php
include('../app/config.php');

$id_map = $_GET['id_map'];  // recibimos el id_map del AJAX
$estado_inactivo = "0";

date_default_timezone_set("America/Bogota");
$fechaHora = date("Y-m-d H:i:s");

// ✅ CAMBIO 1: usar id_map en el WHERE
$sentencia = $pdo->prepare("UPDATE tb_mapeos SET
    estado = :estado,
    fyh_eliminacion = :fyh_eliminacion 
    WHERE id_map = :id_map");

// ✅ CAMBIO 2: bindParam debe coincidir con el nombre de los parámetros
$sentencia->bindParam(':estado', $estado_inactivo);
$sentencia->bindParam(':fyh_eliminacion', $fechaHora);
$sentencia->bindParam(':id_map', $id_map);

if ($sentencia->execute()) {
    echo "✅ Se eliminó el registro de la manera correcta (estado = 0)";
    ?>
    <script>
        // Redirigir si lo necesitas, o comenta esto si usas AJAX
        location.href = "../roles/";
    </script>
    <?php
} else {
    echo "❌ Error al eliminar el registro";
}
