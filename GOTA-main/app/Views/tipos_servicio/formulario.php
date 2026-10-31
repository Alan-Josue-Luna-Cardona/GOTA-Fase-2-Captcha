<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?><?= $modo === 'crear' ? 'Nuevo' : 'Editar' ?> Tipo de Servicio<?= $this->endSection() ?>

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

    .main-content { padding: 16px; max-width: 600px; margin: 0 auto; }

    .form-card {
        background: #fff;
        border-radius: var(--card-radius);
        padding: 24px;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(0,0,0,0.03);
    }

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
 * @var array|null $tipo  Datos del tipo de servicio si estamos editando, null si es nuevo
 * @var string      $modo 'crear' o 'editar'
 */
$esEdicion = $modo === 'editar';
$accionUrl = $esEdicion
    ? site_url('tipos-servicio/actualizar/' . $tipo['id'])
    : site_url('tipos-servicio/crear');
?>

    <div class="mb-3">
        <h5 class="fw-bold mb-0" style="font-size: 1.2rem;">
            <?= $esEdicion ? 'Editar' : 'Nuevo' ?> Tipo de Servicio
        </h5>
        <small class="text-muted" style="font-size: 0.7rem;">
            Ej: Residencial, Comercial, Industrial, Institucional
        </small>
    </div>

    <div class="form-card">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>

        <form action="<?= $accionUrl ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input
                    type="text"
                    name="nombre"
                    class="form-control"
                    maxlength="50"
                    required
                    autofocus
                    value="<?= esc(old('nombre', $tipo['nombre'] ?? '')) ?>"
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Descripción <span class="text-muted">(opcional)</span></label>
                <textarea
                    name="descripcion"
                    class="form-control"
                    maxlength="200"
                    rows="3"
                ><?= esc(old('descripcion', $tipo['descripcion'] ?? '')) ?></textarea>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary rounded-pill flex-grow-1">
                    <i class="fas fa-save me-1"></i> Guardar
                </button>
                <a href="<?= site_url('tipos-servicio') ?>" class="btn btn-outline-secondary rounded-pill">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
<?= $this->endSection() ?>