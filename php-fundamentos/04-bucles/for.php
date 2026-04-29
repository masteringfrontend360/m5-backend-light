<?php
// for.php

// Ejercicio 1: Reescribir alguno de los ejercicios anteriores usando un bucle for.
// Suma de impares (0 a 10)
$suma = 0;
for ($contador = 0; $contador <= 10; $contador++) {
  if ($contador % 2 !== 0) {
    $suma += $contador;
}
}
echo $suma;
// Ejercicio 2: Mostrar todas las tablas de multiplicar del 1 al 10
// usando dos bucles for anidados.
for ($tabla = 1; $tabla <= 10; $tabla++) {
  for ($multiplicador = 1; $multiplicador <= 10; $multiplicador++) {
  $resultado = $tabla * $multiplicador;
  echo $tabla . " x " . $multiplicador . " = " . $resultado . "<br>"; 
  }
}

/*
Guía:
- El bucle for tiene tres partes: inicio; condición; actualización.
- Escoge uno de los ejercicios de while o do...while y pásalo a for.
- Para las tablas de multiplicar, usa un for exterior (tabla del 1 al 10)
  y un for interior (multiplicador del 1 al 10).
- Muestra cada operación en una línea: "a x b = resultado".
*/