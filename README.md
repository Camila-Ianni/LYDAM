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

---

## Guía de Despliegue en Producción (Deployment)

Para poner la página web en producción en tu nuevo hosting, sigue las instrucciones según tu tipo de servidor:

### 1. Configuraciones Previas Generales
1. **Compilar los archivos CSS/JS para producción:**
   Antes de subir tus archivos, debes compilar el bundle de estilos y Javascript ejecutando en tu terminal local:
   ```bash
   npm run build
   ```
   Esto generará la carpeta `public/build`, la cual contiene todos los recursos compilados y optimizados.
2. **Preparar el archivo `.env`:**
   En el servidor de producción, crea el archivo `.env` a partir de `.env.example` y configúralo con lo siguiente:
   - `APP_ENV=production`
   - `APP_DEBUG=false` (¡Muy importante! Desactivar para seguridad y rendimiento)
   - `APP_URL=https://tudominio.com` (Usa tu dirección web real)
   - `APP_KEY=` (Ejecuta `php artisan key:generate` en el servidor para generar una clave nueva)

---

### Opción A: Servidor VPS o Laravel Forge (Recomendado)
Si tienes acceso SSH al servidor (Ubuntu, Debian, etc.) o usas Laravel Forge:
1. Clona el repositorio desde GitHub en la carpeta correspondiente.
2. Ejecuta la instalación de dependencias de PHP sin herramientas de desarrollo:
   ```bash
   composer install --no-dev -o
   ```
3. Genera la clave de aplicación:
   ```bash
   php artisan key:generate
   ```
4. Si usas la base de datos **SQLite** por defecto, asegúrate de que el archivo existe y tiene permisos de escritura:
   ```bash
   touch database/database.sqlite
   chmod 775 database/database.sqlite
   chmod -R 775 storage bootstrap/cache
   ```
5. Corre las migraciones y sembradores iniciales:
   ```bash
   php artisan migrate --force
   php artisan db:seed --class=SettingSeeder --force
   ```
6. Configura el servidor web (Nginx o Apache) para que el **Document Root** apunte a la carpeta `public/` del proyecto.
7. Crea el enlace simbólico del storage:
   ```bash
   php artisan storage:link
   ```
8. Cachea las rutas y configuraciones para optimizar la velocidad:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

---

### Opción B: Hosting Compartido (cPanel / FTP sin SSH)
Si contrataste un hosting tradicional sin acceso a terminal SSH ni Composer:
1. **Compilar localmente:** Ejecuta `npm run build` en tu computadora.
2. **Subir archivos:** Sube por FTP todos los archivos del proyecto (incluyendo las carpetas `vendor/` y `public/build/`).
3. **Organizar Carpeta Public:**
   - **Caso 1:** Si tu hosting te permite configurar el Document Root del dominio, configúralo para que apunte a la carpeta `/public` de tu proyecto.
   - **Caso 2 (Más común):** Si el dominio apunta obligatoriamente a `public_html`, puedes renombrar la carpeta `public` local a `public_html` antes de subir los archivos, o crear un archivo `.htaccess` en la raíz del proyecto para redirigir todo el tráfico:
     ```apache
     <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteRule ^(.*)$ public/$1 [L]
     </IfModule>
     ```
4. **Base de Datos SQLite en Hosting:**
   - Sube el archivo `database/database.sqlite` (que ya contiene los productos cargados) a la carpeta `database/` en tu servidor.
   - **¡IMPORTANTE!** Otorga permisos de lectura y escritura (`chmod 775` o `777` dependiendo del hosting) tanto al archivo `database/database.sqlite` como a la carpeta completa `database/`.
5. **Permisos de Almacenamiento:**
   - Asegúrate de que las carpetas `storage/` y `bootstrap/cache/` tengan permisos de escritura (generalmente `775` o `775` recursivo).
6. **Enlace Simbólico de Imágenes:**
   - Si las imágenes del storage no se ven en la web, crea un archivo PHP temporal en la raíz del hosting (por ejemplo `link.php`) con el siguiente contenido:
     ```php
     <?php
     symlink(__DIR__.'/storage/app/public', __DIR__.'/public/storage');
     echo "Enlace creado con éxito.";
     ```
   - Visita `https://tudominio.com/link.php` en tu navegador una sola vez para crearlo y luego borra el archivo `link.php` por seguridad.
