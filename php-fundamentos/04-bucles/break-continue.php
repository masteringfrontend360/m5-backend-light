<?php
// break_continue.php

// Ejercicio 1:
// Usar un bucle for para encontrar el primer número divisible por 7
// entre 1 y 100, y detener la ejecución con break al encontrarlo.


for ($contador = 1; $contador <= 100; $contador++) {
    if ($contador % 7 === 0) {
        echo "El resultado del primer ejercicio: $contador";
        break;
    }
}



// Ejercicio 2:
// Usar un bucle for para mostrar los números del 1 al 20,
// saltando los múltiplos de 3 con continue.

for ($contador = 1; $contador <= 20; $contador++) {
    if ($contador % 3 === 0) {
        continue;
    }
    echo $contador;
}

/*
Guía:
- Recorre el rango con un for.
- Dentro del bucle, usa if para comprobar si el número cumple la condición.
- En el primer ejercicio, cuando lo cumpla, muestra el número y usa break.
- En el segundo, si el número es múltiplo de 3, usa continue para saltarlo.
*/