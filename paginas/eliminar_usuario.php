<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $uid = $_POST['uid'];

    try {
        $conexion = new PDO(
            "mysql:host=localhost;dbname=equiaval;charset=utf8",
            "root",
            ""
        );
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "DELETE FROM clientes WHERE uid = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$uid]);

        header("Location: administrador.php");
        exit;

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
