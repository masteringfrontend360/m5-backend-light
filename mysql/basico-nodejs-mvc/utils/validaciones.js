// Validar datos del contacto
export const validarContacto = (nombre, email, ciudad) => {
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
