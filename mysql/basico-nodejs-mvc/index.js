import express from 'express';
import './config/database.js';
import contactoRoutes from './routes/contactoRoutes.js';

const app = express();
const PORT = process.env.PORT || 3000;

// Middleware
app.use(express.urlencoded({ extended: false }));
app.use(express.json());
app.use(express.static('public'));
app.set('view engine', 'ejs');

// Rutas
app.use('/', contactoRoutes);

// Manejo de rutas no encontradas
app.use((req, res) => {
    res.status(404).render('error', {
        mensaje: 'Página no encontrada'
    });
});

// Iniciar servidor
app.listen(PORT, () => {
    console.log(`🚀 Servidor MVC corriendo en http://localhost:${PORT}`);
});
