# LYDAM - E-Commerce de Streetwear Brutalista

Plataforma de comercio electrónico mayorista de indumentaria urbana pesada y agresiva, con una estética de diseño brutalista oscuro de alta gama.

## Credenciales del Panel de Administración

Para acceder al panel de control como administrador, ingresá en `/login` con los siguientes datos:

* **Email:** `lydamadmin@lydam.com`
* **Contraseña:** `password`

---

## Instrucciones para Servidor Local

### 1. Iniciar el Servidor Web (con límite de subida de imágenes aumentado)
Para poder subir imágenes de alta resolución (hasta 32MB) sin límites de PHP, ejecuta directamente el servidor integrado de PHP:
```bash
php -d upload_max_filesize=32M -d post_max_size=64M -S 127.0.0.1:8000 -t public/
```
Luego podrás acceder a la web en: [http://127.0.0.1:8000](http://127.0.0.1:8000)

### 2. Iniciar Vite (Compilación y Recarga en Caliente)
Para compilar y recargar en caliente los estilos CSS y archivos Javascript:
```bash
npm run dev
```

---

## Base de Datos

La aplicación utiliza una base de datos **SQLite** persistente ubicada físicamente en el proyecto en:
`database/database.sqlite`

### Restablecer y Sembrar Base de Datos
Si necesitas resetear las tablas y volver a insertar los productos de catálogo, talles de curvas, configuraciones bancarias predeterminadas y el usuario administrador inicial, ejecuta:
```bash
php artisan migrate:fresh --seed
```
