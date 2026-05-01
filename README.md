<div align="center">

```
██████╗ ██████╗ ███████╗███████╗████████╗ █████╗ ███╗   ███╗███████╗██╗      ██████╗
██╔══██╗██╔══██╗██╔════╝██╔════╝╚══██╔══╝██╔══██╗████╗ ████║██╔════╝██║     ██╔═══██╗
██████╔╝██████╔╝█████╗  ███████╗   ██║   ███████║██╔████╔██║█████╗  ██║     ██║   ██║
██╔═══╝ ██╔══██╗██╔══╝  ╚════██║   ██║   ██╔══██║██║╚██╔╝██║██╔══╝  ██║     ██║   ██║
██║     ██║  ██║███████╗███████║   ██║   ██║  ██║██║ ╚═╝ ██║███████╗███████╗╚██████╔╝
╚═╝     ╚═╝  ╚═╝╚══════╝╚══════╝   ╚═╝   ╚═╝  ╚═╝╚═╝     ╚═╝╚══════╝╚══════╝ ╚═════╝
```

### 📚 Comparte tus libros. Construye comunidad. Sin dinero de por medio.

[![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-CDN-38BDF8?style=for-the-badge&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![Composer](https://img.shields.io/badge/Composer-PSR--4-885630?style=for-the-badge&logo=composer&logoColor=white)](https://getcomposer.org)
[![License](https://img.shields.io/badge/Licencia-MIT-22C55E?style=for-the-badge)](LICENSE)

</div>

---

## ¿Qué es PrestameLo?

**PrestameLo** es una aplicación web para que personas aficionadas a la lectura puedan **prestarse libros entre sí**. Sin tiendas, sin dinero, sin intermediarios — solo una comunidad que comparte lo que le gusta.

Registras tus libros, los pones a disposición de otros, y puedes pedir prestados los suyos. Cuando terminas, los devuelves. Así de simple.

---

## ✨ Funcionalidades

| Módulo | Qué puedes hacer |
|---|---|
| 🔐 **Autenticación** | Registro, login con "Recordarme" (cookie 7 días), logout seguro |
| 📖 **Mis libros** | Alta manual, importación masiva por CSV, listado propio |
| 🔍 **Explorar** | Busca libros disponibles por título, autor o género |
| 🤝 **Préstamos** | Solicita, gestiona activos, devuelve con fecha registrada |
| 📋 **Historial** | Consulta todos tus préstamos pasados y presentes |
| 🛡️ **Administración** | Panel de gestión de usuarios y préstamos (solo admins) |

---

## 🏗️ Arquitectura

Arquitectura **MVC artesanal** en PHP puro, sin frameworks.

```
app/
├── public/              ← Punto de entrada + assets
│   ├── index.php        ← Login / Registro
│   ├── css/index.css
│   └── js/tailwind.js
└── src/
    ├── config/
    │   ├── config-db.json   ← Credenciales BD (¡no subas esto a producción!)
    │   └── crear-db.sql     ← Script de inicialización
    ├── controllers/         ← Lógica POST, una acción por fichero
    │   ├── auth/
    │   ├── libros/
    │   ├── prestamos/
    │   └── admin/
    ├── models/
    │   ├── BBDD.php         ← Capa PDO de acceso a datos
    │   └── Usuario.php
    ├── helpers/
    │   └── ayuda.php        ← Funciones auxiliares globales
    └── views/               ← HTML + PHP, organizadas por dominio
        ├── layout/
        ├── libros/
        ├── prestamos/
        └── admin/
```

---

## 🗄️ Base de datos

Tres tablas. Sin complicaciones.

```sql
usuario ──< libro ──< prestamo
```

- **`usuario`** — id, nombre, apellidos, email (unique), username (unique), password (bcrypt), role
- **`libro`** — id, titulo, autor, genero, anyo, id_usuario (FK)
- **`prestamo`** — id, fecha_prestamo, fecha_devolucion, id_usuario (FK), id_libro (FK), devuelto (0/1)

> Los préstamos se gestionan con **INSERTs atómicos condicionales** — si dos usuarios piden el mismo libro a la vez, solo uno gana. Sin race conditions.

---

## 🚀 Despliegue local

### Requisitos previos

- PHP 8.1+
- MySQL 8.0+
- Composer
- Apache / Nginx con soporte PHP

### Pasos

**1. Clona el repositorio**
```bash
git clone https://github.com/marcos-lopezgonzalez/PI-prestamo-de-libros.git
cd PI-prestamo-de-libros
git checkout develop
```

**2. Inicializa la base de datos**
```bash
mysql -u root -p < app/src/config/crear-db.sql
```

El script crea la base de datos `prestamo_libros`, todas las tablas, **21 usuarios de ejemplo** y **20 libros con 10 préstamos** listos para probar.

**3. Configura la conexión**

Edita `app/src/config/config-db.json`:
```json
{
    "dbMotor": "mysql",
    "mysqlHost": "127.0.0.1",
    "mysqlUser": "root",
    "mysqlPassword": "tu_password",
    "mysqlDatabase": "prestamo_libros"
}
```

**4. Instala dependencias**
```bash
cd app
composer install
```

**5. Configura el servidor web**

Apunta el `DocumentRoot` a `app/public/` y abre `http://localhost/`.

---

## 👤 Credenciales de prueba

| Usuario | Contraseña | Rol |
|---|---|---|
| `admin` | `admin123` | 🛡️ Admin |
| `ana1` | (ver SQL) | 🛡️ Admin |
| `luis2` … `alvaro20` | (ver SQL) | 👤 User |

---

## 📥 Importar libros por CSV

El sistema acepta ficheros `.csv` de hasta **2 MB** con este formato:

```
titulo;autor;genero;anyo
El Quijote;Miguel de Cervantes;Novela;1605
1984;George Orwell;Distopía;1949
Dune;Frank Herbert;Ciencia ficción;1965
```

- Delimitadores soportados: `;` y `,`
- Fila de cabecera: opcional (configurable en el formulario)
- Año válido: entre 1000 y 2100
- Inserción en bloque con **transacción SQL** — si falla una fila, el resto se importa igualmente

---

## 🔐 Seguridad

- Contraseñas hasheadas con **bcrypt** (`password_hash` / `password_verify`)
- Queries protegidas contra **SQL Injection** mediante **PDO prepared statements**
- Validación de entradas con `filter_var` y `filter_input`
- Comprobación de sesión en cada vista protegida
- Panel de admin inaccesible sin rol `admin` verificado en BD

---

## 👨‍💻 Autores

**Marcos López González**

**Juan Miguel Martínez Sánchez**

---

<div align="center">

*Hecho con PHP puro, SQL honesto y muchas ganas de leer.*

</div>
