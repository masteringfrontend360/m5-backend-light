# Estructuras de decisión

## **1. Signo de un número**

Escribe un programa que solicite al usuario un número (desde un formulario) y muestre si el número es positivo, negativo o cero.

---

## **2. Número par o impar**

Escribe un programa que pida al usuario un número entero y muestre si es par o impar.

---

## **3. Resultado de una nota**

Escribe un programa que solicite una calificación numérica entre 0 y 10 y muestre el mensaje “Aprobado” si la nota es mayor o igual que 5, o “Suspendido” si es menor que 5.

> **Opcional: resuelve el ejercicio primero usando `if/else` y después usando el operador ternario.**
> 

---

## **4. Clasificación por edad**

Escribe un programa que pida la edad de una persona y muestre en qué categoría se encuentra:

- “Niño” si la edad está entre 0 y 12 años.
- “Adolescente” si la edad está entre 13 y 17 años.
- “Adulto” si la edad está entre 18 y 64 años.
- “Jubilado” si la edad es 65 o más.

---

## **5. Día de la semana**

Escribe un programa que solicite un número entre 1 y 7 y muestre el nombre del día de la semana correspondiente (1: lunes, 2: martes, etc.).

> **Opcional: intenta resolverlo primero con `if/elseif` o `switch`, y, si trabajas con PHP 8 o superior, vuelve a hacerlo usando `match`.**


---


## **6. Aviso de carrito vacío**


Crea una sección del carrito que muestre un mensaje apropiado según el contenido. Tienes estos datos:

```php
$carrito = [
    ['nombre' => 'Camiseta', 'precio' => 19.99, 'cantidad' => 2],
    ['nombre' => 'Pantalón', 'precio' => 39.99, 'cantidad' => 1]
];
// o también puede estar vacío: $carrito = [];
```

**¿Qué mostrar?**

- Si está vacío: "Tu carrito está vacío 😔"
- Si tiene productos: "Tienes X productos en el carrito"

**💡 Pensar:**

1. ¿Cuántos elementos tiene realmente un array vacío?
2. ¿`empty($carrito)` te dice la verdad completa?
3. ¿Qué pasa si usas count() vs si usas if (!$carrito)?
4. ¿Te animas con sintaxis alternativa para meter el HTML?

---

## **7. Tabla de productos**

Recorre el carrito y genera una tabla HTML con columnas: Producto | Cantidad | Precio unit. | Subtotal.

```php
$productos = [
    ['nombre' => 'Camiseta', 'cantidad' => 2, 'precio' => 19.99],
    ['nombre' => 'Pantalón', 'cantidad' => 1, 'precio' => 39.99],
    ['nombre' => 'Calcetines', 'cantidad' => 3, 'precio' => 5.99]
];
```

**💡Pensar:**

1. ¿Qué dos formas tiene foreach para recorrer arrays asociativos?
2. ¿Cómo calculas subtotal = cantidad × precio?
3. ¿number_format() te ayuda con los decimales?
4. Mira si puedes usar sintaxis alternativa: foreach: endforeach;
5. ¿Qué pasa si usas &$producto? ¿Cambiarías algo del array?

## **8. Clases CSS con match**

Según el estado del pedido, asigna la clase Bootstrap correcta para un badge. Los estados posibles son: `'pending'`, `'processing'`, `'shipped'`, `'delivered'`.

```php
$pedido = ['estado' => 'processing']; // o puede ser otro
```

**Clases esperadas:**

```php
textpending → badge-warning
processing → badge-info  
shipped → badge-primary
delivered → badge-success
```

**💡 Pensar:**

1. match puede devolver directamente la clase CSS
2. ¿Qué tal un default para estados desconocidos?
3. ¿match necesita break como switch?
4. ¿Podrías usar la misma lógica en una plantilla con sintaxis alternativa?
5. ¿Cómo probarías que funciona? echo "<span class='badge $clase'>Estado</span>"