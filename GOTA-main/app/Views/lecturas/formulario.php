<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Registrar Lectura<?= $this->endSection() ?>

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

    .main-content { padding: 16px; max-width: 700px; margin: 0 auto; }

    .form-card {
        background: #fff;
        border-radius: var(--card-radius);
        padding: 24px;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(0,0,0,0.03);
    }

    .contador-info {
        background: #f0f6ff;
        border: 1px solid #d6e6ff;
        border-radius: 12px;
        padding: 14px 16px;
        margin-bottom: 20px;
        font-size: 0.85rem;
    }
    .contador-info .label {
        color: var(--secondary);
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
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
 * @var int        $contador_id
 * @var float      $lectura_anterior
 * @var array|null $contador
 * @var array|null $tipoServicio
 */
?>

<header class="app-header">
    <div class="brand">
        <button class="menu-toggle" id="menuToggle" aria-label="Abrir menú">
            <i class="fas fa-bars"></i>
        </button>
        <div>
            <h5>GOTA</h5>
            <small>Sistema de Agua</small>
        </div>
    </div>
    <div class="header-actions">
        <div class="user-avatar" id="userAvatar">
            <?= esc(gota_initials(session()->get('usuario_nombre'))) ?>
        </div>
    </div>
</header>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <h4><span>GOTA</span>·agua</h4>
        <button class="close-sidebar" id="closeSidebar">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <ul class="sidebar-menu">
        <li class="menu-label">Menú Principal</li>
        <li><a href="<?= site_url('dashboard') ?>" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 14px; width: 100%;"><i class="fas fa-th-large"></i><span>Dashboard</span></a></li>
        <li><a href="<?= site_url('clientes') ?>" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 14px; width: 100%;"><i class="fas fa-users"></i><span>Clientes</span></a></li>
        <li><a href="<?= site_url('contadores') ?>" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 14px; width: 100%;"><i class="fas fa-gauge-high"></i><span>Contadores</span></a></li>
        <li class="active"><a href="<?= site_url('pagos/pendientes') ?>" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 14px; width: 100%;"><i class="fas fa-file-invoice"></i><span>Lecturas</span></a></li>
        <li><a href="<?= site_url('pagos') ?>" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 14px; width: 100%;"><i class="fas fa-money-bill-wave"></i><span>Pagos</span></a></li>
        <li><a href="<?= site_url('tarifas') ?>" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 14px; width: 100%;"><i class="fas fa-tags"></i><span>Tarifas</span></a></li>
        <li class="menu-label">Sesión</li>
        <li>
            <a href="<?= site_url('logout') ?>" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 14px; width: 100%;">
                <i class="fas fa-sign-out-alt"></i>
                <span>Cerrar Sesión</span>
            </a>
        </li>
    </ul>
</aside>

<main class="main-content">
    <div class="mb-3">
        <h5 class="fw-bold mb-0" style="font-size: 1.2rem;">Registrar Lectura</h5>
        <small class="text-muted" style="font-size: 0.7rem;">Contador #<?= esc((string) $contador_id) ?></small>
    </div>

    <div class="form-card">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <?php if ($contador): ?>
            <!-- Info del contador/cliente para que el Lector confirme que
                 está tomando la lectura del predio correcto antes de
                 ingresar el número. -->
            <div class="contador-info">
                <div class="label">Código de contador</div>
                <div class="fw-semibold mb-2"><?= esc($contador['codigo']) ?></div>
                <?php if (! empty($contador['sector'])): ?>
                    <div class="label">Sector</div>
                    <div class="fw-semibold mb-2"><?= esc($contador['sector']) ?></div>
                <?php endif; ?>
                <?php if ($tipoServicio): ?>
                    <div class="label">Tipo de servicio</div>
                    <div class="fw-semibold"><?= esc($tipoServicio['nombre']) ?></div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">
                No se encontró información de este contador. Verifica el número antes de continuar.
            </div>
        <?php endif; ?>

        <form action="<?= site_url('lecturas/guardar') ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="contador_id" value="<?= esc((string) $contador_id) ?>">

            <div class="mb-3">
                <label class="form-label">Lectura anterior</label>
                <input type="text" class="form-control" value="<?= esc((string) $lectura_anterior) ?>" disabled>
                <!-- Este campo oculto es solo informativo para el humano.
                     El cálculo real en el servidor SIEMPRE vuelve a
                     consultar la última lectura de la BD, nunca confía
                     en este valor. -->
                <input type="hidden" name="lectura_anterior" value="<?= esc((string) $lectura_anterior) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Lectura actual (m³)</label>
                <input type="number" step="0.01" name="lectura_actual" class="form-control" required autofocus>
            </div>

            <button type="submit" class="btn btn-primary w-100 rounded-pill">
                <i class="fas fa-save me-1"></i> Guardar Lectura
            </button>
        </form>
    </div>
</main>

<nav class="bottom-nav">
    <a href="<?= site_url('dashboard') ?>" class="nav-item">
        <i class="fas fa-th-large"></i>
        <span>Dashboard</span>
    </a>
    <button class="nav-item active">
        <i class="fas fa-file-invoice"></i>
        <span>Lecturas</span>
    </button>
</nav>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const closeSidebar = document.getElementById('closeSidebar');

        function toggleSidebar() {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('active');
            document.body.style.overflow = sidebar.classList.contains('open') ? 'hidden' : '';
        }

        menuToggle?.addEventListener('click', toggleSidebar);
        closeSidebar?.addEventListener('click', toggleSidebar);
        overlay?.addEventListener('click', toggleSidebar);
    });
</script>
<?= $this->endSection() ?>