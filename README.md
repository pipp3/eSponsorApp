# eSponsor

Plataforma de creadores para recibir apoyos y gestionar enlaces de redes sociales.

## Características

- 🔐 Autenticación de usuarios (registro y login)
- 👤 Perfil público personalizable con slug único
- 🔗 Gestión de enlaces con drag & drop para reordenar
- 💰 Sistema de donaciones/apoyos
- 📊 Dashboard para gestionar perfil, links y apoyos recibidos
- 🎨 Interfaz moderna con Tailwind CSS y gradientes

## Tecnologías

- **Backend:** Laravel 11
- **Frontend:** Vue 3 + Inertia.js
- **Base de datos:** MySQL
- **Estilos:** Tailwind CSS
- **Iconos:** HeroIcons

## Requisitos Previos

- PHP >= 8.2
- Composer
- Node.js >= 18.x
- NPM o Yarn
- MySQL >= 8.0

## Instalación

### 1. Clonar el repositorio

```bash
git clone <url-del-repositorio>
cd esponsor-challenge
```

### 2. Instalar dependencias de PHP

```bash
composer install
```

### 3. Instalar dependencias de JavaScript

```bash
npm install
```

### 4. Configurar variables de entorno

Copia el archivo de ejemplo y configúralo:

```bash
copy .env.example .env
```

Edita el archivo `.env` con tu configuración:

```env
APP_NAME=eSponsor
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=esponsor
DB_USERNAME=root
DB_PASSWORD=tu_password

SESSION_DRIVER=database
```

### 5. Generar la clave de aplicación

```bash
php artisan key:generate
```

### 6. Crear la base de datos

Crea una base de datos MySQL llamada `esponsor` (o el nombre que hayas configurado en `DB_DATABASE`):

```sql
CREATE DATABASE esponsor CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 7. Ejecutar migraciones

```bash
php artisan migrate
```

### 8. Compilar assets

Para desarrollo:

```bash
npm run dev
```

Para producción:

```bash
npm run build
```

### 9. Iniciar el servidor

En una terminal separada, ejecuta:

```bash
php artisan serve
```

La aplicación estará disponible en: `http://localhost:8000`

## Uso

### 1. Registro de usuario

- Ve a `http://localhost:8000/register`
- Crea una cuenta con tu nombre, email y contraseña

### 2. Configurar perfil

- Accede a tu dashboard en `/dashboard/profile`
- Configura tu:
  - Nombre público
  - Slug único (URL personalizada)
  - Avatar (URL de imagen)
  - Biografía

### 3. Gestionar enlaces

- Ve a `/dashboard/links`
- Agrega enlaces a tus redes sociales o contenido
- Reordena con drag & drop usando el botón "Editar Orden"

### 4. Ver perfil público

- Tu perfil público estará en: `http://localhost:8000/@tu-slug`
- Comparte esta URL para recibir apoyos

### 5. Recibir apoyos

- Los visitantes pueden apoyarte desde tu perfil público
- Visualiza todos los apoyos recibidos en `/dashboard/supports`

## Estructura del Proyecto

```
esponsor-challenge/
├── app/
│   ├── Http/Controllers/
│   │   ├── Auth/                 # Autenticación
│   │   └── Creator/              # Funcionalidades del creador
│   ├── Models/                   # Modelos (User, Link, Support)
│   └── Policies/                 # Políticas de autorización
├── database/
│   └── migrations/               # Migraciones de BD
├── resources/
│   ├── js/
│   │   ├── Components/           # Componentes Vue reutilizables
│   │   ├── Layouts/              # Layouts (Dashboard, Guest)
│   │   └── Pages/                # Páginas Inertia
│   └── css/                      # Estilos Tailwind
└── routes/
    ├── web.php                   # Rutas principales
    └── auth.php                  # Rutas de autenticación
```

## Comandos Útiles

```bash
# Limpiar caché de configuración
php artisan config:clear

# Limpiar caché de rutas
php artisan route:clear

# Limpiar caché de vistas
php artisan view:clear

# Ver todas las rutas
php artisan route:list

# Ejecutar en modo desarrollo (hot reload)
npm run dev

# Compilar para producción
npm run build
```

## Troubleshooting

### Error de permisos en storage/

```bash
# Windows (ejecutar como administrador)
icacls storage /grant "IIS_IUSRS:(OI)(CI)F" /T
icacls bootstrap/cache /grant "IIS_IUSRS:(OI)(CI)F" /T

# Linux/Mac
chmod -R 775 storage bootstrap/cache
```

### Error de conexión a la base de datos

- Verifica que MySQL esté corriendo
- Confirma las credenciales en `.env`
- Asegúrate de que la base de datos existe

### Error "Vite manifest not found"

```bash
npm run build
```

## Licencia

Este proyecto es de código abierto bajo la licencia MIT.
