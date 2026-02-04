<?php
header('Content-Type: application/json');

// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "equiaval");

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => $conn->connect_error]);
    exit;
}

// Leer JSON recibido
$data = json_decode(file_get_contents("php://input"), true);

// Validar UID
if (!isset($data['id_cliente'])) {
    echo json_encode(['success' => false, 'error' => 'UID no recibido']);
    exit;
}

$uid = (int)$data['id_cliente'];

if ($uid <= 0) {
    echo json_encode(['success' => false, 'error' => 'UID inválido']);
    exit;
}

// Consulta de actualización
$sql = "UPDATE clientes SET
            coactivos = 0,
            companiatelefonica = 0,
            cooperativa = 0,
            creditohipotecario = 0,
            creditosbancarios = 0,
            creditovehicular = 0,
            otros = 0,
            score = 998,
            tarjetacredito = 0
        WHERE uid = $uid";

if ($conn->query($sql) === TRUE) {

    // rows_affected = 0 NO es error (valores iguales)
    if ($conn->affected_rows === 0) {
        echo json_encode([
            'success' => true,
            'message' => 'No hubo cambios (valores iguales o UID no encontrado)'
        ]);
    } else {
        echo json_encode(['success' => true]);
    }

} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

$conn->close();
?>
