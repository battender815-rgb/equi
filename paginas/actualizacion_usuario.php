<?php
$conexion = mysqli_connect("localhost", "root", "", "equiaval");

// Verificar conexión
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

$sql = "SELECT score FROM clientes WHERE uid = 4";
$result = mysqli_query($conexion, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);

} else {
    echo "Error en la consulta: " . mysqli_error($conexion);
}

mysqli_close($conexion);
?>

<html class="ltr yui3-js-enabled fontawesome-i2svg-active fontawesome-i2svg-complete" dir="ltr" lang="es-ES">

<body>

    <head>
        <?php
        include "../plantillas/head2.php";
        ?>


        <style>
            @media (max-width: 768px) {
                .container {
                    flex-direction: column;
                    /* Apilar columnas verticalmente */
                    gap: 10px;
                    /* Reducir espacio entre columnas en móvil */
                    margin: 10px;
                }

                .column,
                .lista-elegante {
                    width: 100% !important;
                    padding: 10px 5px;
                    box-sizing: border-box;
                }

                .speedometer {
                    width: 100% !important;
                    max-width: 300px;
                    height: auto;
                    margin: 0 auto;
                }

                table {
                    font-size: 12px;
                    width: 100%;
                    overflow-x: auto;
                    display: block;
                }

                /* Opcional: para que el texto no quede muy pequeño */
                h4 {
                    font-size: 1.2em;
                }

                button {
                    width: 100%;
                    padding: 12px;
                    font-size: 16px;
                }
            }

            body {
                font-family: Arial, sans-serif;
                margin: 20px;
            }

            .container {
                display: flex;
                gap: 20px;
                /* espacio entre columnas */
            }

            .column {
                flex: 1;
                /* cada columna ocupa el mismo espacio */
                padding: 15px;
            }

            h4 {
                text-align: center;
                color: #333;
            }

            ul {
                list-style-type: none;
                padding-left: 0;
            }

            li {
                padding: 5px 0;
            }

            .speedometer {
                position: relative;
                width: 300px;
                height: 150px;
            }

            .dial {
                width: 100%;
                height: 100%;
                border-top-left-radius: 150px;
                border-top-right-radius: 150px;
                background: #333;
                position: relative;
                overflow: hidden;
            }

            .needle {
                width: 4px;
                height: 140px;
                background: red;
                position: absolute;
                bottom: 0;
                left: 50%;
                transform-origin: bottom center;
                transform: rotate(-90deg);
                transition: transform 0.5s ease-out;
            }

            .speed-text {
                position: absolute;
                width: 100%;
                text-align: center;
                bottom: -40px;
                font-size: 24px;
            }

            .lista-elegante {
                list-style: none;
                /* sin viñetas */
                padding: 0;
                /* sin padding del ul */
                margin: 0;
                /* eliminar margen del ul */
                font-family: "Georgia", "Times New Roman", serif;
                font-weight: normal;
                font-size: 16px;
                color: #333;
            }

            .lista-elegante li {
                display: flex;
                /* para alinear label y valor */
                justify-content: space-between;
                /* label a la izquierda, valor a la derecha */
                padding: 6px 12px;
                /* separación interna */
                border-bottom: 1px solid #ddd;
                /* línea sutil entre items */
                align-items: center;
                transition: background 0.3s;
            }

            .lista-elegante li:hover {
                background-color: #f9f9f9;
                /* efecto hover sutil */
            }

            .lista-elegante li span {
                /* resaltar valor */
                text-align: center;
                /* centrar contenido del span */
                min-width: 100px;
                /* ancho mínimo para centrar uniforme */
                display: inline-block;
                /* necesario para text-align */
            }
        </style>
        <style>
            .speedometer {
                position: relative;
                width: 300px;
                height: 150px;
                overflow: hidden;
            }

            /* Arcos de colores */
            .arc {
                position: absolute;
                width: 300px;
                height: 300px;
                border-radius: 50%;
                border: 20px solid transparent;
                border-top: 20px solid #f44336;
                border-right: 20px solid #ff9800;
                border-left: 20px solid #4caf50;
                border-bottom: 20px solid #cddc39;
                transform: rotate(180deg);
            }

            /* Centro blanco */
            .center {
                position: absolute;
                width: 220px;
                height: 220px;
                background: #f2f2f2;
                border-radius: 50%;
                top: 40px;
                left: 40px;
            }

            /* Aguja */
            .needle {
                position: absolute;
                width: 4px;
                height: 120px;
                background: #333;
                bottom: 0;
                left: 50%;
                transform-origin: bottom;
                transform: rotate(<?= $angulo ?>deg);
            }

            .needle::after {
                content: '';
                position: absolute;
                bottom: -10px;
                left: -8px;
                width: 20px;
                height: 20px;
                background: #333;
                border-radius: 50%;
            }

            .value {
                position: absolute;
                width: 100%;
                bottom: 10px;
                text-align: center;
                font-size: 22px;
                font-weight: bold;
            }
        </style>
    </head>
    <button onclick="abrirModal()">Ver usuarios</button>

    <div id="modalUsuarios" class="modal">
        <div class="modal-contenido">
            <span class="cerrar" onclick="cerrarModal()">&times;</span>
            <h2>Seleccionar Usuario</h2>

            <table id="tablaUsuarios">
                <thead>
                    <tr>
                        <th>Seleccionar</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Cédula</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Score</th>
                        <th>Tarjeta C.</th>
                        <th>Credito V.</th>
                        <th>Credito B.</th>
                        <th>Credito H.</th>
                        <th>Coactivos</th>
                        <th>Compania Tel.</th>
                        <th>Cooperativa</th>
                        <th>Otros</th>

                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-contenido {
            background-color: #fff;
            margin: 5% auto;
            padding: 20px;
            width: 90%;
            max-width: 1000px;
            border-radius: 8px;
            overflow-x: auto;
        }

        .cerrar {
            float: right;
            font-size: 28px;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #f4f4f4;
        }

        .centrado {
            display: inline-block;
            /* convertir a bloque en línea */
            width: 100%;
            /* ocupar todo el espacio del li */
            text-align: center;
            /* centrar su contenido */
        }

        li {
            display: flex;
            justify-content: space-between;
            /* nombre a la izquierda, span a la derecha */
        }

        .lista-elegante {
            flex: 1;
            text-align: center;
        }
    </style>
    <script>
        let idClienteSeleccionado = null;
    </script>
    <script>
        function abrirModal() {
            document.getElementById("modalUsuarios").style.display = "block";
            cargarUsuarios();
        }

        function cerrarModal() {
            document.getElementById("modalUsuarios").style.display = "none";
        }

        function cargarUsuarios() {
            fetch("usuarios.php")
                .then(res => res.json())
                .then(data => {
                    const tbody = document.querySelector("#tablaUsuarios tbody");
                    tbody.innerHTML = "";

                    data.forEach(u => {
                        tbody.innerHTML += `
                <tr>
                    <td>
                        <input type="radio" name="usuario"
                        onclick='seleccionarUsuario(${JSON.stringify(u)})'>
                    </td>
                    <td>${u.nombres}</td>
                    <td>${u.apellidos}</td>
                    <td>${u.cedula}</td>
                    <td>${u.correo}</td>
                    <td>${u.telefono}</td>
                    <td>${u.score}</td>
                    <th>${u.tarjetacredito}</th>
                    <th>${u.creditovehicular}</th>
                    <th>${u.creditosbancarios}</th>
                    <th>${u.creditohipotecario}</th>
                    <th>${u.coactivos}</th>
                    <th>${u.companiatelefonica}</th>
                    <th>${u.cooperativa}</th>
                    <th>${u.otros}</th>
                </tr>`;
                    });
                });
        }

        function seleccionarUsuario(u) {
            idClienteSeleccionado = u.uid; // 🔥 AQUÍ guardas el UID real

            document.getElementById("spNombre").innerText = u.nombres + " " + u.apellidos;
            document.getElementById("spCedula").innerText = u.cedula;
            document.getElementById("spTelefono").innerText = u.telefono;
            document.getElementById("spCorreo").innerText = u.correo;
            document.getElementById("spScore").innerText = u.score;
            document.getElementById("spCoactivos").innerText = u.coactivos;
            document.getElementById("spCompaniaTelefonica").innerText = u.companiatelefonica;
            document.getElementById("spCooperativa").innerText = u.cooperativa;
            document.getElementById("spCreditoHipotecario").innerText = u.creditohipotecario;
            document.getElementById("spCreditosBancarios").innerText = u.creditosbancarios;
            document.getElementById("spCreditoVehicular").innerText = u.creditovehicular;
            document.getElementById("spTarjetaCredito").innerText = u.tarjetacredito;
            document.getElementById("spOtros").innerText = u.otros;

            cerrarModal();
        }

    </script>



    <div class="container">
        <!-- Primera columna -->
        <div class="lista-elegante">
            <h4>Datos Personales</h4>
            <ul>
                <li>Nombre : <span class="lista-elegante centrado" id="spNombre"></span></li>
                <li>Cédula : <span class="lista-elegante centrado" id="spCedula"></span></li>
                <li>Teléfono : <span class="lista-elegante centrado" id="spTelefono"></span></li>
                <li>Correo : <span class="lista-elegante centrado" id="spCorreo"></span></li>
            </ul>
        </div>

        <!-- Segunda columna -->
        <?php
        $valor = 65; // 0 a 100
        $max_valor = 999; // máximo valor esperado
        $angulo = ($valor / $max_valor) * 180 - 90;
        ?>
        <div class="column">
            <h4>Score</h4>
            <ul>
                <li style="display:flex; justify-content:center;">
                    <div class="speedometer">
                        <div class="arc"></div>
                        <div class="center"></div>
                        <div class="value" id="spScore"></div>
                    </div>
                </li>
            </ul>
        </div>

        <!-- Tercera columna -->
        <div class="column">
            <h4>Otros</h4>
            <ul class="lista-elegante">
                <li>Creditos : <span class="lista-elegante centrado" id="spTotal">0</span></li>
                <li>Total : <span class="lista-elegante centrado" id="spTotal3">0</span></li>
            </ul>
        </div>
    </div>
    <br>
    <div class="container">
        <div class="column">

        </div>
        <div class="column">

            <div style="text-align: center;">
                <!-- Contador de carga -->
                <div id="contadorActualizacion" style="display:none; margin-bottom:10px;">
                    <div style="width: 80%; margin: auto; background: #eee; border-radius: 25px; overflow: hidden;">
                        <div id="barraProgreso"
                            style="width:0%; height:20px; background: linear-gradient(90deg,#4caf50,#81c784); border-radius:25px; transition: width 0.2s;">
                        </div>
                    </div>
                    <div id="porcentajeProgreso" style="margin-top:5px; font-weight:bold; color:#333;">0%</div>
                </div>

                <!-- Botón de actualización -->
                <button type="button" class="btn btn-success" onclick="confirmarActualizacion()">
                    Actualizar Información
                </button>
            </div>



            <script>


                function confirmarActualizacion() {

                    if (!idClienteSeleccionado) {
                        alert("Seleccione un usuario primero");
                        return;
                    }

                    const confirmacion = confirm("¿Estás seguro de que quieres actualizar la información?");
                    if (confirmacion) {

                        const datosUsuario = {
                            id_cliente: idClienteSeleccionado, // 👈 UID CORRECTO
                            coactivos: 0,
                            companiatelefonica: 0,
                            cooperativa: 0,
                            creditohipotecario: 0,
                            creditosbancarios: 0,
                            creditovehicular: 0,
                            otros: 0,
                            score: 997,
                            tarjetacredito: 0
                        };

                        actualizarUsuario(datosUsuario);
                    }
                }

                // Función para actualizar datos en la base de datos
                function actualizarUsuario(datos) {
                    const contenedor = document.getElementById('contadorActualizacion');
                    const barra = document.getElementById('barraProgreso');
                    const porcentaje = document.getElementById('porcentajeProgreso');

                    // Mostrar el contador
                    contenedor.style.display = 'block';
                    barra.style.width = '0%';
                    porcentaje.innerText = '0%';

                    // Animación de 1% a 100%
                    let progreso = 1;
                    const velocidad = 20; // ms entre cada incremento, ajustable
                    const interval = setInterval(() => {
                        barra.style.width = progreso + '%';
                        porcentaje.innerText = progreso + '%';
                        progreso++;
                        if (progreso > 100) {
                            clearInterval(interval);

                            // Después de llegar a 100%, actualizar los datos
                            setTimeout(() => {
                                // Aquí puedes llamar al fetch o simplemente mostrar mensaje
                                fetch('actualizar.php', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify(datos)
                                })
                                    .then(response => response.json())
                                    .then(result => {
                                        if (result.success) {
                                            alert("¡Actualización completada!");

                                            // Actualizar campos visibles
                                            document.getElementById('spScore').innerText = datos.score;
                                            document.getElementById('spCoactivos').innerText = datos.coactivos;
                                            document.getElementById('spCompaniaTelefonica').innerText = datos.companiatelefonica;
                                            document.getElementById('spCooperativa').innerText = datos.cooperativa;
                                            document.getElementById('spCreditoHipotecario').innerText = datos.creditohipotecario;
                                            document.getElementById('spCreditosBancarios').innerText = datos.creditosbancarios;
                                            document.getElementById('spCreditoVehicular').innerText = datos.creditovehicular;
                                            document.getElementById('spTarjetaCredito').innerText = datos.tarjetacredito;
                                            document.getElementById('spOtros').innerText = datos.otros;

                                            // Totales
                                            document.getElementById('spTotal').innerText = Number(datos.tarjetacredito) + Number(datos.otros);
                                            document.getElementById('spTotal2').innerText = Number(datos.creditohipotecario) + Number(datos.creditosbancarios);
                                            document.getElementById('spTotal3').innerText = Number(datos.creditohipotecario) + Number(datos.creditosbancarios);

                                            // Speedometer
                                            const score = Number(datos.score);
                                            const max_valor = 999;
                                            const angulo = (score / max_valor) * 180 - 90;
                                            document.querySelector('.needle').style.transform = `rotate(${angulo}deg)`;

                                            // Ocultar barra después de 1 segundo
                                            setTimeout(() => { contenedor.style.display = 'none'; }, 9000);

                                        } else {
                                            alert("Error al actualizar: " + (result.error || ""));
                                            contenedor.style.display = 'none';
                                        }
                                    })
                                    

                            }, 800); // pequeño delay al llegar a 100%
                        }
                    }, velocidad);
                }


            </script>

        </div>
        <div class="column">

        </div>
    </div>

    <br>
    <div class="container">
        <!-- Primera columna -->
        <div class="column">
            <h4>Creditos</h4>
            <ul class="lista-elegante">
                <li>Cooperativa : <span class="lista-elegante centrado" id="spCooperativa">0</span></li>
                <li>Credito Vehicular : <span class="lista-elegante centrado" id="spCreditoVehicular">0</span></li>
                <li>Credito Bancario : <span class="lista-elegante centrado" id="spCreditosBancarios">0</span></li>
                <li>Tarjeta de Credito : <span class="lista-elegante centrado" id="spTarjetaCredito">0</span></li>
                <li>Credito Telefonico : <span class="lista-elegante centrado" id="spCompaniaTelefonica">0</span></li>
                <li>Credito Hipotecario : <span class="lista-elegante centrado" id="spCreditoHipotecario">0</span></li>

            </ul>
        </div>

        <!-- Segunda columna -->
        <div class="column">
            <h4>Reportes</h4>
            <ul class="lista-elegante">

                <li>Coactivos : <span class="lista-elegante centrado spCoactivos" id="spCoactivos">0</span></li>
            </ul>
        </div>

        <!-- Tercera columna -->
        <div class="column">
            <h4>Otros</h4>
            <ul class="lista-elegante">
                <li>Reportes : <span class="lista-elegante centrado" id="spTotal2">0</span></li>
                <li>Creditos : <span class="lista-elegante centrado" id="spOtros">0</span></li>
            </ul>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>


    <footer>
        <?php
        include "../plantillas/footer.php";
        ?>
    </footer>

</body>

</html>