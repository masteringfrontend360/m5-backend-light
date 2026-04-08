<?php

define("IVA", 0.21);
define("TIENDA", "Tienda Antonio");

$precio_base = 100;
$precio_final = $precio_base + ($precio_base * IVA);

?>

<!DOCTYPE html>
<html>

<head>
<title>Ejercicio 4 PHP</title>

<style>

body{
    font-family: Arial;
    margin:40px;
    background:#f4f4f4;
}

.box{
    background:white;
    padding:20px;
    margin-bottom:20px;
    border-radius:8px;
    box-shadow:0 2px 6px rgba(0,0,0,0.1);
}

h2{
    color:#333;
}

.result{
    background:#eef;
    padding:10px;
    margin-top:10px;
}

</style>

</head>

<body>

<div class="box">

<h2>Uso de constantes en PHP</h2>

<p>
En este ejercicio definimos dos constantes y calculamos el precio final de un producto aplicando el IVA.
</p>

<div class="result">

Nombre de la tienda → <?php echo TIENDA; ?><br><br>

IVA aplicado → <?php echo IVA; ?><br><br>

Precio base → <?php echo $precio_base; ?> €<br><br>

Precio final → <?php echo $precio_final; ?> €

</div>

<p>

<b>Explicación:</b><br><br>

<b>IVA</b> es una constante con valor 0.21, que equivale al 21%.<br><br>

<b>TIENDA</b> es una constante con el nombre de la tienda.<br><br>

El producto cuesta 100 € y le aplicamos el IVA:<br><br>

100 + (100 × 0.21) = 121<br><br>

Por eso el precio final es <b>121 €</b>.

</p>

</div>

</body>
</html>
