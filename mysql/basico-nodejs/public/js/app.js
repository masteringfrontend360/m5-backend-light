// ==================== GUARDAR CONTACTO CON FETCH ====================

async function guardarContactoFetch(e) {
    e.preventDefault();

    const nombre = document.getElementById('nombre').value;
    const email = document.getElementById('email').value;
    const ciudad = document.getElementById('ciudad').value;

    try {
        const response = await fetch('/api/guardar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ nombre, email, ciudad })
        });

        const datos = await response.json();

        if (datos.success) {
            mostrarMensaje('✅ ' + datos.mensaje, 'success');
            document.getElementById('formulario').reset();
            // Cargar contactos si existe la tabla
            if (document.getElementById('tabla-contactos')) {
                cargarContactosFetch();
            }
            // O redirigir
            setTimeout(() => {
                window.location.href = '/listado?success=1';
            }, 1500);
        } else {
            mostrarMensaje('❌ ' + datos.error, 'error');
        }
    } catch (err) {
        console.error('Error:', err);
        mostrarMensaje('❌ Error en la solicitud', 'error');
    }
}

// ==================== CARGAR CONTACTOS CON FETCH ====================

async function cargarContactosFetch() {
    try {
        const response = await fetch('/api/contactos');
        const datos = await response.json();

        if (datos.success) {
            mostrarContactos(datos.contactos);
        } else {
            mostrarMensaje('❌ ' + datos.error, 'error');
        }
    } catch (err) {
        console.error('Error:', err);
        mostrarMensaje('❌ Error al cargar contactos', 'error');
    }
}

// ==================== MOSTRAR CONTACTOS EN TABLA ====================

function mostrarContactos(contactos) {
    const tbody = document.querySelector('#tabla-contactos tbody');
    tbody.innerHTML = '';

    if (contactos.length === 0) {
        document.getElementById('sin-contactos').style.display = 'block';
        document.getElementById('tabla-contactos').style.display = 'none';
        return;
    }

    document.getElementById('sin-contactos').style.display = 'none';
    document.getElementById('tabla-contactos').style.display = 'table';

    contactos.forEach(contacto => {
        const fecha = new Date(contacto.created_at).toLocaleString('es-ES');
        const fila = document.createElement('tr');
        fila.innerHTML = `
            <td>${contacto.id}</td>
            <td>${escapeHtml(contacto.nombre)}</td>
            <td>${escapeHtml(contacto.email)}</td>
            <td>${escapeHtml(contacto.ciudad || '')}</td>
            <td>${fecha}</td>
            <td>
                <button class="btn-eliminar" onclick="eliminarContactoFetch(${contacto.id})">
                    🗑️ Eliminar
                </button>
            </td>
        `;
        tbody.appendChild(fila);
    });

    // Actualizar contador
    const contador = document.getElementById('contador-contactos');
    if (contador) {
        contador.textContent = contactos.length;
    }
}

// ==================== ELIMINAR CONTACTO CON FETCH ====================

async function eliminarContactoFetch(id) {
    if (!confirm('¿Estás seguro de que deseas eliminar este contacto?')) {
        return;
    }

    try {
        const response = await fetch(`/api/contacto/${id}`, {
            method: 'DELETE'
        });

        const datos = await response.json();

        if (datos.success) {
            mostrarMensaje('✅ ' + datos.mensaje, 'success');
            cargarContactosFetch();
        } else {
            mostrarMensaje('❌ ' + datos.error, 'error');
        }
    } catch (err) {
        console.error('Error:', err);
        mostrarMensaje('❌ Error al eliminar', 'error');
    }
}

// ==================== UTILIDADES ====================

function mostrarMensaje(texto, tipo) {
    const contenedor = document.getElementById('mensajes');
    if (!contenedor) return;

    const alerta = document.createElement('div');
    alerta.className = `alerta alerta-${tipo}`;
    alerta.textContent = texto;

    contenedor.innerHTML = '';
    contenedor.appendChild(alerta);

    setTimeout(() => {
        alerta.remove();
    }, 3000);
}

function escapeHtml(texto) {
    const div = document.createElement('div');
    div.textContent = texto;
    return div.innerHTML;
}

// ==================== INICIALIZACIÓN ====================

document.addEventListener('DOMContentLoaded', () => {
    // Si existe el formulario, agregar listener
    const formulario = document.getElementById('formulario');
    if (formulario) {
        formulario.addEventListener('submit', guardarContactoFetch);
    }

    // Si existe la tabla de contactos, cargar datos
    if (document.getElementById('tabla-contactos')) {
        cargarContactosFetch();
    }
});
