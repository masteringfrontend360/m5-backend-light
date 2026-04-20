import mysql from 'mysql2/promise';
import dotenv from 'dotenv';

dotenv.config();

const config = {
    host: process.env.DB_HOST,
    user: process.env.DB_USER,
    password: process.env.DB_PASS,
    database: process.env.DB_NAME,
    port: process.env.DB_PORT
};

// Crear pool de conexiones
export const pool = mysql.createPool(config);

// Verificar conexión
try {
    const connection = await pool.getConnection();
    console.log('✅ Conexión a MySQL establecida');
    connection.release();
} catch (err) {
    console.error('❌ Error al conectar a MySQL:', err.message);
    process.exit(1);
}
