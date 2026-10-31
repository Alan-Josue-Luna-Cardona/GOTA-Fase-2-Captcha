<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Recibo de Lectura<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    :root {
        --primary: #0d6efd;
        --primary-dark: #0a58ca;
        --secondary: #6c757d;
        --success: #198754;
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

    .receipt-card {
        background: #fff;
        border-radius: var(--card-radius);
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(0,0,0,0.03);
        overflow: hidden;
    }

    .receipt-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #fff;
        padding: 20px;
        text-align: center;
    }

    .receipt-section-title {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--secondary);
        font-weight: 700;
        padding: 16px 20px 4px;
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

    /*
     * Al imprimir (Ctrl+P), ocultamos todo lo que no debe salir en papel:
     * header, sidebar, bottom-nav y el botón de imprimir.
     */
    @media print {
        .app-header,
        .sidebar,
        .sidebar-overlay,
        .bottom-nav,
        .no-imprimir {
            display: none !important;
        }
        .main-content {
            margin: 0;
            padding: 0;
            max-width: 100%;
        }
        body {
            padding-bottom: 0;
            background: #fff;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
/**
 * @var array      $lectura      Registro completo de la tabla Lecturas
 * @var array|null $contador     Registro del contador asociado a la lectura
 * @var array|null $cliente      Registro del cliente dueño del contador
 * @var array|null $tipoServicio Registro del tipo de servicio del contador
 */

// El desglose base/exceso solo se muestra si de verdad hubo consumo
// excedente. Si el consumo cupo dentro del volumen incluido, mostrar
// esas filas solo confundiría al cliente con un "Q0.00" sin sentido.
$hayExceso = (float) ($lectura['consumo_exceso_m3'] ?? 0) > 0;
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

    <div class="no-imprimir mb-3 text-end">
        <button onclick="window.print()" class="btn btn-primary rounded-pill">
            <i class="fas fa-print me-1"></i> Imprimir Recibo
        </button>
    </div>

    <div class="receipt-card">
        <div class="receipt-header">
            <h4 class="mb-0">Recibo de Consumo de Agua</h4>
            <small>Sistema GOTA</small>
        </div>

        <!-- Datos del cliente: si por algún motivo el contador o el
             cliente no se encontraron (dato huérfano), mostramos un
             aviso en vez de romper la página con un error de índice. -->
        <?php if ($cliente): ?>
            <div class="receipt-section-title">Datos del cliente</div>
            <div class="px-4 pb-2">
                <table class="table table-borderless mb-0">
                    <tr>
                        <th style="width: 40%;">Nombre:</th>
                        <td><?= esc($cliente['nombre']) ?></td>
                    </tr>
                    <tr>
                        <th>Dirección:</th>
                        <td><?= esc($cliente['direccion']) ?></td>
                    </tr>
                    <?php if (! empty($cliente['telefono'])): ?>
                    <tr>
                        <th>Teléfono:</th>
                        <td><?= esc($cliente['telefono']) ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php if (! empty($cliente['email'])): ?>
                    <tr>
                        <th>Correo:</th>
                        <td><?= esc($cliente['email']) ?></td>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>
        <?php else: ?>
            <div class="px-4 pt-3">
                <div class="alert alert-warning mb-0">
                    No se encontraron los datos del cliente para este contador.
                </div>
            </div>
        <?php endif; ?>

        <div class="receipt-section-title">Datos del contador</div>
        <div class="px-4 pb-2">
            <table class="table table-borderless mb-0">
                <tr>
                    <th style="width: 40%;">Código:</th>
                    <td><?= esc($contador['codigo'] ?? ('#' . $lectura['contador_id'])) ?></td>
                </tr>
                <?php if (! empty($contador['sector'])): ?>
                <tr>
                    <th>Sector:</th>
                    <td><?= esc($contador['sector']) ?></td>
                </tr>
                <?php endif; ?>
                <?php if ($tipoServicio): ?>
                <tr>
                    <th>Tipo de servicio:</th>
                    <td><?= esc($tipoServicio['nombre']) ?></td>
                </tr>
                <?php endif; ?>
            </table>
        </div>

        <div class="receipt-section-title">Lectura</div>
        <div class="px-4 pb-2">
            <table class="table table-borderless mb-0">
                <tr>
                    <th style="width: 40%;">Fecha de lectura:</th>
                    <td><?= esc(date('d/m/Y', strtotime($lectura['fecha_lectura']))) ?></td>
                </tr>
                <tr>
                    <th>Período:</th>
                    <td><?= esc(date('m/Y', strtotime($lectura['periodo']))) ?></td>
                </tr>
                <tr>
                    <th>Lectura anterior:</th>
                    <td><?= esc((string) $lectura['lectura_anterior']) ?> m³</td>
                </tr>
                <tr>
                    <th>Lectura actual:</th>
                    <td><?= esc((string) $lectura['lectura_actual']) ?> m³</td>
                </tr>
                <tr class="table-active">
                    <th>Consumo total:</th>
                    <td><strong><?= esc((string) $lectura['consumo']) ?> m³</strong></td>
                </tr>
            </table>
        </div>

        <div class="receipt-section-title">Cobro</div>
        <div class="px-4 pb-2">
            <table class="table table-borderless mb-0">
                <?php if ($hayExceso): ?>
                    <!-- Solo se desglosa base/exceso cuando de verdad hubo
                         consumo excedente. Con consumo dentro del volumen
                         incluido, esto se omite para no confundir con
                         filas en Q0.00. -->
                    <tr>
                        <th style="width: 55%;">Consumo dentro de tarifa base:</th>
                        <td><?= esc((string) $lectura['consumo_base_m3']) ?> m³ × Q<?= esc(number_format((float) $lectura['tarifa_base_valor'], 2)) ?></td>
                    </tr>
                    <tr>
                        <th>Monto base:</th>
                        <td>Q<?= esc(number_format((float) $lectura['monto_base'], 2)) ?></td>
                    </tr>
                    <tr>
                        <th>Consumo excedente:</th>
                        <td><?= esc((string) $lectura['consumo_exceso_m3']) ?> m³ × Q<?= esc(number_format((float) $lectura['tarifa_exceso_valor'], 2)) ?></td>
                    </tr>
                    <tr>
                        <th>Monto por excedente:</th>
                        <td>Q<?= esc(number_format((float) $lectura['monto_exceso'], 2)) ?></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <th style="width: 55%;">Tarifa aplicada:</th>
                        <td>Q<?= esc(number_format((float) $lectura['tarifa_base_valor'], 2)) ?> por m³</td>
                    </tr>
                <?php endif; ?>
                <tr class="table-success">
                    <th>Monto total a pagar:</th>
                    <td><strong>Q<?= esc(number_format((float) $lectura['monto_total'], 2)) ?></strong></td>
                </tr>
            </table>
        </div>

        <div class="text-center text-muted py-3 border-top">
            <small>Recibo #<?= esc((string) $lectura['id']) ?> — Generado el <?= date('d/m/Y H:i') ?></small>
        </div>
    </div>

    <div class="no-imprimir mt-3 text-center">
        <a href="<?= site_url('dashboard') ?>" class="btn btn-outline-secondary rounded-pill">Volver al Dashboard</a>
    </div>

</main>

<nav class="bottom-nav no-imprimir">
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