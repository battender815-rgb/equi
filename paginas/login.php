<?php
session_start();

// --- Configuración de la base de datos ---
$host = 'localhost';
$db   = 'equiaval';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// --- Inicializar variable de error ---
$error = "";

// --- Procesar login si se envió el formulario ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cedula'], $_POST['password'])) {
    $cedula = trim($_POST['cedula']);
    $password = $_POST['password'];

    // Buscar usuario admin
    $stmt = $pdo->prepare("SELECT * FROM clientes WHERE cedula = ? AND rol = 'admin'");
    $stmt->execute([$cedula]);
    $usuario = $stmt->fetch();

    if ($usuario) {
        // Verificar contraseña
        // Si la contraseña está en texto plano en la DB, usar comparación directa
        // Si está hasheada, usar password_verify()
        if (password_verify($password, $usuario['password'])) {
            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['rol'] = $usuario['rol'];
            header('Location: administrador.php');
            exit;
        } elseif ($password === $usuario['password']) { 
            // Caso de texto plano (temporalmente)
            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['rol'] = $usuario['rol'];
            header('Location: administrador.php');
            exit;
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Cédula no encontrada o no es admin.";
    }
}

// --- Procesar logout ---
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ?");
    exit;
}
?>


<!-- --- Formulario de login --- -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            width: 300px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0 16px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="login-container">
    <h2>Login Admin</h2>
    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form action="" method="POST">
        <input type="text" name="cedula" placeholder="Cédula" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Ingresar</button>
    </form>
</div>
</body>
</html>







