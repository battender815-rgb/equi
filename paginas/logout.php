<?php
session_start();
session_unset(); // Limpiar variables de sesión
session_destroy(); // Destruir sesión
header("Location: login.php"); // Redirigir a página de login
exit;
?>