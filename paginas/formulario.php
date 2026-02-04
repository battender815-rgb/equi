<html class="ltr yui3-js-enabled fontawesome-i2svg-active fontawesome-i2svg-complete" dir="ltr" lang="es-ES">

<body>

    <head>
        <?php
        include "../plantillas/head.php";
        ?>
        <style>
            .form-container {
                background: #ffffff;

                /* CENTRADO HORIZONTAL */
                margin: 40px auto;

                /* ESPACIADO INTERNO */
                padding: 35px 40px;

                /* TAMAÑO */
                width: 100%;
                max-width: 600px;

                border-radius: 12px;
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            }

            .form-container h2 {
                text-align: center;
                margin-bottom: 25px;
                color: #333;
            }

            .form-group {
                margin-bottom: 15px;
            }

            label {
                display: block;
                margin-bottom: 6px;
                color: #555;
                font-size: 14px;
            }

            input[type="text"],
            input[type="email"],
            input[type="tel"] {
                width: 100%;
                padding: 10px 12px;
                border-radius: 8px;
                border: 1px solid #ccc;
                font-size: 14px;
                transition: all 0.3s ease;
            }

            input:focus {
                border-color: #4f46e5;
                outline: none;
                box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
            }

            .checkbox-group {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
                margin: 20px 0;
                font-size: 14px;
                color: #444;
            }

            .checkbox-group label {
                display: flex;
                align-items: center;
                gap: 8px;
                cursor: pointer;
            }

            button {
                width: 100%;
                padding: 12px;
                background: #4f46e5;
                color: #fff;
                border: none;
                border-radius: 8px;
                font-size: 15px;
                font-weight: 600;
                cursor: pointer;
                transition: background 0.3s ease;
            }

            button:hover {
                background: #4338ca;
            }
        </style>
    </head>

    <form action="guardar.php" method="POST" class="form-container">
        <h2>Registro Información del Cliente</h2>
        <div class="form-group">
            <label>Cedula</label>
            <input type="text" name="cedula" required>
        </div>

        <div class="form-group">
            <label>Nombres</label>
            <input type="text" name="nombres" required>
        </div>

        <div class="form-group">
            <label>Apellidos</label>
            <input type="text" name="apellidos" required>
        </div>

        <div class="form-group">
            <label>Correo</label>
            <input type="email" name="correo" required>
        </div>

        <div class="form-group">
            <label>Teléfono</label>
            <input type="tel" name="telefono" required>
        </div>
        <h4>Deudas Actuales</h4>
        <div class="checkbox-group">

            <label><input type="checkbox" name="tarjetacredito" value="1"> Tarjeta de crédito</label>
            <label><input type="checkbox" name="creditosbancarios" value="1"> Créditos bancarios</label>
            <label><input type="checkbox" name="creditovehicular" value="1"> Crédito vehicular</label>
            <label><input type="checkbox" name="creditohipotecario" value="1"> Crédito hipotecario</label>
            <label><input type="checkbox" name="cooperativa" value="1"> Cooperativa</label>
            <label><input type="checkbox" name="companiatelefonica" value="1"> Compañía telefónica</label>
            <label><input type="checkbox" name="coactivos" value="1"> Coactivos</label>
            <label><input type="checkbox" name="otros" value="1"> Otros</label>
        </div>

        <button type="submit">Guardar</button>
    </form>

    <footer>
        <?php
        include "../plantillas/footer.php";
        ?>
    </footer>

</body>

</html>