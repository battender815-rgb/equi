<?php
$host = "localhost";
$user = "root";
$password = ""; // por defecto en XAMPP está vacío
$database = "equiaval"; // CAMBIA ESTE NOMBRE

$conn = new mysqli($host, $user, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>