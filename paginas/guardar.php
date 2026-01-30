<?php
// 1. Conexión a la base de datos
$host = "localhost";
$user = "root";
$password = ""; // por defecto en XAMPP está vacío
$database = "equiaval"; // CAMBIA ESTE NOMBRE

$conn = new mysqli($host, $user, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// 2. Recibir datos del formulario
$nombres   = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$correo    = $_POST['correo'];
$telefono  = $_POST['telefono'];

// Checkboxes (si no vienen, valen 0)
$tarjetacredito     = isset($_POST['tarjetacredito']) ? 1 : 0;
$creditosbancarios  = isset($_POST['creditosbancarios']) ? 1 : 0;
$creditovehicular   = isset($_POST['creditovehicular']) ? 1 : 0;
$creditohipotecario = isset($_POST['creditohipotecario']) ? 1 : 0;
$cooperativa        = isset($_POST['cooperativa']) ? 1 : 0;
$companiatelefonica = isset($_POST['companiatelefonica']) ? 1 : 0;
$coactivos          = isset($_POST['coactivos']) ? 1 : 0;
$otros              = isset($_POST['otros']) ? 1 : 0;

// 3. Insertar en la base de datos
$sql = "INSERT INTO clientes (
    nombres, apellidos, correo, telefono,
    tarjetacredito, creditosbancarios, creditovehicular,
    creditohipotecario, cooperativa, companiatelefonica,
    coactivos, otros
) VALUES (
    '$nombres', '$apellidos', '$correo', '$telefono',
    $tarjetacredito, $creditosbancarios, $creditovehicular,
    $creditohipotecario, $cooperativa, $companiatelefonica,
    $coactivos, $otros
)";

if ($conn->query($sql) === TRUE) {
    echo "<script>
            alert('✅ Registro guardado correctamente');
            window.location.href = 'formulario.php'; // opcional
          </script>";
} else {
    echo "<script>
            alert('❌ Error al registrar');
          </script>";
}

// 4. Cerrar conexión
$conn->close();
?>
