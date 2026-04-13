<!-- ## **Ejercicio 4: Checkbox múltiple (20-25 min)**

**Objetivo:** Arrays desde formularios + `$_POST` con corchetes `[]`.

**Enunciado:**

Crea un formulario con **checkbox** para "Habilidades frontend" (HTML, CSS, JS, SEO, WordPress; al menos 5).

Al enviar, recoge el array `$_POST['habilidades']` y muestra: 

"Tus habilidades: **HTML, CSS, WordPress**" (lista con comas).

**💡 Pistas:**

1. Checkbox: `<input type="checkbox" name="habilidades[]" value="HTML">` (¡nota los `[]`!).
2. Recoge: `$habilidades = $_POST['habilidades'] ?? [];`
3. Muestra: `echo implode(', ', $habilidades);`
4. Como checkboxes de "atributos de producto". -->