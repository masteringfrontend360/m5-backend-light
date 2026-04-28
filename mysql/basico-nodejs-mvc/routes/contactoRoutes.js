import express from 'express';
import ContactoController from '../controllers/ContactoController.js';

const router = express.Router();

// Rutas GET
router.get('/', ContactoController.mostrarFormulario);
router.get('/listado', ContactoController.mostrarListado);

// Rutas formulario tradicional
router.post('/guardar', ContactoController.guardarTradicional);

// Rutas API JSON (Fetch/AJAX)
router.post('/api/guardar', ContactoController.guardarAjax);
router.get('/api/contactos', ContactoController.obtenerTodos);
router.delete('/api/contacto/:id', ContactoController.eliminar);

export default router;
