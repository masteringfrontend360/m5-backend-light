<!-- ## **8. Clases CSS con match**

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
5. ¿Cómo probarías que funciona? echo "<span class='badge $clase'>Estado</span>" -->