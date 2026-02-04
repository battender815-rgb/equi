<html class="ltr yui3-js-enabled fontawesome-i2svg-active fontawesome-i2svg-complete" dir="ltr" lang="es-ES">

<body>

    <head>
        <?php
        include "../plantillas/head.php";
        ?>
        <style>
            /* Fuente y fondo general */
    /* Fuente y fondo general */
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f9f9f9;
        color: #333;
        padding: 30px;
    }

    h2 {
        text-align: center;
        color: #444;
        margin-bottom: 20px;
    }

    /* Formulario de búsqueda */
    form {
        text-align: center;
        margin-bottom: 30px;
    }

    input[type="text"] {
        padding: 10px 15px;
        width: 300px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    input[type="text"]:focus {
        border-color: #007BFF;
        box-shadow: 0 0 5px rgba(0,123,255,0.5);
        outline: none;
    }

    input[type="submit"] {
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        background-color: #007BFF;
        color: white;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-left: 10px;
    }

    input[type="submit"]:hover {
        background-color: #0056b3;
    }

    /* Contenedor de la tabla con scroll horizontal */
    .table-wrapper {
        width: 95%;
        max-width: 1200px;
        margin: 0 auto;      /* centra horizontalmente */
        overflow-x: auto;     /* scroll horizontal si es necesario */
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border-radius: 10px;
        background-color: white;
    }

    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        min-width: 1000px; /* fuerza scroll si hay muchas columnas */
    }

    th, td {
        padding: 12px 15px;
        text-align: left; /* cambia a center si quieres centrar el contenido */
        white-space: nowrap; /* evita que el texto se rompa */
    }

    th {
        background-color: #007BFF;
        color: white;
        font-weight: 600;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #e6f0ff;
        transition: background-color 0.3s ease;
    }

    /* Mensajes */
    p {
        text-align: center;
        font-size: 16px;
        color: #555;
    }
</style>




    </head>
    <h2>Consultar cliente</h2>
    <form method="GET" action="">
        <label for="consulta">Ingrese UID o correo:</label>
        <input type="text" id="consulta" name="consulta" required>
        <input type="submit" value="Buscar">
    </form>

    <?php
    if (isset($_GET['consulta'])) {
        $consulta = $_GET['consulta'];

        // Conexión a la base de datos
        $host = "localhost"; // Cambia si es necesario
        $usuario = "root";
        $clave = ""; // Tu contraseña
        $base = "equiaval"; // Cambia al nombre de tu BD
    
        $conn = new mysqli($host, $usuario, $clave, $base);

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Evitar inyección SQL
        $consulta_safe = $conn->real_escape_string($consulta);

        // Consulta SQL
        $sql = "SELECT cedula, nombres, apellidos, correo, telefono, tarjetacredito, 
                       creditosbancarios, creditovehicular, creditohipotecario, 
                       cooperativa, companiatelefonica, coactivos, otros
                FROM clientes
                WHERE cedula='$consulta_safe' OR correo='$consulta_safe'";

        $resultado = $conn->query($sql);

        if ($resultado->num_rows > 0) {
            echo "<h3>Resultados:</h3>";
            echo "<table>
                    <tr>
                        <th>Cedula</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Tarjeta de crédito</th>
                        <th>Créditos bancarios</th>
                        <th>Crédito vehicular</th>
                        <th>Crédito hipotecario</th>
                        <th>Cooperativa</th>
                        <th>Compañía telefónica</th>
                        <th>Coactivos</th>
                        <th>Otros</th>
                    </tr>";
            while ($fila = $resultado->fetch_assoc()) {
                $tarjeta = ($fila['tarjetacredito'] == 1) ? 'Sí' : 'No';
                $creditoB = ($fila['creditosbancarios'] == 1) ? 'Sí' : 'No';
                $creditoV = ($fila['creditovehicular'] == 1) ? 'Sí' : 'No';
                $creditoH = ($fila['creditohipotecario'] == 1) ? 'Sí' : 'No';
                $cooperativa = ($fila['cooperativa'] == 1) ? 'Sí' : 'No';
                $companiaT = ($fila['companiatelefonica'] == 1) ? 'Sí' : 'No';
                $coactivos = ($fila['coactivos'] == 1) ? 'Sí' : 'No';
                $otros = ($fila['otros'] == 1) ? 'Sí' : 'No';
                echo "<tr>
                        <td>{$fila['cedula']}</td>
                        <td>{$fila['nombres']}</td>
                        <td>{$fila['apellidos']}</td>
                        <td>{$fila['correo']}</td>
                        <td>{$fila['telefono']}</td>
                        <td>{$tarjeta}</td>
                        <td>{$creditoB}</td>
                        <td>{$creditoV}</td>
                        <td>{$creditoH}</td>
                        <td>{$cooperativa}</td>
                        <td>{$companiaT}</td>
                        <td>{$coactivos}</td>
                        <td>{$otros}</td>
                     </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No se encontraron resultados.</p>";
        }

        $conn->close();
    }
    ?>
    <footer>
        <?php
        include "../plantillas/footer.php";
        ?>
    </footer>

</body>

</html>