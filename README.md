# 📦 Sistema STOCKEA

**STOCKEA** es un sistema web de gestión de inventario desarrollado como proyecto educativo.  
Permite registrar y administrar productos, clientes, proveedores y ventas de forma organizada y sencilla, con una interfaz  amigable.

## 🚀 Funcionalidades principales

- Registro y listado de productos
- Gestión de clientes y proveedores
- Registro y control de ventas
- Visualización de estadísticas
- Módulo de calendario interactivo
- Gestión de notas y documentos
- Autenticación de usuarios (registro e inicio de sesión)
- Menú lateral de navegación y accesos rápidos

## 🗂️ Estructura del proyecto

├── index.php # Página de bienvenida
├── login.php # Inicio de sesión
├── register.php # Registro de usuario
├── dashboard.php # Panel principal
├── logout.php # Cierre de sesión
├── modules/ # Módulos internos del sistema (productos, clientes, etc.)
├── assets/ # Archivos CSS, JS e imágenes
├── database/ # Archivo SQL de la base de datos
│ └── stockea.sql



## ⚙️ Requisitos para ejecución local

- Servidor web local (XAMPP, WAMP, Laragon)
- PHP 7.4 o superior
- MySQL o MariaDB
- Navegador web moderno

## 📂 Base de datos

El archivo `stockea.sql` se encuentra en la carpeta `/database/`.  
Contiene la estructura de la base de datos con las tablas necesarias para el funcionamiento del sistema:  
`usuarios`, `clientes`, `productos`, `ventas`, entre otras.

Puede ser importado fácilmente desde **phpMyAdmin**:

1. Crear una base de datos (por ejemplo: `stockea`)
2. Ir a la pestaña **Importar**
3. Seleccionar el archivo `stockea.sql`
4. Ejecutar



## 🛡️ Seguridad y buenas prácticas

- No se incluyen credenciales en el repositorio.
- El sistema está organizado por módulos independientes.
- Se recomienda configurar un archivo `.gitignore` para ignorar archivos sensibles.

## 📎 Enlace al repositorio

Puedes acceder al proyecto completo en GitHub aquí:  
👉 [https://github.com/eunice123-ui/sistema-STOCKEA](https://github.com/eunice123-ui/sistema-STOCKEA)

## 👩‍💻 Autora

Desarrollado por **Eunice de la rosa** como parte del programa formativo en desarrollo de software.

---
