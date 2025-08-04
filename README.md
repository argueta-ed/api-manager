# ⚙️ Instalación del Proyecto
Sigue estos pasos para preparar el entorno de desarrollo:

## 1. Clonar el repositorio
```bash
git clone https://github.com/tu-usuario/tu-repositorio.git
cd tu-repositorio
```
## 2. Instalar dependencias con Composer
Este proyecto utiliza Spatie Laravel Permission, por lo que es necesario instalar todas las dependencias antes de continuar:

```bash
composer install
```
## 3. Configurar archivo .env
Copia el archivo de ejemplo y actualiza las variables necesarias:

```bash
cp .env.example .env
```
Edita el archivo .env y asegúrate de agregar o modificar las siguientes variables para el correcto funcionamiento con Sanctum y el frontend:

```bash
FRONTEND_URL=http://localhost:3000
SANCTUM_STATEFUL_DOMAINS=localhost:3000
SESSION_DOMAIN=localhost
```
Luego genera la clave de la aplicación:

```bash
php artisan key:generate
```
## 4. Ejecutar migraciones y seeders
Este paso creará las tablas necesarias y poblará la base de datos con datos iniciales como roles y permisos (si tus seeders los incluyen):

```bash
php artisan migrate --seed
```
## 5. Ejecutar el servidor de desarrollo
Puedes iniciar el servidor con:

```bash
php artisan serve
```
Esto iniciará la aplicación en http://localhost:8000.

# ✅ Ejecutar pruebas
Este proyecto incluye pruebas automatizadas. Para ejecutarlas, usa:

```bash
php artisan test
```
O, si estás utilizando PHPUnit directamente:
```bash
./vendor/bin/phpunit
```
