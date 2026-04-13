Objetivo: Array multidimensional + ordenación + mostrar en HTML.

Enunciado:

Crea un array $productos con 4 productos (cada uno con nombre, precio, stock, foto como URL placeholder tipo https://via.placeholder.com/200x150?text=Producto).

Muéstralos en tarjetas HTML.

Añade un <select> para ordenar por precio (asc/desc). Al enviar, reordena con asort() o arsort() y muestra el catálogo ordenado.

💡 Pistas:

Estructura: $productos = [ ['nombre'=>'Camiseta', 'precio'=>19.95, 'stock'=>10, 'foto'=>'url'], ... ];
Tarjeta HTML: <div class="producto"><img src="..."> <h3>...</h3> <p>€...</p></div>.
Ordena con if ($_POST['orden'] == 'asc') asort($productos); (usa clave 'precio').
Este array es lo que devuelve wc_get_products(). Transición: $productos = [ ... ]; → $productos = wc_get_products(['limit'=>4]);
¡Prueba! Usa print_r($productos); para depurar antes de mostrar.