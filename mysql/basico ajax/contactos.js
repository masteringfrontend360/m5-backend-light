// contactos.js — lógica AJAX para index.php y listado.php

// ─── Formulario de index.php ──────────────────────────────────────────────────
const form = document.getElementById('form-contacto');

if (form) {
    form.addEventListener('submit', async function (e) {
        e.preventDefault(); // Evita el envío tradicional (recarga de página)

        const btn = document.getElementById('btn-guardar');
        btn.disabled = true;
        btn.textContent = 'Guardando…';

        // FormData recoge automáticamente todos los campos del formulario
        const datos = new FormData(form);

        try {
            const respuesta = await fetch('guardar.php', {
                method: 'POST',
                body: datos
            });

            // Convertimos la respuesta a JSON
            const json = await respuesta.json();

            const mensaje = document.getElementById('mensaje');

            if (json.ok) {
                mostrarMensaje('✅ Contacto guardado correctamente', 'ok');
                form.reset();
            } else {
                mostrarMensaje('❌ ' + json.error, 'err');
            }

        } catch (error) {
            // Fallo de red o respuesta que no es JSON
            mostrarMensaje('❌ Error de conexión con el servidor', 'err');
        } finally {
            btn.disabled = false;
            btn.textContent = '💾 Guardar contacto';
        }
    });
}

function mostrarMensaje(texto, tipo) {
    const el = document.getElementById('mensaje');
    el.textContent = texto;
    el.className = tipo;
    el.style.display = 'block';

    // Se oculta solo después de 4 segundos
    setTimeout(() => { el.style.display = 'none'; }, 4000);
}


// ─── Recarga de tabla en listado.php ─────────────────────────────────────────
const tbody = document.getElementById('tbody-contactos');

if (tbody) {
    cargarContactos();

    // Recarga la tabla cada 30 segundos sin recargar la página
    setInterval(cargarContactos, 30000);
}

async function cargarContactos() {
    try {
        const respuesta = await fetch('listado.php', {
            // Esta cabecera es la que PHP comprueba con HTTP_X_REQUESTED_WITH
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });

        const json = await respuesta.json();

        if (!json.ok) return;

        // Actualizar el contador del <h1>
        const total = document.getElementById('total');
        if (total) total.textContent = json.contactos.length;

        // Ocultar el mensaje "no hay contactos" si ya hay alguno
        const vacio = document.getElementById('vacio');
        if (vacio) vacio.style.display = json.contactos.length ? 'none' : 'block';

        // Reconstruir las filas de la tabla
        tbody.innerHTML = json.contactos.map(c => `
            <tr>
                <td>${escaparHTML(String(c.id))}</td>
                <td>${escaparHTML(c.nombre)}</td>
                <td>${escaparHTML(c.email)}</td>
                <td>${escaparHTML(c.ciudad ?? '')}</td>
                <td>${formatearFecha(c.created_at)}</td>
            </tr>
        `).join('');

    } catch (error) {
        console.error('Error al cargar contactos:', error);
    }
}

// Equivalente JS del htmlspecialchars de PHP
function escaparHTML(texto) {
    const div = document.createElement('div');
    div.textContent = texto;
    return div.innerHTML;
}

// Equivalente JS del date('d/m/Y H:i', strtotime(...)) de PHP
function formatearFecha(fechaSQL) {
    const fecha = new Date(fechaSQL.replace(' ', 'T')); // MySQL usa espacio, JS necesita T
    return fecha.toLocaleString('es-ES', {
        day: '2-digit', month: '2-digit', year: 'numeric',
        hour: '2-digit', minute: '2-digit'
    });
}