<?php

// Ejercicio 5
// 1. Declara dos números
// 2. Realiza suma
// 3. Realiza resta
// 4. Realiza multiplicación
// 5. Realiza división
// 6. Muestra todos los resultados

$numero1 = 20;
$numero2 = 5;

$suma = $numero1 + $numero2;
$resta = $numero1 - $numero2;
$multiplicacion = $numero1 * $numero2;
$division = $numero1 / $numero2;

?>

<!DOCTYPE html>
<html>

<head>
<title>Ejercicio 5 PHP</title>

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

<h2>Expresiones y operaciones aritméticas</h2>

<p>
En este ejercicio realizamos operaciones matemáticas básicas con PHP.
</p>

<div class="result">

Numero 1 → <?php echo $numero1; ?><br><br>
Numero 2 → <?php echo $numero2; ?><br><br>

Suma → <?php echo $suma; ?><br><br>
Resta → <?php echo $resta; ?><br><br>
Multiplicación → <?php echo $multiplicacion; ?><br><br>
División → <?php echo $division; ?>

</div>

<p>

<b>Explicación:</b><br><br>

Suma → 20 + 5 = 25<br><br>

Resta → 20 - 5 = 15<br><br>

Multiplicación → 20 × 5 = 100<br><br>

División → 20 ÷ 5 = 4

</p>

</div>

</body>
</html>
