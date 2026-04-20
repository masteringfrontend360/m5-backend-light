import express from 'express';
import { pool } from './conexion.js';

const app = express();
const PORT = process.env.PORT || 3000;

// Middleware
app.use(express.urlencoded({ extended: false }));
app.use(express.json());
app.use(express.static('public'));
app.set('view engine', 'ejs');

// ==================== UTILIDADES ====================

// Función para validar contacto
const validarContacto = (nombre, email, ciudad) => {
    nombre = (nombre || '').trim();
    email = (email || '').trim();
    ciudad = (ciudad || '').trim();

    if (!nombre || !email) {
        return { valido: false, error: 'Faltan campos obligatorios' };
    }

    if (nombre.length > 100) {
        return { valido: false, error: 'El nombre no puede superar 100 caracteres' };
    }

    if (email.length > 100) {
        return { valido: false, error: 'El email no puede superar 100 caracteres' };
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        return { valido: false, error: 'El email no es válido' };
    }

    if (ciudad.length > 50) {
        return { valido: false, error: 'La ciudad no puede superar 50 caracteres' };
    }

    return { valido: true, nombre, email, ciudad };
};

// ==================== RUTAS ====================

// GET - Mostrar formulario
app.get('/', (req, res) => {
    res.render('index');
});

// POST - Guardar contacto (formulario tradicional)
app.post('/guardar', async (req, res) => {
    try {
        // Recoger y limpiar datos
        const { nombre, email, ciudad } = req.body;
        
        // Validar
        const validacion = validarContacto(nombre, email, ciudad);
        if (!validacion.valido) {
            return res.status(400).render('error', {
                mensaje: validacion.error
            });
        }

        // Insertar en BD con consulta preparada
        const sql = 'INSERT INTO contactos (nombre, email, ciudad) VALUES (?, ?, ?)';
        await pool.execute(sql, [validacion.nombre, validacion.email, validacion.ciudad]);

        // Redirigir al listado
        res.redirect('/listado?success=1');
    } catch (err) {
        console.error('Error al guardar:', err.message);
        
        // Verificar si es error de entrada duplicada
        if (err.code === 'ER_DUP_ENTRY') {
            return res.status(400).render('error', {
                mensaje: 'Ya existe un contacto con ese email'
            });
        }

        res.status(500).render('error', {
            mensaje: 'Error al guardar el contacto'
        });
    }
});

// POST - Guardar contacto (fetch/AJAX)
app.post('/api/guardar', async (req, res) => {
    try {
        const { nombre, email, ciudad } = req.body;
        
        // Validar
        const validacion = validarContacto(nombre, email, ciudad);
        if (!validacion.valido) {
            return res.status(400).json({ 
                success: false, 
                error: validacion.error 
            });
        }

        // Insertar en BD
        const sql = 'INSERT INTO contactos (nombre, email, ciudad) VALUES (?, ?, ?)';
        await pool.execute(sql, [validacion.nombre, validacion.email, validacion.ciudad]);

        res.json({ 
            success: true, 
            mensaje: 'Contacto guardado correctamente'
        });
    } catch (err) {
        console.error('Error al guardar:', err.message);
        
        if (err.code === 'ER_DUP_ENTRY') {
            return res.status(400).json({ 
                success: false, 
                error: 'Ya existe un contacto con ese email'
            });
        }

        res.status(500).json({ 
            success: false, 
            error: 'Error al guardar el contacto'
        });
    }
});

// GET - Listar contactos (página)
app.get('/listado', async (req, res) => {
    try {
        const sql = 'SELECT id, nombre, email, ciudad, created_at FROM contactos ORDER BY created_at DESC';
        const [contactos] = await pool.execute(sql);

        res.render('listado', {
            contactos,
            success: req.query.success === '1'
        });
    } catch (err) {
        console.error('Error al obtener contactos:', err.message);
        res.status(500).render('error', {
            mensaje: 'Error al obtener los contactos'
        });
    }
});

// GET - Listar contactos (JSON para fetch/AJAX)
app.get('/api/contactos', async (req, res) => {
    try {
        const sql = 'SELECT id, nombre, email, ciudad, created_at FROM contactos ORDER BY created_at DESC';
        const [contactos] = await pool.execute(sql);
        
        res.json({ 
            success: true, 
            contactos 
        });
    } catch (err) {
        console.error('Error al obtener contactos:', err.message);
        res.status(500).json({ 
            success: false, 
            error: 'Error al obtener los contactos'
        });
    }
});

// DELETE - Eliminar contacto (fetch/AJAX)
app.delete('/api/contacto/:id', async (req, res) => {
    try {
        const { id } = req.params;
        
        // Validar que sea un número
        if (!Number.isInteger(Number(id))) {
            return res.status(400).json({ 
                success: false, 
                error: 'ID inválido'
            });
        }

        const sql = 'DELETE FROM contactos WHERE id = ?';
        const [result] = await pool.execute(sql, [id]);

        if (result.affectedRows === 0) {
            return res.status(404).json({ 
                success: false, 
                error: 'Contacto no encontrado'
            });
        }

        res.json({ 
            success: true, 
            mensaje: 'Contacto eliminado correctamente'
        });
    } catch (err) {
        console.error('Error al eliminar:', err.message);
        res.status(500).json({ 
            success: false, 
            error: 'Error al eliminar el contacto'
        });
    }
});

// Manejo de rutas no encontradas
app.use((req, res) => {
    res.status(404).render('error', {
        mensaje: 'Página no encontrada'
    });
});

// Iniciar servidor
app.listen(PORT, () => {
    console.log(`🚀 Servidor corriendo en http://localhost:${PORT}`);
});
