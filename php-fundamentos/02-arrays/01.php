<!DOCTYPE html>
<html>
<head><title>Ej1 Arrays</title></head>
<body>
<?php
// Crea un array indexado con 4 tecnologías que conoces
$tecnologias = ['html', 'css', 'javascript', 'php'];

// Muestra el primer elemento (índice 0)
echo $tecnologias[0];

// Muestra el último elemento (índice 3 o count()-1) -->
echo $tecnologias[3];

$tecnologias = array(2, 2.2, 'dos', true );

// TODO: Muestra el primer elemento (índice 0)
// $tecnlogias[] = array();

var_dump($tecnologias[0]);


// <!-- TODO: Muestra el último elemento (índice 3 o count()-1) -->
var_dump($tecnologias[3]);
?>
</body>
</html>