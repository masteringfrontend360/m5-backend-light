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

### 1. Clonar (primera vez).
Te situas en la carpeta donde quieras clonar el repo, por ejemplo, /var/www/html
```bash
git clone https://github.com/masteringfrontend360/m5-backend-light.git
cd m5-backend-light
code .  # VS Code + WSL
```

### 2. Rama por alumno
He pensado que en este curso vamos a trabajar con ramas. De manera que tendremos el repo principal y cada alumno colaborará en el repo creando su propia rama y resolviendo ahí los ejercicios planteados.

Se pueden crear ramas locales y trabajar en ellas pero para poder subirlas a GitHub necesitaréis disponer de una cuentta y decirme vuestro nombre de usuario para poder añadiros como colaboradores del repo.

```bash
git checkout -b nombreRama # Crea una rama con el nombre proporcionado y te mete dentro de la rama
```

### 3. Resolver
A partir de ahí vas resolviendo los diferentes ejercicios planteados de forma local. Puedes crear tantos commits como desees.
```bash
git add .               # Preparar cambios. Los pone verdes
git commit -m "Ej01-07: Variables + formulario POST"
```


### 4. Publicar en GitHub
Antes de irte a casa, cada día, o cuando completes alguna parte puedes publicar todos estos cambios en GitHub. GitHub detecta tu rama y crea automáticamente botón **Compare & pull request**

```bash
git push origin nombreRama  # SUBE ✓
```

### 5. Cuando llegues a casa (primera vez)
Puedes clonar el repo de la misma forma que hicieste en el paso 1.
Cuando clonas el repo no tienes creada ninguna rama en local. Compruébalo:

```bash
git branch
```
Pero puedes seguir cualquiera de las ramas del proyecto.

```bash
git branch -r # Listado de ramas remotas
git checkout nombreRama # Inica el nombre de la rama que quieres recuperar para seguir trabajando en tu rama. Este comando te situa en tu rama y crea esa rama como rama local.
```

### 6. Todos los días (menos la primera vez, en el cualquiera de los equipos locales)

```bash
 
git fetch origin            # Descarga TODO: cambios en main, tu rama, otras ramas
                            # Actualiza origin/main y origin/nombreRama
                            # NO modifica tus archivos locales
git checkout nombreRama     # Cambia a tu rama local (ya sincronizada)
git pull origin nombreRama  # Fusiona cambios de TU rama remota con la local
git status                  # ✅ VERIFICA todo OK
```
### 7. Dar por bueno un ejercicio o set de ejercicios de un rama y añadirlo a la rama principal
```bash
git checkout main           # Cambia a tu rama a main
git pull origin main        # Asegúrate que tienes el último estado de main
git checkout nombreRama -- ruta/del/fichero.txt
git commit -m "Copiar fichero desde nombreRama"
git push origin main
```

## 🛠️ Entorno desarrollo

- **WSL + Debian + LAMP** (no XAMPP)
- **VS Code** + extensión PHP Intelephense
- **php -S localhost:8000** para pruebas
- **Apache** `/var/www/html` para navegador


## 🎓 Objetivos finales

- **PHP**: Sintaxis → POO → APIs
- **MySQL**: BD reales para WordPress
- **AJAX**: Frontend ↔ Backend
- **WordPress**: Custom Post Types, metaboxes, REST API
- **Git**: Ramas, PRs, colaboración profesional

**Este repo = tu portfolio backend frontend.** 💼

---
**Máster Frontend Developer | Centro Salvador Allende | Zaragoza Dinámica**
