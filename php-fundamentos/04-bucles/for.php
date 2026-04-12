<?php
// for.php

// Ejercicio 1: Reescribir alguno de los ejercicios anteriores usando un bucle for.

for ($i=30; $i<=75; $i++){
  if ($i % 15 == 0){
    echo $i. " ";
  }
}
echo "<br><br>";


// Ejercicio 2: Mostrar todas las tablas de multiplicar del 1 al 10
// usando dos bucles for anidados.

for ($tabla = 1; $tabla <= 10; $tabla++) {

  echo "Tabla del $tabla<br>";

    for ($i=1; $i<=10; $i++){

      echo "$tabla x $i =" . ($tabla * $i) . "<br>";
    }
    echo "<br>";
}
?>


/*
Guía:
- El bucle for tiene tres partes: inicio; condición; actualización.
- Escoge uno de los ejercicios de while o do...while y pásalo a for.
- Para las tablas de multiplicar, usa un for exterior (tabla del 1 al 10)
  y un for interior (multiplicador del 1 al 10).
- Muestra cada operación en una línea: "a x b = resultado".
*/