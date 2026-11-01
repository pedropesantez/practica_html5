## Hecho por:
Pedro Pesántez
# Práctica: Sitio Web de Instrumentos Musicales con HTML5, CSS3, PHP y MySQL

## 1. Descripción del Proyecto
Sitio web informativo sobre instrumentos musicales de banda (Bajo Eléctrico, Guitarra Eléctrica, Batería y Sintetizadores) desarrollado con HTML5 semántico y estilizado íntegramente con CSS3 (Flexbox, Modelo de Caja, Herencia y Diseño Responsivo). Integra un módulo de contacto con validación del lado del servidor en PHP, almacenamiento seguro mediante consultas preparadas (`MySQLi`) y visualización de registros protegida con `htmlspecialchars()`.

- **Autor:** Pedro Xavier Pesántez Urgilés
- **Versión estática anterior (GitHub Pages):** [Enlace a tu GitHub Pages anterior]

## 2. Requisitos del Entorno
- **XAMPP** (Apache + PHP 8.x + MySQL / MariaDB).
- Navegador web moderno (Firefox, Chrome, Brave).

## 3. Configuración de la Base de Datos
1. Iniciar los servicios **Apache** y **MySQL** desde el panel de control de XAMPP.
2. Abrir **phpMyAdmin** en `http://localhost/phpmyadmin/` o usar la terminal de MySQL.
3. Importar el archivo `database/practica_db.sql` incluido en este repositorio (creará automáticamente la base de datos `practica_db` y la tabla `mensajes_contacto`).
4. Verificar las credenciales en `pages/conexion.php`:
   - **Servidor:** `localhost`
   - **Usuario:** `pedro` (o `root` sin contraseña en una instalación limpia de XAMPP)
   - **Contraseña:** `12345`
   - **Base de datos:** `practica_db`

## 4. Pasos de Ejecución en XAMPP
1. Clonar o descomprimir este repositorio dentro de la carpeta `htdocs` de XAMPP:
   - En Linux: `/opt/lampp/htdocs/practica-instrumentos/`
   - En Windows: `C:\xampp\htdocs\practica-instrumentos\`
2. Abrir el navegador e ingresar a:
   `http://localhost/practica-instrumentos/index.html`
3. Para enviar mensajes de prueba, dirigirse en el menú lateral a **Contacto** (`pages/contacto.html`).
4. Para revisar los mensajes almacenados en MySQL, dirigirse a **Consultar Mensajes** (`pages/consultar_mensajes.php`).