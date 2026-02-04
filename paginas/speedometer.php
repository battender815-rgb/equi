<?php
$valor = 65; // 0 a 100
$angulo = ($valor / 100) * 180 - 90;
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Speedometer</title>

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

<body>

<div class="speedometer">
    <div class="arc"></div>
    <div class="center"></div>
    <div class="needle"></div>
    <div class="value"><?= $valor ?>%</div>
</div>

</body>
</html>
