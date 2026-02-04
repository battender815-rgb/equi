<?php
try {
    $conexion = new PDO(
        "mysql:host=localhost;dbname=equiaval;charset=utf8",
        "root",
        ""
    );
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT 
                uid,
                nombres,
                apellidos,
                cedula,
                correo,
                telefono,
                password,
                rol,
                score,
                tarjetacredito,
                creditosbancarios,
                creditovehicular,
                creditohipotecario,
                cooperativa,
                companiatelefonica,
                coactivos,
                otros

                
            FROM clientes";

    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

?>
<html class="ltr yui3-js-enabled fontawesome-i2svg-active fontawesome-i2svg-complete" dir="ltr" lang="es-ES">

<body>
    <style>
    body {
        font-family: Arial, Helvetica, sans-serif;
        background: #f4f6f9;
        padding: 20px;
    }

    h1 {
        text-align: center;
        margin-bottom: 20px;
    }

    .tabla-container {
        overflow-x: auto;
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        background: #2c3e50;
        color: #fff;
    }

    th,
    td {
        padding: 12px 10px;
        border-bottom: 1px solid #ddd;
    }

    tbody tr:hover {
        background: #f1f1f1;
    }

    .password {
        font-family: monospace;
        font-size: 13px;
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

    thead th {
        background: #2c3e50;
        color: #ffffff;
        text-transform: uppercase;
        font-weight: 600;
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
    </style>

    <head>
        <?php
        include "../plantillas/head.php";
        ?>
    </head>
    <h1>Listado de Usuarios</h1>

    <div class="tabla-container">
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
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientes as $c): ?>
                <tr>
                    <td><?= $c['uid'] ?></td>
                    <td><?= $c['nombres'] ?></td>
                    <td><?= $c['apellidos'] ?></td>
                    <td><?= $c['cedula'] ?></td>
                    <td><?= $c['correo'] ?></td>
                    <td><?= $c['telefono'] ?></td>
                    <td class="password"><?= $c['password'] ?></td>
                    <td class="rol"><?= $c['rol'] ?></td>
                    <td class="score"><?= $c['score'] ?></td>
                    <td><?= ($c['tarjetacredito']== 1)? 'Sí' : 'No'; ?></td>
                    <td><?= ($c['creditosbancarios']== 1)? 'Sí' : 'No'; ?></td>
                    <td><?= ($c['creditovehicular']== 1)? 'Sí' : 'No'; ?></td>
                    <td><?= ($c['creditohipotecario']== 1)? 'Sí' : 'No';  ?></td>
                    <td><?= ($c['cooperativa']== 1)? 'Sí' : 'No';  ?></td>
                    <td><?= ($c['companiatelefonica']== 1)? 'Sí' : 'No'; ?></td>
                    <td><?= ($c['coactivos'] == 1)? 'Sí' : 'No'; ?></td>
                    <td><?= ($c['otros'] == 1)? 'Sí' : 'No'; ?></td>
                    
                    <!-- EDITAR -->
                    <td>
                        <a href="editar_usuario.php?uid=<?= $c['uid'] ?>" class="btn-editar">
                            ✏️ Editar
                        </a>
                    </td>

                    <!-- ELIMINAR -->
                    <td>
                        <form action="eliminar_usuario.php" method="POST"
                            onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?');">
                            <input type="hidden" name="uid" value="<?= $c['uid'] ?>">
                            <button type="submit" class="btn-eliminar">
                                🗑️ Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <br><br><br><br><br><br><br><br><br><br><br><br><br>
    <footer>
        <?php
        include "../plantillas/footer.php";
        ?>
    </footer>

</body>

</html>