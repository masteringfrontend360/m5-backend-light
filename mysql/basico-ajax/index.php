<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir contacto</title>
     <style>
       body {
    font-family: sans-serif;
    max-width: 600px;
    margin: 2rem auto;
    padding: 1rem;
}

label {
    display: inline-block;
    margin-bottom: 0.35rem;
    font-weight: 600;
}

input {
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
    padding: 0.65rem 0.75rem;
    font: inherit;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    background: #fff;
    transition: border-color .2s ease, box-shadow .2s ease, background-color .2s ease;
    margin-bottom: 0.25rem;
}

input:focus {
    outline: none;
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
}

/* Campo inválido */
input[aria-invalid="true"] {
    border-color: #dc2626;
    background-color: #fef2f2;
    box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.12);
}

/* Mensajes de error */
[id^="error-"]  {
    margin-top: 0;
    margin-bottom: 1rem;
    min-height: 1.2em;
    color: #b91c1c;
    font-size: 0.9rem;
    line-height: 1.4;
}

/* Mensaje general */
#mensaje {
    margin-top: 1rem;
    color: #991b1b;
    font-weight: 600;
}

button {
    font: inherit;
    padding: 0.7rem 1rem;
    border: 0;
    border-radius: 8px;
    background: #0f172a;
    color: white;
    cursor: pointer;
}

button:hover {
    background: #1e293b;
}
    </style>
</head>
<body>
    <h1>📧 Añadir contacto</h1>
    
    <form action="guardar-ajax.php" method="POST" novalidate id="formularioAjax">
         <div>
            <label for="nombre">Nombre:</label><br>
            <input type="text" id="nombre" name="nombre" required maxlength="100">
            <p id="error-nombre"></p>
</div>

        <div>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required maxlength="100">
            <p id="error-email"></p>
</div>

        <div>
            <label for="ciudad">Ciudad:</label><br>
            <input type="text" id="ciudad" name="ciudad" maxlength="50">
            <p id="error-ciudad" ></p>
</div>

        <button type="submit">💾 Guardar contacto</button>
    </form>
<p id="mensaje"></p>
    <p><a href="listado.php">📋 Ver todos los contactos</a></p>

 <script>
        const formulario = document.getElementById('formularioAjax');
        const errorNombre = document.getElementById('error-nombre');
        const errorEmail = document.getElementById('error-email');
        const errorCiudad = document.getElementById('error-ciudad');
        const mensaje = document.getElementById('mensaje');
        
        const inputNombre = document.getElementById('nombre');
        const inputEmail = document.getElementById('email');
        const inputCiudad = document.getElementById('ciudad');

        inputNombre.setAttribute('aria-invalid', 'false');
        inputEmail.setAttribute('aria-invalid', 'false');
        inputCiudad.setAttribute('aria-invalid', 'false');

        formulario.addEventListener('submit', async function (e) {
            e.preventDefault();

            errorNombre.textContent = '';
            errorEmail.textContent = '';
            errorCiudad.textContent = '';
            mensaje.textContent = '';
            
            inputNombre.setAttribute('aria-invalid', 'false');
            inputEmail.setAttribute('aria-invalid', 'false');
            inputCiudad.setAttribute('aria-invalid', 'false');

            const datos = new FormData(formulario);

            try {
                const respuesta = await fetch('guardar-ajax.php', {
                    method: 'POST',
                    body: datos
                });
                /*
                |--------------------------------------------------------------------------
                |Comprobar que el servidor realmente responde JSON antes de parsear. MDN
                |https://developer.mozilla.org/es/docs/Web/API/Fetch_API/Using_Fetch
                |--------------------------------------------------------------------------
                */
                const tipo = respuesta.headers.get('content-type') || '';

                if (!tipo.includes('application/json')) {
                        throw new Error('La respuesta no es JSON');
                }


                const resultado = await respuesta.json();

                if (!respuesta.ok) {
                    if (resultado.errores?.nombre) {
                        errorNombre.textContent = resultado.errores.nombre;
                        inputNombre.setAttribute('aria-invalid', 'true');
                    }

                    if (resultado.errores?.email) {
                        errorEmail.textContent = resultado.errores.email;
                        inputEmail.setAttribute('aria-invalid', 'true');
                    }
                    
                    if (resultado.errores?.ciudad) {
                        errorCiudad.textContent = resultado.errores.ciudad;
                        inputCiudad.setAttribute('aria-invalid', 'true');
                    }
                     if (resultado.errores?.general) {
                        mensaje.textContent = resultado.errores.general;
                     }

                    return; 
                }

               if (resultado.redirectTo) {
                    window.location.href = resultado.redirectTo;
                    return;
               }

                mensaje.textContent = 'Guardado correctamente';

            } catch (error) {
                mensaje.textContent = 'Ha ocurrido un error en la petición.';
                 console.error(error);
            }
        });

    </script>
    </body>
</html>