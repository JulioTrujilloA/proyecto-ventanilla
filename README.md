# proyecto-ventanilla

![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-MariaDB-4479A1?logo=mysql&logoColor=white)
![Composer](https://img.shields.io/badge/Composer-spipu%2Fhtml2pdf%20%5E5-885630?logo=composer&logoColor=white)

Aplicación web para la **ventanilla de "Alumnos Activos"** de Control Escolar del
Centro Universitario de la Ciénega (CUCI). Permite registrar y dar seguimiento a
las solicitudes de documentos que hacen los alumnos, sustituyendo el antiguo
sistema en Microsoft Access y eliminando la necesidad de firmas e impresiones en
papel.

> Estado actual: proyecto en **modernización a PHP 8.2** (rama `modernizacion-php82`).
> Ver la sección [Estado de modernización](#estado-de-modernización).

---

## Funcionalidades

El administrador inicia sesión y accede a un menú con seis módulos:

| Módulo | Descripción |
|---|---|
| **Nuevo Administrador** | Alta de usuarios administradores del sistema. |
| **Nueva Solicitud** | Registra una solicitud de documento de un alumno (tipo de documento, alumno, administrador y estatus). |
| **Nuevo Alumno** | Alta de alumnos (nombre, apellidos, código, carrera). |
| **Reportes** | Genera en PDF el **Reporte de Solicitudes** con todas las peticiones registradas (código, alumno, documento, administrador y fechas de pedido/firmado/entregado). |
| **Búsqueda** | Busca solicitudes y alumnos registrados. |
| **Mi Perfil** | Perfil del administrador en sesión (relación 1:1 con `administrador`): foto y datos editables. |

Características transversales:

- **Login seguro** con `password_verify()` contra contraseñas *hasheadas* (`bcrypt`) en la base de datos. La sesión guarda el administrador autenticado; las páginas internas redirigen al login si no hay sesión.
- **Estatus de documento**: cada solicitud avanza por los estados *Enviado → Firmado → Entregado*, activados por el administrador que realiza cada acción, dejando registro de quién levantó, firmó y entregó.
- Capa de acceso a datos mediante el micro-framework **LIGA 3.0** (`LIGA3/`).

---

## Tecnologías

- **PHP 8.2** (XAMPP)
- **MySQL / MariaDB**
- **Composer** para dependencias
- **[spipu/html2pdf](https://github.com/spipu/html2pdf)** (sobre `tecnickcom/tcpdf`) para la generación de PDF
- HTML/CSS + JavaScript del lado del cliente
- Framework de datos **LIGA 3.0** (incluido en `LIGA3/`)

---

## Requisitos

- **XAMPP** con **PHP 8.2**.
- Extensiones de PHP habilitadas en `php.ini`: **`mbstring`** y **`gd`**
  (`gd` es obligatoria para generar el reporte PDF).
- **MySQL/MariaDB** con la base `proyectofinal`.
- **Composer** (o el `composer.phar` incluido) para instalar dependencias.

---

## Instalación y arranque

1. **Colocar el proyecto** dentro de `htdocs` de XAMPP:

   ```
   C:\xampp\htdocs\proyecto-ventanilla
   ```

2. **Habilitar la extensión `gd`** en `C:\xampp\php\php.ini` (quitar el `;` inicial):

   ```ini
   extension=gd
   ```

3. **Iniciar Apache y MySQL** desde el panel de control de XAMPP.

4. **Importar la base de datos.** En phpMyAdmin (o por consola) importar
   [`proyectofinal.sql`](proyectofinal.sql), que crea la base `proyectofinal`
   con sus tablas y datos de ejemplo (incluido un administrador de prueba).

   ```bash
   # Alternativa por consola:
   "C:\xampp\mysql\bin\mysql.exe" -u root < proyectofinal.sql
   ```

5. **Instalar las dependencias de Composer** (la carpeta `vendor/` no se versiona):

   ```bash
   php composer.phar install
   # o, si tienes Composer global:
   composer install
   ```

6. **Abrir la aplicación** en el navegador:

   ```
   http://localhost/proyecto-ventanilla/
   ```

### Conexión a la base de datos

La aplicación se conecta con **usuario `root` sin contraseña** (configuración por
defecto de XAMPP) a la base **`proyectofinal`**. Si tu MySQL usa otra
contraseña, ajústala en las llamadas `BD('localhost', 'root', '<password>', ...)`
de los archivos en `php/`.

### Usuario de prueba

| Código (usuario) | Contraseña |
|---|---|
| `112233445` | `1024` |

---

## Estructura del proyecto

```
proyecto-ventanilla/
├── index.php              # Pantalla de login
├── inicio.php             # Menú principal (requiere sesión)
├── buscar.php             # Pantalla de búsqueda
├── perfil.php             # Mi Perfil
├── formularios/           # Formularios de alta (admin, alumno, solicitud)
├── php/                   # Lógica del servidor (acceso, inserts, reporte PDF, etc.)
│   ├── acceso_usuario.php # Autenticación con password_verify()
│   ├── reportepdf.php     # Reporte de Solicitudes en PDF (spipu/html2pdf)
│   ├── conexion.php       # Conexión a la BD
│   └── ...
├── LIGA3/                 # Micro-framework de acceso a datos (LIGA 3.0)
├── html/                  # Plantillas HTML (header, footer, cuerpo, ...)
├── estilos/               # CSS e imágenes
├── js/                    # JavaScript
├── uploads/               # Fotos de perfil subidas (no se versiona el contenido)
├── proyectofinal.sql      # Dump de la base de datos
├── composer.json          # Dependencias (spipu/html2pdf)
└── vendor/                # Dependencias instaladas (ignorado por git)
```

---

## Estado de modernización

El proyecto se está actualizando de PHP 5/7 a **PHP 8.2**. Avances:

- **Compatibilidad con PHP 8.2** en el código de la aplicación y el framework LIGA.
- **Login seguro**: contraseñas *hasheadas* con `bcrypt` y verificación con `password_verify()`.
- **Módulo "Mi Perfil"** del administrador (tabla `perfil`, relación 1:1, con foto).
- **Reporte PDF migrado a Composer**: se reemplazó la librería *vendida* TCPDF 5.0.002
  (de 2010, incompatible con PHP 8 por usar `$var{...}`, `each()` y `create_function`)
  por **`spipu/html2pdf` ^5** instalada vía Composer. La antigua carpeta `html2pdf/`
  fue eliminada.
- **Manejo de errores de MySQL**: PHP 8.1 cambió `mysqli` para que lance excepciones
  por defecto; se restauró el modo *legacy* (`mysqli_report(MYSQLI_REPORT_OFF)`) que
  el framework LIGA espera, en `LIGA3/BD.php`.
- **Credenciales de BD unificadas**: todas las páginas usan `root` sin contraseña y la
  base `proyectofinal` (se corrigieron páginas que tenían una contraseña obsoleta
  *hardcodeada*).

---

## Especificación original del sistema

> Se solicita un sistema para llevar el control de las solicitudes que se hacen en
> el edificio de Control Escolar del CUCI, en la ventanilla "Alumnos activos".

**Datos a guardar**

1. **Alumno**: nombre, apellido paterno, apellido materno, código de estudiante y carrera.
2. **Administrador (usuario)**: nombre, apellidos y código de usuario.
3. **Solicitud**: tipo de documento, código de alumno, código de usuario y estatus del documento.

Un alumno puede hacer varias solicitudes. Cada documento solicitado lleva una
**"nota de estado"** activada por la persona que realiza cada acción:

- **Recibir en ventanilla** una solicitud → marca el documento como **"Enviado"**.
- **Llevar a firmar** los documentos ante las personas competentes → marca cada documento como **"Firmado"**.
- **Entregar al alumno** el documento solicitado → marca el documento como **"Entregado"**.

Con esto se agiliza la entrega de documentos y se deslindan responsabilidades:
queda registro de quién levantó, firmó y entregó cada documento, sin necesidad de
que el alumno firme en papel ni de imprimir reportes.
