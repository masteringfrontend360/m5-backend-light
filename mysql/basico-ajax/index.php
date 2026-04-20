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

        input, button {
            font: inherit;
            padding: 0.5rem;
        }

        input {
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
        }

        p {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <h1>📧 Añadir contacto</h1>
    
    <form action="guardar-ajax.php" method="POST" novalidate id="formularioAjax">
         <p>
            <label for="nombre">Nombre:</label><br>
            <input type="text" id="nombre" name="nombre" required maxlength="100">
            <p id="error-nombre"></p>
        </p>

        <p>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required maxlength="100">
            <p id="error-email"></p>
        </p>

        <p>
            <label for="ciudad">Ciudad:</label><br>
            <input type="text" id="ciudad" name="ciudad" maxlength="50">
            <p id="error-ciudad"></p>
        </p>

        <button type="submit">💾 Guardar contacto</button>
    </form>
<p id="mensaje"></p>
    <p><a href="listado.php">📋 Ver todos los contactos</a></p>
</body>
</html>
 <script>
        const formulario = document.getElementById('formularioAjax');
        const errorNombre = document.getElementById('error-nombre');
        const errorEmail = document.getElementById('error-email');
        const errorCiudad = document.getElementById('error-ciudad');
        const mensaje = document.getElementById('mensaje');

        formulario.addEventListener('submit', async function (e) {
            e.preventDefault();

            errorNombre.textContent = '';
            errorEmail.textContent = '';
            mensaje.textContent = '';

            const datos = new FormData(formulario);

            try {
                const respuesta = await fetch('guardar-ajax.php', {
                    method: 'POST',
                    body: datos
                });

                const resultado = await respuesta.json();

                if (!respuesta.ok) {
                    if (resultado.errores?.nombre) {
                        errorNombre.textContent = resultado.errores.nombre;
                    }

                    if (resultado.errores?.email) {
                        errorEmail.textContent = resultado.errores.email;
                    }
                    
                    if (resultado.errores?.email) {
                        errorCiudad.textContent = resultado.errores.ciudad;
                    }

                    return; // nunca llega a la línea 69 porque sale de la función de la línea 40. Saca de la función
                }

                mensaje.textContent = resultado.mensaje;
                formulario.reset();

            } catch (error) {
                mensaje.textContent = 'Ha ocurrido un error en la petición.';
            }
        });

    </script>