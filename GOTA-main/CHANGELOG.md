# Changelog

Todos los cambios notables se documentan en este archivo.

El formato sigue [Keep a Changelog](https://keepachangelog.com/es/1.1.0/) y el proyecto usa [Conventional Commits](https://www.conventionalcommits.org/).

## [Parcial 2] - 2026-09-19

### Agregado

- Soporte de **tema claro / oscuro**: botón de cambio en el encabezado (`app/Views/layouts/main.php`) que alterna `data-theme` y `data-bs-theme`, persistiendo la preferencia en `localStorage` y respetando `prefers-color-scheme` al inicio.
- Variables CSS de tema (`--app-bg`, `--app-surface`, `--app-card`, `--app-text`, etc.) definidas en el layout compartido para ambos temas.
- Los estilos del dashboard (`app/Views/dashboard/index.php`) ahora usan las variables del tema, por lo que se adaptan a claro y oscuro.
- **Bitácora de auditoría** en el módulo de clientes:
  - Columnas `created_by` y `updated_by` en la tabla `Clientes` (migración `AddAuditoriaClientes`), que guardan el id del usuario en sesión al crear o editar.
  - El controlador registra automáticamente el usuario actual al crear, editar, desactivar y reactivar (`ClientesController`).
  - Vista de detalle: botón "Detalle" en el listado abre un modal con los datos del cliente y quién lo creó / editó por última vez (`app/Views/clientes/index.php`).