# 🚀 M5 Backend Light: PHP, MySQL y WordPress para Frontenders

**150h | 6 abril - 15 mayo 2026 | Zaragoza Dinámica**

**De HTML/CSS frontend a backend completo con PHP + WordPress.**

## 📚 Programa del curso (7 bloques)

| Bloque | Temas clave |
|--------|-------------|
| **1. PHP Moderno** | Sintaxis, POO, namespaces, errores PSR [php-fundamentos/] |
| **2. MySQL** | Diseño BD, SQL avanzado, phpMyAdmin |
| **3. CRUD + Formularios** | Leer/escribir BD, GET/POST, validación |
| **4. JS + AJAX** | fetch(), JSON, comunicación frontend-backend |
| **5. Seguridad** | XSS/SQLi/CSRF, prepared statements |
| **6. WordPress** | Actions/filters, CPT, metaboxes, REST API |
| **7. Despliegue** | Apache/Nginx, LAMP en producción |

## 📁 Estructura actual (php-fundamentos)
```
php-fundamentos/
├── 01-variables/ # Tipos, constantes, $_POST
├── 02-arrays/
├── 03-condicionales/
├── 04-bucles/
├── 05-funciones/ # Próximamente
└── 06-poo-basica/ # Próximamente
```

**Próximamente:**
```
mysql-fundamentos/
wordpress-integracion/
ajax-crud/
```


## ⚡ Workflow Git para alumnos

### 1. Clonar (primera vez)
```bash
git clone https://github.com/masteringfrontend360/m5-backend-light.git
cd m5-backend-light
code .  # VS Code + WSL
```

### 2. Rama por práctica
```bash
git checkout -b tuusuario-01-variables
```

### 3. Resolver + SUBIR
Edita: php-fundamentos/01-variables/01-tipos.php hasta 07-formulario.php
```bash
git status              # Ve cambios
git log --oneline       # Historial
git push origin tuusuario-01-variables  # SUBE ✓
```

GitHub detecta tu rama  y crea automáticamente botón **Compare & pull request**


## 🛠️ Entorno desarrollo

- **WSL + Debian + LAMP** (no XAMPP)
- **VS Code** + extensión PHP Intelephense
- **php -S localhost:8000** para pruebas
- **Apache** `var/www/html` para navegador

## 📋 Comandos Git esenciales
```bash
git status # Ve cambios rojos
git add . # Preparar cambios. Los pone verdes
git commit -m "Ej01-07: Variables + formulario POST"
git push origin tuusuario-01-variables  # SUBE A GITHUB ✓
git log --oneline # Historial
```


## 🎓 Objetivos finales

- **PHP**: Sintaxis → POO → APIs
- **MySQL**: BD reales para WordPress
- **AJAX**: Frontend ↔ Backend
- **WordPress**: Custom Post Types, metaboxes, REST API
- **Git**: Ramas, PRs, colaboración profesional

**Este repo = tu portfolio backend frontend.** 💼

---
**Máster Frontend Developer | Centro Salvador Allende | Zaragoza Dinámica**
