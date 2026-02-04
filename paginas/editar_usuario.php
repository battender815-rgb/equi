<?php
session_start(); // necesario si usamos sesiones más adelante

// Conexión PDO
try {
    $pdo = new PDO("mysql:host=localhost;dbname=equiaval;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// --- ELIMINAR USUARIO ---
if (isset($_POST['eliminar'])) {
    $uid = $_POST['uid'];
    $stmt = $pdo->prepare("DELETE FROM clientes WHERE uid = ?");
    $stmt->execute([$uid]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// --- EDITAR USUARIO ---
if (isset($_POST['editar'])) {
    $uid = $_POST['uid'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $cedula = $_POST['cedula'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $password = $_POST['password']; // Ideal usar password_hash
    $rol = $_POST['rol'];
    $score = $_POST['score'];

    $tarjetacredito = isset($_POST['tarjetacredito']) ? 1 : 0;
    $creditosbancarios = isset($_POST['creditosbancarios']) ? 1 : 0;
    $creditovehicular = isset($_POST['creditovehicular']) ? 1 : 0;
    $creditohipotecario = isset($_POST['creditohipotecario']) ? 1 : 0;
    $cooperativa = isset($_POST['cooperativa']) ? 1 : 0;
    $companiatelefonica = isset($_POST['companiatelefonica']) ? 1 : 0;
    $coactivos = isset($_POST['coactivos']) ? 1 : 0;
    $otros = isset($_POST['otros']) ? 1 : 0;

    $sql = "UPDATE clientes SET 
                nombres=?, apellidos=?, cedula=?, correo=?, telefono=?, password=?, rol=?, score=?,
                tarjetacredito=?, creditosbancarios=?, creditovehicular=?, creditohipotecario=?,
                cooperativa=?, companiatelefonica=?, coactivos=?, otros=?
            WHERE uid=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $nombres,
        $apellidos,
        $cedula,
        $correo,
        $telefono,
        $password,
        $rol,
        $score,
        $tarjetacredito,
        $creditosbancarios,
        $creditovehicular,
        $creditohipotecario,
        $cooperativa,
        $companiatelefonica,
        $coactivos,
        $otros,
        $uid
    ]);

    // Redirigir con mensaje de éxito
    header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
    exit;
}

// --- SI SE SELECCIONÓ USUARIO PARA EDITAR ---
$usuarioEditar = null;
if (isset($_GET['editar_uid'])) {
    $stmt = $pdo->prepare("SELECT * FROM clientes WHERE uid=?");
    $stmt->execute([$_GET['editar_uid']]);
    $usuarioEditar = $stmt->fetch(PDO::FETCH_ASSOC);
}

// --- LISTAR USUARIOS ---
$sql = "SELECT * FROM clientes";
$stmt = $pdo->query($sql);
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <title>Usuarios</title>
    <style>
        /* ... mismo CSS que antes ... */
        body {
            font-family: Arial;
            background: #f4f6f9;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .table-container {
            overflow-x: auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, .1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th,
        td {
            padding: 12px 8px;
            text-align: center;
            border-bottom: 1px solid #ddd;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        thead th {
            background: #2c3e50;
            color: #fff;
            font-weight: 600;
            text-transform: uppercase;
        }

        tbody tr:hover {
            background: #f1f1f1;
        }

        .password {
            font-family: monospace;
            color: #c0392b;
        }

        .rol {
            font-weight: bold;
            color: #2980b9;
        }

        .score {
            font-weight: bold;
            color: #27ae60;
        }

        .btn-editar {
            background: #3498db;
            color: #fff;
            padding: 6px 10px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 13px;
        }

        .btn-editar:hover {
            background: #2980b9;
        }

        .btn-eliminar {
            background: #e74c3c;
            color: #fff;
            border: none;
            padding: 6px 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 13px;
        }

        .btn-eliminar:hover {
            background: #c0392b;
        }

        .form-container {
            max-width: 500px;
            margin: 20px auto;
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, .1);
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }

        input,
        select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }

        .btn-guardar {
            margin-top: 20px;
            width: 100%;
            padding: 10px;
            background: #27ae60;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-guardar:hover {
            background: #219150;
        }

        .checkbox-group label {
            display: block;
            margin-top: 5px;
        }
    </style>
    <?php
    include "../plantillas/head.php";
    ?>
</head>

<body>

    <div style="text-align:right; margin-bottom:15px;">
        <a href="administrador.php"
            style="background:#8e44ad;color:#fff;padding:10px 15px;border-radius:5px;text-decoration:none;font-weight:bold;">Pagina
            Principal</a>
    </div>

    <h1>Listado de Usuarios</h1>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Cédula</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Password</th>
                    <th>Rol</th>
                    <th>Score</th>
                    <th>Tarjeta C.</th>
                    <th>Credito B.</th>
                    <th>Credito V.</th>
                    <th>Credito H.</th>
                    <th>Cooperativa</th>
                    <th>C. Telefonica</th>
                    <th>Coactivos</th>
                    <th>Otros</th>
                    <th>Editar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $u): ?>
                    <tr>
                        <td><?= $u['uid'] ?></td>
                        <td><?= $u['nombres'] ?></td>
                        <td><?= $u['apellidos'] ?></td>
                        <td><?= $u['cedula'] ?></td>
                        <td><?= $u['correo'] ?></td>
                        <td><?= $u['telefono'] ?></td>
                        <td class="password"><?= $u['password'] ?></td>
                        <td class="rol"><?= $u['rol'] ?></td>
                        <td class="score"><?= $u['score'] ?></td>
                        <td class="tarjetacredito"><?= ($u['tarjetacredito'] == 1) ? 'Sí' : 'No'; ?></td>
                        <td class="creditosbancarios"><?= ($u['creditosbancarios'] == 1) ? 'Sí' : 'No'; ?></td>
                        <td class="creditovehicular"><?= ($u['creditovehicular'] == 1) ? 'Sí' : 'No'; ?></td>
                        <td class="creditohipotecario"><?= ($u['creditohipotecario'] == 1) ? 'Sí' : 'No'; ?></td>
                        <td class="cooperativa"><?= ($u['cooperativa'] == 1) ? 'Sí' : 'No'; ?></td>
                        <td class="companiatelefonica"><?= ($u['companiatelefonica'] == 1) ? 'Sí' : 'No'; ?></td>
                        <td class="coactivos"><?= ($u['coactivos'] == 1) ? 'Sí' : 'No'; ?></td>
                        <td class="otros"><?= ($u['otros'] == 1) ? 'Sí' : 'No'; ?></td>
                        <td><a class="btn-editar" href="?editar_uid=<?= $u['uid'] ?>">✏️ Editar</a></td>
                        
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php if ($usuarioEditar): ?>
        <style>
            /* Contenedor principal */
            .form-container {
                max-width: 600px;
                margin: 40px auto;
                padding: 30px;
                background: #ffffff;
                border-radius: 12px;
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }

            /* Título */
            .form-container h2 {
                text-align: center;
                margin-bottom: 25px;
                color: #333;
                font-weight: 600;
            }

            /* Labels */
            .form-container label {
                display: block;
                margin: 12px 0 6px;
                color: #555;
                font-weight: 500;
            }

            /* Inputs y selects */
            .form-container input[type="text"],
            .form-container input[type="email"],
            .form-container input[type="number"],
            .form-container input[type="password"],
            .form-container select {
                width: 100%;
                padding: 10px 12px;
                border: 1px solid #ccc;
                border-radius: 8px;
                font-size: 14px;
                transition: border-color 0.3s, box-shadow 0.3s;
            }

            .form-container input:focus,
            .form-container select:focus {
                border-color: #4A90E2;
                box-shadow: 0 0 8px rgba(74, 144, 226, 0.3);
                outline: none;
            }

            /* Checkbox group */
            .checkbox-group {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
                margin-top: 10px;
            }

            .checkbox-group label {
                font-weight: 400;
                color: #555;
                display: flex;
                align-items: center;
                gap: 8px;
            }

            /* Botón */
            .btn-guardar {
                margin-top: 20px;
                width: 100%;
                padding: 12px;
                background-color: #4A90E2;
                color: white;
                border: none;
                border-radius: 8px;
                font-size: 16px;
                font-weight: 600;
                cursor: pointer;
                transition: background-color 0.3s, transform 0.2s;
            }

            .btn-guardar:hover {
                background-color: #357ABD;
                transform: translateY(-2px);
            }
        </style>

        <div class="form-container">
            <h2>Editar Usuario (ID <?= $usuarioEditar['uid'] ?>)</h2>
            <form method="POST">
                <input type="hidden" name="uid" value="<?= $usuarioEditar['uid'] ?>">
                <label>Nombres</label>
                <input type="text" name="nombres" value="<?= $usuarioEditar['nombres'] ?>" required>

                <label>Apellidos</label>
                <input type="text" name="apellidos" value="<?= $usuarioEditar['apellidos'] ?>" required>

                <label>Cédula</label>
                <input type="text" name="cedula" value="<?= $usuarioEditar['cedula'] ?>">

                <label>Correo</label>
                <input type="email" name="correo" value="<?= $usuarioEditar['correo'] ?>">

                <label>Teléfono</label>
                <input type="text" name="telefono" value="<?= $usuarioEditar['telefono'] ?>">

                <label>Password</label>
                <input type="text" name="password" value="<?= $usuarioEditar['password'] ?>">

                <label>Rol</label>
                <select name="rol">
                    <option value="admin" <?= $usuarioEditar['rol'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="usuario" <?= $usuarioEditar['rol'] == 'usuario' ? 'selected' : '' ?>>Usuario</option>
                </select>

                <label>Score</label>
                <input type="number" name="score" value="<?= $usuarioEditar['score'] ?>">

                <div class="checkbox-group">
                    <label><input type="checkbox" name="tarjetacredito" value="1" <?= $usuarioEditar['tarjetacredito'] ? 'checked' : '' ?>> Tarjeta de crédito</label>
                    <label><input type="checkbox" name="creditosbancarios" value="1" <?= $usuarioEditar['creditosbancarios'] ? 'checked' : '' ?>> Créditos bancarios</label>
                    <label><input type="checkbox" name="creditovehicular" value="1" <?= $usuarioEditar['creditovehicular'] ? 'checked' : '' ?>> Crédito vehicular</label>
                    <label><input type="checkbox" name="creditohipotecario" value="1"
                            <?= $usuarioEditar['creditohipotecario'] ? 'checked' : '' ?>> Crédito hipotecario</label>
                    <label><input type="checkbox" name="cooperativa" value="1" <?= $usuarioEditar['cooperativa'] ? 'checked' : '' ?>> Cooperativa</label>
                    <label><input type="checkbox" name="companiatelefonica" value="1"
                            <?= $usuarioEditar['companiatelefonica'] ? 'checked' : '' ?>> Compañía telefónica</label>
                    <label><input type="checkbox" name="coactivos" value="1" <?= $usuarioEditar['coactivos'] ? 'checked' : '' ?>> Coactivos</label>
                    <label><input type="checkbox" name="otros" value="1" <?= $usuarioEditar['otros'] ? 'checked' : '' ?>>
                        Otros</label>
                </div>

                <button type="submit" name="editar" class="btn-guardar">Guardar Cambios</button>
            </form>
        </div>
    <?php endif; ?>
    <!-- POP-UP DE ÉXITO -->
    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <script>
            alert("Usuario actualizado correctamente ✅");
        </script>
    <?php endif; ?>

</body>

</html>