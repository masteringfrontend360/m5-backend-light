<?php
function formatear_precio (float $precio): string {
    return number_format($precio, 2, ',', '.') . '€';
}
obtener_estado_stock (int $stock): string {
    if($stock >= 10){

    }

}