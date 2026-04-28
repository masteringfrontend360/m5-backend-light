import ContactoModel from '../models/ContactoModel.js';
import { validarContacto } from '../utils/validaciones.js';

class ContactoController {
    // GET - Mostrar página de formulario
    static async mostrarFormulario(req, res) {
        res.render('index');
    }

    // GET - Mostrar página de listado
    static async mostrarListado(req, res) {
        try {
            const contactos = await ContactoModel.obtenerTodos();
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
    }

    // POST - Guardar contacto (formulario tradicional)
    static async guardarTradicional(req, res) {
        try {
            const { nombre, email, ciudad } = req.body;
            
            // Validar
            const validacion = validarContacto(nombre, email, ciudad);
            if (!validacion.valido) {
                return res.status(400).render('error', {
                    mensaje: validacion.error
                });
            }

            // Crear en BD
            await ContactoModel.crear(validacion.nombre, validacion.email, validacion.ciudad);

            // Redirigir
            res.redirect('/listado?success=1');
        } catch (err) {
            console.error('Error al guardar:', err.message);
            
            if (err.code === 'ER_DUP_ENTRY') {
                return res.status(400).render('error', {
                    mensaje: 'Ya existe un contacto con ese email'
                });
            }

            res.status(500).render('error', {
                mensaje: 'Error al guardar el contacto'
            });
        }
    }

    // POST - Guardar contacto (Fetch/AJAX)
    static async guardarAjax(req, res) {
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

            // Crear en BD
            await ContactoModel.crear(validacion.nombre, validacion.email, validacion.ciudad);

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
    }

    // GET - Obtener todos los contactos (JSON)
    static async obtenerTodos(req, res) {
        try {
            const contactos = await ContactoModel.obtenerTodos();
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
    }

    // DELETE - Eliminar un contacto
    static async eliminar(req, res) {
        try {
            const { id } = req.params;
            
            // Validar que sea un número
            if (!Number.isInteger(Number(id))) {
                return res.status(400).json({ 
                    success: false, 
                    error: 'ID inválido'
                });
            }

            // Eliminar de BD
            const eliminado = await ContactoModel.eliminar(id);

            if (!eliminado) {
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
    }
}

export default ContactoController;
