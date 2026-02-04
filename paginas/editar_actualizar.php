<?php
include "../baseDeDatos/db.php";

$cedula = $_POST['cedula'];
$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];

$tarjetacredito = isset($_POST['tarjetacredito']) ? 1 : 0;
$creditosbancarios = isset($_POST['creditosbancarios']) ? 1 : 0;
$creditovehicular = isset($_POST['creditovehicular']) ? 1 : 0;
$creditohipotecario = isset($_POST['creditohipotecario']) ? 1 : 0;
$cooperativa = isset($_POST['cooperativa']) ? 1 : 0;
$companiatelefonica = isset($_POST['companiatelefonica']) ? 1 : 0;
$coactivos = isset($_POST['coactivos']) ? 1 : 0;
$otros = isset($_POST['otros']) ? 1 : 0;

$sql = "UPDATE clientes SET
    nombres='$nombres',
    apellidos='$apellidos',
    correo='$correo',
    telefono='$telefono',
    tarjetacredito=$tarjetacredito,
    creditosbancarios=$creditosbancarios,
    creditovehicular=$creditovehicular,
    creditohipotecario=$creditohipotecario,
    cooperativa=$cooperativa,
    companiatelefonica=$companiatelefonica,
    coactivos=$coactivos,
    otros=$otros
WHERE cedula='$cedula'";

mysqli_query($conexion, $sql);

header("Location: listar_clientes.php");
?>
