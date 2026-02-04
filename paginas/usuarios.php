<?php
header('Content-Type: application/json');

// conexión
$conexion = mysqli_connect("localhost", "root", "", "equiaval");

if (!$conexion) {
    echo json_encode(["error" => "Error de conexión"]);
    exit;
}

// consulta (SOLO campos necesarios)
$sql = "SELECT 
            uid,
            apellidos, 
            cedula, 
            coactivos, 
            companiatelefonica, 
            cooperativa, 
            correo, 
            creditohipotecario, 
            creditosbancarios, 
            creditovehicular, 
            nombres, 
            otros, 
            password, 
            rol, 
            score, 
            tarjetacredito, 
            telefono

        FROM clientes";

$result = mysqli_query($conexion, $sql);

$usuarios = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $usuarios[] = $row;
    }
}

echo json_encode($usuarios);

mysqli_close($conexion);