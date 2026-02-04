<?php
header('Content-Type: application/json');

$conexion = mysqli_connect("localhost", "root", "", "equiaval");
if (!$conexion) {
    echo json_encode(null);
    exit;
}

if (!isset($_GET['cedula'])) {
    echo json_encode(null);
    exit;
}

$cedula = mysqli_real_escape_string($conexion, $_GET['cedula']);

$sql = "SELECT * FROM clientes WHERE cedula = '$cedula' LIMIT 1";
$result = mysqli_query($conexion, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    echo json_encode($row);
} else {
    echo json_encode(null);
}

mysqli_close($conexion);
?>
