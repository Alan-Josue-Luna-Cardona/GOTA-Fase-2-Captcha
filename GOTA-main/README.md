# 💧 GOTA - Sistema de Gestión para la Oficina del Agua

![Estado](https://img.shields.io/badge/estado-en%20desarrollo-yellow)
![PHP](https://img.shields.io/badge/PHP-8.3-blue)
![CodeIgniter](https://img.shields.io/badge/CodeIgniter-4-red)
![MariaDB](https://img.shields.io/badge/MariaDB-10.x-blue)
![GCP](https://img.shields.io/badge/GCP-Cloud%20Run%20%7C%20Cloud%20SQL-green)
![Docker](https://img.shields.io/badge/Docker-Container-blue)

**GOTA** es un sistema web para la gestión integral de servicios residenciales de agua. Permite administrar clientes, contadores, lecturas, tarifas configurables, pagos y generar reportes de consumo, con un modelo de cobro que soporta **volumen base incluido y cobro por excedente**.

> 🌐 **Aplicación en producción:** [https://gota-537780680415.europe-west1.run.app/index.php/login](https://gota-537780680415.europe-west1.run.app/index.php/login)

---

## 📋 Tabla de Contenidos

- [Integrantes del Equipo](#-integrantes-del-equipo)
- [Enlace al Proyecto en Jira](#-enlace-al-proyecto-en-jira)
- [Descripción del Proyecto](#-descripción-del-proyecto)
- [Metodología y Proceso de Desarrollo](#-metodología-y-proceso-de-desarrollo)
- [Arquitectura y Tecnologías](#-arquitectura-y-tecnologías)
- [Módulos Principales](#-módulos-principales)
- [Instalación Local](#-instalación-local)
- [Despliegue (CI/CD)](#-despliegue-cicd)
- [Estructura del Repositorio](#-estructura-del-repositorio)

---

## 👥 Integrantes del Equipo

| Rol | Nombre Completo | Carnet | Correo Electrónico | Apoyo |
|-----|-----------------|--------|-------------------|-------|
| **🏆 Líder del Equipo**<br>Backend + Base de Datos | **Daniela Maricler Güitz Palma** | 0905-23-15374 | daniela.guitz@correo.com | Ulises |
| DevOps + GCP + Testing | Alan Josué Luna Cardona | 0905-23-1346 | alan.luna@correo.com | Ulises |
| Frontend + UI/UX | Gabriel Enrique Villanueva Hernández | 0905-23-21427 | gabriel.villanueva@correo.com | Daniela |
| Seguridad + Autenticación | Ulises Enríque Pineda Enríquez | 0905-23-19852 | ulises.pineda@correo.com | Alan |

### 🎯 Responsabilidades Específicas por Rol

| Rol | Responsabilidades |
|-----|-------------------|
| **Backend + Base de Datos**<br>*(Daniela)* | Modelos, Controladores, Lógica de negocio, Migraciones, Seeders, Queries SQL, Relaciones |
| **Frontend + UI/UX**<br>*(Gabriel)* | Vistas, Bootstrap, Validaciones frontend, DataTables, Gráficas, Diseño responsive |
| **Seguridad + Autenticación**<br>*(Ulises)* | Login/Register, Middleware, Sesiones, CSRF, Roles y permisos, Encriptación |
| **DevOps + GCP + Testing**<br>*(Alan)* | Configuración GCP, Docker, Git/GitHub, Despliegue, Pruebas, Documentación, Diagramas |


---

## 🔗 Enlace al Proyecto en Jira

Toda la planificación, seguimiento de tareas, sprints y gestión del proyecto se realiza a través de **Jira Software**:

🔗 **[Proyecto SCRUM - GOTA en Jira](https://miagua.atlassian.net/jira/software/projects/SCRUM/summary?atlOrigin=eyJpIjoiOWEyOTlhNmE4OGYxNGExNGJkMzI2NThkODc0ZjAyNWUiLCJwIjoiaiJ9)**

En Jira encontrarás:
- 📌 Backlog del producto
- 🏃 Sprints en curso y finalizados
- 🐛 Seguimiento de bugs e incidencias
- ✅ Historias de usuario y criterios de aceptación
- 📊 Tableros Scrum/Kanban del equipo

---

## 📖 Descripción del Proyecto

**GOTA** es una aplicación web monolítica desarrollada en **PHP con CodeIgniter 4** y **MariaDB**, diseñada para digitalizar y automatizar la gestión de la **Oficina de Control del Servicio Residencial de Agua**. El sistema reemplaza los procesos manuales/en hojas de Excel por una plataforma centralizada, con reglas de negocio configurables y trazabilidad de cada operación.

### ✨ Características Principales

- ✅ **Gestión de Clientes:** Registro, edición y consulta de clientes con múltiples contadores.
- ✅ **Administración de Contadores:** Asignación de tipo de servicio, sector, ubicación y estado.
- ✅ **Tipos de Servicio Configurables:** Catálogo dinámico (Residencial, Comercial, Institucional, etc.).
- ✅ **Tarifas Flexibles:** Cada tipo de servicio tiene su propio volumen base incluido, tarifa base y tarifa de exceso.
- ✅ **Registro de Lecturas:** Cálculo automático de consumo, consumo base y consumo excedente.
- ✅ **Cobro por Excedente:** Cálculo automático del monto a pagar según el consumo real.
- ✅ **Registro de Pagos:** Control de pagos, métodos, comprobantes y estados.
- ✅ **Historial y Auditoría:** Registro de cambios en el sistema.
- ✅ **Autenticación Segura:** Login con sesiones en base de datos, roles y permisos.
- ✅ **Reportes:** Consultas y reportes de consumo y pagos (estilo Excel actual digitalizado).

---

## 🔄 Metodología y Proceso de Desarrollo

### Metodología Ágil (Scrum)

El equipo trabajó bajo la metodología **Scrum**, gestionando todo el ciclo de vida del proyecto en **Jira Software**:

- **Backlog priorizado con MoSCoW** (Must have, Should have, Could have, Won't have) para enfocar el esfuerzo en las funcionalidades críticas primero.
- **Sprints** con historias de usuario y criterios de aceptación definidos.
- **Estado personalizado "Bloqueada"** para visibilizar tareas detenidas por dependencias técnicas (por ejemplo, esperar migraciones de base de datos de otro compañero antes de continuar un módulo).
- Tablero Scrum/Kanban actualizado durante todo el proyecto para dar seguimiento al avance de cada integrante.

### Flujo de Trabajo en Git/GitHub

Se siguió un **flujo basado en ramas por funcionalidad (feature branches)**:

1. Cada integrante trabaja en su propia rama `feature/nombre-modulo` a partir de `develop`.
2. Los commits siguen el formato de **Conventional Commits**: `feat(modulo): descripcion`, `fix(modulo): descripcion`, `docs: descripcion`, etc.
3. Al finalizar una funcionalidad, se abre un **Pull Request** para revisión del equipo antes de integrar los cambios.
4. El repositorio vive bajo la organización de GitHub **`GOTA-S-A`**, permitiendo control de acceso y colaboración centralizada entre los cuatro integrantes.

### Retos Técnicos Superados

- **Migración de CodeIgniter 3 a CodeIgniter 4:** el proyecto inició en CI3; el equipo migró toda la base de código a CI4 para aprovechar mejoras en seguridad, estructura MVC y mantenibilidad a largo plazo.
- **Diseño de base de datos con 7 migraciones relacionadas** (Tipos_Servicio, Clientes, Contadores, Tarifas, Lecturas, Pagos, Historial), coordinando el trabajo de distintos integrantes sobre el mismo esquema sin generar conflictos.
- **Patrón de borrado lógico (soft delete) manual:** en lugar de usar el `useSoftDeletes` nativo de CI4, se implementó un campo `activo` gestionado desde el controlador, dando más control sobre la lógica de negocio en los módulos de Clientes y Contadores.
- **Cálculo de fechas en servidor:** campos como `fecha_registro` y `fecha_instalacion` se calculan en el controlador (no en el formulario), evitando inconsistencias por manipulación del cliente.
- **Consultas con JOIN para datos legibles:** en el módulo de Contadores, la consulta principal une las tablas Contadores, Clientes y Tipos de Servicio para mostrar nombres reales en vez de IDs.
- **Seguridad de sesiones:** se investigó a fondo el filtro de autenticación (`AuthFilter`) de CI4 y el manejo de sesiones en base de datos, clave para el entorno serverless en Cloud Run donde las instancias son efímeras.

---

## 🏗️ Arquitectura y Tecnologías

### Stack Tecnológico

| Capa | Tecnología |
|------|------------|
| **Backend** | PHP 8.3 + CodeIgniter 4 |
| **Base de Datos** | MariaDB 10.x (Cloud SQL) |
| **Frontend** | HTML5, CSS3, Bootstrap 5, JavaScript, DataTables, Chart.js |
| **Contenedores** | Docker |
| **CI/CD** | GitHub Actions |
| **Cloud** | Google Cloud Platform (GCP) |
| **Servicios GCP** | Cloud Run, Cloud SQL, Artifact Registry, Cloud Build |
| **Autenticación** | Sesiones en base de datos + Roles/Permisos |
| **Control de Versiones** | Git + GitHub |

### Diagrama de Arquitectura

```
┌─────────────────────────────────────────────────────────────┐
│                     DESARROLLO LOCAL                         │
│  ┌──────────────┐   ┌──────────────┐   ┌──────────────┐      │
│  │ CodeIgniter  │──▶│  Dockerfile  │──▶│  Git Push    │      │
│  │  PHP + CI4   │   │  (Apache)    │   │  a main      │      │
│  └──────────────┘   └──────────────┘   └──────┬───────┘      │
└─────────────────────────────────────────────────┼───────────┘
                                                   │
                                                   ▼
┌─────────────────────────────────────────────────────────────┐
│                  GITHUB ACTIONS (CI/CD)                      │
│  ┌──────────────┐   ┌──────────────┐   ┌──────────────┐      │
│  │    Build     │──▶│ Push Image   │──▶│   Deploy     │      │
│  │   Docker     │   │  Artifact    │   │  Cloud Run   │      │
│  │              │   │  Registry    │   │              │      │
│  └──────────────┘   └──────────────┘   └──────┬───────┘      │
└─────────────────────────────────────────────────┼───────────┘
                                                   │
                                                   ▼
┌─────────────────────────────────────────────────────────────┐
│                  GOOGLE CLOUD PLATFORM                        │
│  ┌──────────────┐   ┌──────────────┐   ┌──────────────┐      │
│  │  Cloud Run   │◀─▶│  Cloud SQL   │   │ Cloud Build  │      │
│  │  (App PHP)   │   │  (MariaDB)   │   │ (Conexión)   │      │
│  └──────┬───────┘   └──────────────┘   └──────────────┘      │
│         │                                                     │
│         ▼                                                     │
│  🌐 https://gota-537780680415.europe-west1.run.app            │
└─────────────────────────────────────────────────────────────┘
```

### Decisiones Arquitectónicas

- **Monolito:** Se mantiene una arquitectura monolítica con CodeIgniter 4 por simplicidad, cohesión del equipo y rapidez de desarrollo.
- **Cloud SQL:** La base de datos MariaDB se gestiona de forma administrada en Cloud SQL, garantizando persistencia, respaldos y alta disponibilidad.
- **Cloud Run:** Despliegue serverless de la aplicación contenerizada, con escalado automático y **despliegues sin tiempo de inactividad (zero-downtime)**.
- **Sesiones en Base de Datos:** Necesario para entornos serverless donde las instancias son efímeras. Se utiliza la tabla `ci_sessions`.
- **CI/CD con GitHub Actions:** Automatización completa desde `git push` a `main` hasta el despliegue en producción.

---

## 🧩 Módulos Principales

| Módulo | Descripción | Responsable |
|--------|-------------|-------------|
| **Clientes** | CRUD de clientes y múltiples contadores por cliente | Daniela |
| **Contadores** | Gestión de contadores, tipo de servicio y sectores | Daniela |
| **Tipos de Servicio** | Catálogo configurable de tipos de servicio | Daniela |
| **Tarifas** | Configuración de volumen base, tarifa base y tarifa exceso | Daniela |
| **Lecturas** | Registro de lecturas con cálculo automático de consumo y montos | Daniela |
| **Pagos** | Registro y control de pagos con estados | Daniela |
| **Historial** | Auditoría de cambios en el sistema | Daniela |
| **Autenticación** | Login, logout, roles y permisos | Ulises |
| **Reportes** | Consultas y reportes de consumo y pagos | Gabriel / Daniela |
| **Frontend / UI** | Vistas, DataTables, gráficas y diseño responsive | Gabriel |
| **DevOps / CI-CD** | Docker, GitHub Actions, GCP, despliegue | Alan |
| **Testing** | Pruebas unitarias, de integración y de despliegue | Alan |

---

## 💻 Instalación Local

### Requisitos Previos

- PHP >= 8.1 (recomendado 8.3)
- Composer
- MariaDB / MySQL
- Servidor local (Laragon, XAMPP, o similar)
- Git

### Pasos para Levantar el Proyecto

1. **Clonar el repositorio**
   ```bash
   git clone https://github.com/GOTA-S-A/oficina-gota.git
   cd oficina-gota
   ```

2. **Instalar dependencias con Composer**
   ```bash
   composer install
   ```

3. **Configurar variables de entorno**

   Copia el archivo de ejemplo y renómbralo:
   ```bash
   cp env .env
   ```

   Edita `.env` con tus credenciales locales:
   ```env
   CI_ENVIRONMENT = development

   app.baseURL = 'http://localhost:8080/'

   database.default.hostname = localhost
   database.default.database = gota_db
   database.default.username = root
   database.default.password =
   database.default.DBDriver = MySQLi

   session.driver = 'CodeIgniter\Session\Handlers\DatabaseHandler'
   session.savePath = 'ci_sessions'
   ```

4. **Crear la base de datos**

   Crea una base de datos vacía llamada `gota_db` (por ejemplo desde HeidiSQL o phpMyAdmin).

5. **Ejecutar las migraciones**
   ```bash
   php spark migrate
   ```

6. **Levantar el servidor local**
   ```bash
   php spark serve
   ```

   La aplicación estará disponible en `http://localhost:8080`

### ⚠️ Notas Importantes

- Si usas **Laragon**, puedes acceder directamente vía `http://oficina-gota.test` sin necesidad de `php spark serve`.
- Asegúrate de que la tabla `ci_sessions` exista antes de iniciar sesión (la crea la migración correspondiente).

---

## 🚀 Despliegue (CI/CD)

### Pipeline Automatizado

Cada `git push` a la rama `main` dispara automáticamente el siguiente pipeline:

1. **GitHub Actions** detecta el cambio en `main`.
2. **Build:** Se construye la imagen Docker de la aplicación.
3. **Push:** La imagen se sube a **Artifact Registry**.
4. **Deploy:** Se despliega en **Cloud Run** (sin downtime).
5. **Conexión:** La app se conecta a **Cloud SQL (MariaDB)** mediante Cloud SQL Auth Proxy.

### Comandos Útiles (GCP)

```bash
# Autenticarse en GCP
gcloud auth login

# Configurar Docker para Artifact Registry
gcloud auth configure-docker europe-west1-docker.pkg.dev

# Ver logs del servicio en Cloud Run
gcloud run services logs read gota --region=europe-west1

# Conectarse a Cloud SQL
gcloud sql connect [INSTANCIA] --user=root
```

### Variables de Entorno Requeridas

```env
CI_ENVIRONMENT=production
database.default.DSN=mysql:unix_socket=/cloudsql/PROYECTO:REGION:INSTANCIA;dbname=gota_db
database.default.username=USUARIO
database.default.password=CONTRASEÑA
database.default.database=gota_db
database.default.DBDriver=MySQLi
session.driver=CodeIgniter\Session\Handlers\DatabaseHandler
session.savePath=ci_sessions
```

---

## 📁 Estructura del Repositorio

```
gota/
├── .github/
│   └── workflows/
│       └── deploy.yml              # Pipeline CI/CD
├── app/
│   ├── Config/
│   │   ├── Database.php            # Configuración de BD
│   │   ├── Routes.php              # Rutas
│   │   ├── Session.php             # Configuración de sesiones
│   │   └── Filters.php             # Filtros de autenticación
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── Clientes.php
│   │   ├── Contadores.php
│   │   ├── Lecturas.php
│   │   ├── Pagos.php
│   │   ├── Tarifas.php
│   │   └── TiposServicio.php
│   ├── Models/
│   │   ├── ClienteModel.php
│   │   ├── ContadorModel.php
│   │   ├── LecturaModel.php
│   │   ├── PagoModel.php
│   │   ├── TarifaModel.php
│   │   ├── TipoServicioModel.php
│   │   └── UsuarioModel.php
│   ├── Filters/
│   │   └── AuthFilter.php          # Middleware de autenticación
│   └── Views/
│       ├── auth/
│       ├── clientes/
│       ├── contadores/
│       ├── lecturas/
│       ├── pagos/
│       ├── tarifas/
│       └── layouts/
├── database/
│   └── migrations/
│       └── 20260827_estructura_base.sql   # DDL completo
├── public/
│   └── index.php
├── writable/
├── Dockerfile                      # Imagen Docker
├── .dockerignore
├── composer.json
└── README.md
```