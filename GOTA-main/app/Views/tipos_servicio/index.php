<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Tipos de Servicio<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    :root {
        --primary: #0d6efd;
        --primary-dark: #0a58ca;
        --secondary: #6c757d;
        --sidebar-width: 280px;
        --card-radius: 16px;
        --shadow-sm: 0 2px 8px rgba(0,0,0,0.06);
    }

    * {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        box-sizing: border-box;
    }

    body {
        background: #f5f7fb;
        padding: 0;
        margin: 0;
        min-height: 100vh;
        padding-bottom: 80px;
    }

    .app-header {
        position: sticky;
        top: 0;
        z-index: 1000;
        background: #ffffff;
        padding: 12px 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .app-header .brand { display: flex; align-items: center; gap: 10px; }
    .app-header .brand h5 {
        margin: 0;
        font-weight: 800;
        font-size: 1.1rem;
        background: linear-gradient(135deg, #0d6efd, #0a58ca);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .app-header .brand small {
        font-size: 0.65rem;
        color: var(--secondary);
        -webkit-text-fill-color: var(--secondary);
        display: block;
        font-weight: 400;
    }

    .menu-toggle {
        display: none;
        background: none;
        border: none;
        font-size: 1.5rem;
        color: #1a1a2e;
        padding: 4px 8px;
    }

    .user-avatar {
        width: 40px; height: 40px; border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #fff; display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 1rem; cursor: pointer;
        border: 2px solid #fff; box-shadow: var(--shadow-sm);
    }

    .sidebar-overlay {
        display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.5); z-index: 2000; backdrop-filter: blur(4px);
    }
    .sidebar-overlay.active { display: block; }

    .sidebar {
        position: fixed; top: 0; left: -100%; width: var(--sidebar-width);
        height: 100vh; background: #1a1a2e; color: #fff; padding: 0;
        z-index: 3000; transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow-y: auto;
    }
    .sidebar.open { left: 0; }

    .sidebar-brand {
        padding: 24px 20px; border-bottom: 1px solid rgba(255,255,255,0.08);
        display: flex; align-items: center; justify-content: space-between;
    }
    .sidebar-brand h4 { margin: 0; font-weight: 800; }
    .sidebar-brand h4 span { color: #4fc3f7; }
    .sidebar-brand .close-sidebar {
        background: none; border: none; color: rgba(255,255,255,0.6); font-size: 1.5rem;
    }

    .sidebar-menu { list-style: none; padding: 12px 0; margin: 0; }
    .sidebar-menu .menu-label {
        padding: 12px 20px 6px; font-size: 0.65rem; text-transform: uppercase;
        letter-spacing: 1px; color: rgba(255,255,255,0.3); font-weight: 600;
    }
    .sidebar-menu li {
        padding: 12px 20px; cursor: pointer; transition: all 0.2s ease;
        display: flex; align-items: center; gap: 14px;
        color: rgba(255,255,255,0.65); border-left: 3px solid transparent;
        font-size: 0.9rem; font-weight: 500; text-decoration: none;
    }
    .sidebar-menu li:hover, .sidebar-menu li.active {
        background: rgba(79, 195, 247, 0.08); color: #fff; border-left-color: #4fc3f7;
    }
    .sidebar-menu li i { width: 22px; font-size: 1.1rem; text-align: center; }

    .main-content { padding: 16px; max-width: 900px; margin: 0 auto; }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .list-card {
        background: #fff;
        border-radius: var(--card-radius);
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(0,0,0,0.03);
        overflow: hidden;
    }

    .badge-activo { background: #d1e7dd; color: #0f5132; }
    .badge-inactivo { background: #f8d7da; color: #842029; }

    .bottom-nav {
        position: fixed; bottom: 0; left: 0; right: 0; background: #fff;
        display: flex; justify-content: space-around; align-items: center;
        padding: 8px 0; box-shadow: 0 -2px 12px rgba(0,0,0,0.06);
        z-index: 1000; border-top: 1px solid rgba(0,0,0,0.05);
    }
    .bottom-nav .nav-item {
        display: flex; flex-direction: column; align-items: center; gap: 2px;
        background: none; border: none; color: var(--secondary);
        font-size: 0.55rem; padding: 4px 12px; text-decoration: none; font-weight: 500;
    }
    .bottom-nav .nav-item i { font-size: 1.2rem; }
    .bottom-nav .nav-item.active { color: var(--primary); }

    @media (min-width: 768px) {
        body { padding-bottom: 0; }
        .app-header { padding: 16px 32px; }
        .menu-toggle { display: block; }
        .sidebar { left: 0 !important; position: fixed; transform: none !important; box-shadow: 2px 0 20px rgba(0,0,0,0.05); }
        .sidebar-overlay { display: none !important; }
        .sidebar .close-sidebar { display: none; }
        .main-content { margin-left: var(--sidebar-width); padding: 32px; }
        .bottom-nav { display: none; }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
/**
 * @var array $tipos     Lista de tipos de servicio a mostrar
 * @var bool  $verTodos  Si true, incluye los desactivados en la lista
 */
?>

    <div class="page-header">
        <div>
            <h5 class="fw-bold mb-0" style="font-size: 1.2rem;">Tipos de Servicio</h5>
            <small class="text-muted" style="font-size: 0.7rem;">Catálogo usado por Contadores y Tarifas</small>
        </div>
        <a href="<?= site_url('tipos-servicio/nuevo') ?>" class="btn btn-primary rounded-pill">
            <i class="fas fa-plus me-1"></i> Nuevo
        </a>
    </div>

    <?php if (session()->getFlashdata('exito')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('exito')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <div class="mb-3">
        <?php if ($verTodos): ?>
            <a href="<?= site_url('tipos-servicio') ?>" class="btn btn-sm btn-outline-secondary rounded-pill">
                Ver solo activos
            </a>
        <?php else: ?>
            <a href="<?= site_url('tipos-servicio?ver=todos') ?>" class="btn btn-sm btn-outline-secondary rounded-pill">
                Ver también desactivados
            </a>
        <?php endif; ?>
    </div>

    <div class="list-card">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th class="ps-4">Nombre</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th class="text-end pe-4">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($tipos)): ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">
                            No hay tipos de servicio registrados todavía.
                        </td>
                    </tr>
                <?php endif; ?>

                <?php foreach ($tipos as $tipo): ?>
                    <tr>
                        <td class="ps-4 fw-semibold"><?= esc($tipo['nombre']) ?></td>
                        <td class="text-muted"><?= esc($tipo['descripcion'] ?? '—') ?></td>
                        <td>
                            <?php if ((int) $tipo['activo'] === 1): ?>
                                <span class="badge badge-activo rounded-pill px-2 py-1">Activo</span>
                            <?php else: ?>
                                <span class="badge badge-inactivo rounded-pill px-2 py-1">Inactivo</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end pe-4">
                            <a href="<?= site_url('tipos-servicio/editar/' . $tipo['id']) ?>" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-pen"></i>
                            </a>
                            <?php if ((int) $tipo['activo'] === 1): ?>
                                <form action="<?= site_url('tipos-servicio/desactivar/' . $tipo['id']) ?>" method="post" class="d-inline">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('¿Desactivar este tipo de servicio?');">
                                        <i class="fas fa-ban"></i>
                                    </button>
                                </form>
                            <?php else: ?>
                                <form action="<?= site_url('tipos-servicio/activar/' . $tipo['id']) ?>" method="post" class="d-inline">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?= $this->endSection() ?>