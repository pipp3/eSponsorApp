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

- **Backend:** Laravel 12
- **Frontend:** Vue 3.4 + Inertia.js 2.0
- **Base de datos:** SQLite
- **Estilos:** Tailwind CSS 3.2
- **Iconos:** HeroIcons 2.2

## Requisitos Previos

- PHP >= 8.2
- Composer
- Node.js >= 18.x
- NPM

## Instalación

### 1. Clonar el repositorio

```bash
git clone https://github.com/pipp3/eSponsorApp.git
cd eSponsorApp
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

Copia el archivo de ejemplo:

```bash
copy .env.example .env
```

Edita el archivo `.env` y asegúrate de tener esta configuración:

```env
APP_NAME="eSponsor App"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite
DB_DATABASE=database/esponsor.sqlite
```

### 5. Crear el archivo de base de datos SQLite

```bash
type nul > database\esponsor.sqlite
```

### 6. Ejecutar migraciones

```bash
php artisan migrate
```

### 7. Compilar assets (en una terminal)

```bash
npm run dev
```

### 8. Iniciar el servidor (en otra terminal)

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
- Configura:
  - Nombre público
  - Slug único (tu URL personalizada)
  - Avatar (URL de imagen)
  - Biografía

### 3. Gestionar enlaces

- Ve a `/dashboard/links`
- Agrega enlaces a tus redes sociales
- Usa "Editar Orden" para reordenar con drag & drop

### 4. Ver perfil público

- Tu perfil público estará en: `http://localhost:8000/@tu-slug`
- Comparte esta URL para recibir apoyos

### 5. Recibir apoyos

- Los visitantes pueden donarte desde tu perfil público
- Visualiza los apoyos en `/dashboard/supports`

## Estructura del Proyecto

```
eSponsorApp/
├── app/
│   ├── Http/Controllers/
│   │   ├── Auth/                 # Autenticación (login/register)
│   │   └── Creator/              # Perfil, links y apoyos
│   ├── Models/                   # User, Link, Support
│   └── Policies/                 # LinkPolicy
├── database/
│   ├── migrations/               # Migraciones de BD
│   └── esponsor.sqlite           # Base de datos SQLite
├── resources/
│   ├── js/
│   │   ├── Components/           # Modal, Checkbox, TextInput
│   │   ├── Layouts/              # DashboardLayout, GuestLayout
│   │   └── Pages/                # Vistas Vue
│   └── css/                      # app.css (Tailwind)
└── routes/
    ├── web.php                   # Rutas principales
    └── auth.php                  # Login, register, logout
```

## Comandos Útiles

```bash
# Ver todas las rutas
php artisan route:list

# Limpiar cachés
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Compilar assets para producción
npm run build
```

## Licencia

MIT
