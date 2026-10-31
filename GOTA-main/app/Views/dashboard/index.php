<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Dashboard - GOTA<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    /* ============================================
       VARIABLES Y RESET
       ============================================ */
    :root {
        --primary: #0d6efd;
        --primary-dark: #0a58ca;
        --secondary: #6c757d;
        --success: #198754;
        --danger: #dc3545;
        --warning: #ffc107;
        --sidebar-width: 280px;
        --header-height: 60px;
        --card-radius: 16px;
        --shadow-sm: 0 2px 8px rgba(0,0,0,0.06);
        --shadow-md: 0 4px 20px rgba(0,0,0,0.08);
        --shadow-lg: 0 8px 40px rgba(0,0,0,0.12);
    }

    * {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        box-sizing: border-box;
    }

    body {
        background: var(--app-bg);
        padding: 0;
        margin: 0;
        min-height: 100vh;
        padding-bottom: 80px; /* Espacio para navegación inferior */
        transition: background 0.3s ease, color 0.3s ease;
    }

    /* ============================================
       HEADER SUPERIOR (Mobile First)
       ============================================ */
    .app-header {
        position: sticky;
        top: 0;
        z-index: 1000;
        background: var(--app-surface);
        padding: 12px 16px;
        box-shadow: var(--app-shadow-sm);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .app-header .brand {
        display: flex;
        align-items: center;
        gap: 10px;
    }

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
        color: var(--app-muted);
        -webkit-text-fill-color: var(--app-muted);
        display: block;
        font-weight: 400;
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .header-actions .btn-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: none;
        background: var(--app-card-soft);
        color: var(--app-text);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        position: relative;
    }

    .header-actions .btn-icon:active {
        transform: scale(0.92);
    }

    .header-actions .badge-dot {
        position: absolute;
        top: 6px;
        right: 6px;
        width: 10px;
        height: 10px;
        background: var(--danger);
        border-radius: 50%;
        border: 2px solid #fff;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        border: 2px solid var(--app-surface);
        box-shadow: var(--shadow-sm);
    }

    /* ============================================
       BOTÓN HAMBURGUESA (Sidebar Toggle)
       ============================================ */
    .menu-toggle {
        display: none;
        background: none;
        border: none;
        font-size: 1.5rem;
        color: var(--app-text);
        padding: 4px 8px;
    }

    /* ============================================
       SIDEBAR (Off-canvas Mobile)
       ============================================ */
    .sidebar-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        z-index: 2000;
        backdrop-filter: blur(4px);
    }

    .sidebar-overlay.active {
        display: block;
    }

    .sidebar {
        position: fixed;
        top: 0;
        left: -100%;
        width: var(--sidebar-width);
        height: 100vh;
        background: #1a1a2e;
        color: #fff;
        padding: 0;
        z-index: 3000;
        transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow-y: auto;
    }

    .sidebar.open {
        left: 0;
    }

    .sidebar-brand {
        padding: 24px 20px;
        border-bottom: 1px solid rgba(255,255,255,0.08);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .sidebar-brand h4 {
        margin: 0;
        font-weight: 800;
    }

    .sidebar-brand h4 span {
        color: #4fc3f7;
    }

    .sidebar-brand .close-sidebar {
        background: none;
        border: none;
        color: rgba(255,255,255,0.6);
        font-size: 1.5rem;
    }

    .sidebar-menu {
        list-style: none;
        padding: 12px 0;
        margin: 0;
    }

    .sidebar-menu .menu-label {
        padding: 12px 20px 6px;
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: rgba(255,255,255,0.3);
        font-weight: 600;
    }

    .sidebar-menu li {
        padding: 0;
        transition: all 0.2s ease;
        border-left: 3px solid transparent;
    }

    .sidebar-menu li a {
        padding: 12px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        color: rgba(255,255,255,0.65);
        font-size: 0.9rem;
        font-weight: 500;
        text-decoration: none;
        width: 100%;
    }

    .sidebar-menu li:active {
        transform: scale(0.97);
    }

    .sidebar-menu li:hover,
    .sidebar-menu li.active {
        background: rgba(79, 195, 247, 0.08);
        border-left-color: #4fc3f7;
    }

    .sidebar-menu li:hover a,
    .sidebar-menu li.active a {
        color: #fff;
    }

    .sidebar-menu li i {
        width: 22px;
        font-size: 1.1rem;
        text-align: center;
    }

    .sidebar-menu li .badge-menu {
        margin-left: auto;
        background: var(--danger);
        color: #fff;
        font-size: 0.65rem;
        padding: 2px 10px;
        border-radius: 20px;
    }

    /* ============================================
       CONTENIDO PRINCIPAL
       ============================================ */
    .main-content {
        padding: 16px;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* ============================================
       TARJETAS DE ESTADÍSTICAS (Mobile First)
       ============================================ */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-bottom: 20px;
    }

    .stat-card {
        background: var(--app-card);
        border-radius: var(--card-radius);
        padding: 16px;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
        border: 1px solid var(--app-border);
    }

    .stat-card:active {
        transform: scale(0.97);
    }

    .stat-card .stat-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 10px;
    }

    .stat-card .stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .stat-card .stat-change {
        font-size: 0.6rem;
        font-weight: 700;
        padding: 2px 10px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 3px;
    }

    .stat-change.up {
        background: #d4edda;
        color: #155724;
    }

    .stat-change.down {
        background: #f8d7da;
        color: #721c24;
    }

    .stat-card .stat-number {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--app-text);
        margin: 0;
        line-height: 1.2;
    }

    .stat-card .stat-label {
        color: var(--app-muted);
        font-size: 0.7rem;
        font-weight: 500;
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .stat-card .stat-sub {
        font-size: 0.6rem;
        color: var(--app-muted);
        margin-top: 4px;
    }

    /* ============================================
       TARJETAS DE ANALÍTICAS
       ============================================ */
    .analytics-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-bottom: 20px;
    }

    .analytics-card {
        background: var(--app-card);
        border-radius: var(--card-radius);
        padding: 14px;
        text-align: center;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--app-border);
    }

    .analytics-card .analytics-number {
        font-size: 1.3rem;
        font-weight: 800;
        color: var(--app-text);
    }

    .analytics-card .analytics-label {
        color: var(--app-muted);
        font-size: 0.6rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin: 0;
    }

    /* ============================================
       TABLA DE LECTURAS (Mobile Optimized)
       ============================================ */
    .table-container {
        background: var(--app-card);
        border-radius: var(--card-radius);
        padding: 16px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--app-border);
    }

    .table-container .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 14px;
        flex-wrap: wrap;
        gap: 8px;
    }

    .table-container .table-header h6 {
        font-weight: 700;
        margin: 0;
        font-size: 0.9rem;
    }

    .table-container .table-header .btn-sm {
        font-size: 0.7rem;
        padding: 4px 12px;
    }

    /* Cards para móvil en lugar de tabla */
    .lectura-card {
        background: var(--app-card-soft);
        border-radius: 12px;
        padding: 14px;
        margin-bottom: 10px;
        border-left: 4px solid var(--warning);
        transition: all 0.2s ease;
    }

    .lectura-card:active {
        transform: scale(0.98);
    }

    .lectura-card.pagado {
        border-left-color: var(--success);
    }

    .lectura-card.pendiente {
        border-left-color: var(--warning);
    }

    .lectura-card .lectura-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 8px;
    }

    .lectura-card .lectura-cliente {
        font-weight: 700;
        font-size: 0.9rem;
        color: var(--app-text);
    }

    .lectura-card .lectura-cliente small {
        font-weight: 400;
        color: var(--app-muted);
        font-size: 0.7rem;
        display: block;
    }

    .lectura-card .badge-status {
        padding: 3px 12px;
        border-radius: 20px;
        font-size: 0.6rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        white-space: nowrap;
    }

    .badge-status.pagado {
        background: #d4edda;
        color: #155724;
    }

    .badge-status.pendiente {
        background: #fff3cd;
        color: #856404;
    }

    .badge-status.anulado {
        background: #f8d7da;
        color: #721c24;
    }

    .badge-status.sin-consumo {
        background: #e9ecef;
        color: #6c757d;
    }

    .lectura-card .lectura-details {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
        margin: 10px 0;
        padding: 10px;
        background: var(--app-card);
        border-radius: 8px;
    }

    .lectura-card .lectura-details .detail-item {
        text-align: center;
    }

    .lectura-card .lectura-details .detail-item .value {
        font-weight: 700;
        font-size: 0.85rem;
        color: var(--app-text);
    }

    .lectura-card .lectura-details .detail-item .label {
        font-size: 0.55rem;
        color: var(--app-muted);
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .lectura-card .lectura-actions {
        display: flex;
        gap: 8px;
        justify-content: flex-end;
        margin-top: 8px;
    }

    .lectura-card .lectura-actions .btn {
        font-size: 0.7rem;
        padding: 4px 12px;
        border-radius: 8px;
    }

    /* ============================================
       PAGINACIÓN
       ============================================ */
    .pagination-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 16px;
        flex-wrap: wrap;
        gap: 8px;
    }

    .pagination-wrapper small {
        font-size: 0.7rem;
        color: var(--app-muted);
    }

    .pagination-wrapper .pagination {
        margin: 0;
    }

    .pagination-wrapper .page-link {
        font-size: 0.75rem;
        padding: 4px 10px;
    }

    /* ============================================
       BOTTOM NAV (Mobile)
       ============================================ */
    .bottom-nav {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: var(--app-surface);
        display: flex;
        justify-content: space-around;
        align-items: center;
        padding: 8px 0;
        box-shadow: var(--shadow-sm);
        z-index: 1000;
        border-top: 1px solid var(--app-border);
    }

    .bottom-nav .nav-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 2px;
        background: none;
        border: none;
        color: var(--app-muted);
        font-size: 0.55rem;
        padding: 4px 12px;
        transition: all 0.2s ease;
        text-decoration: none;
        font-weight: 500;
    }

    .bottom-nav .nav-item i {
        font-size: 1.2rem;
    }

    .bottom-nav .nav-item.active {
        color: var(--primary);
    }

    .bottom-nav .nav-item:active {
        transform: scale(0.9);
    }

    .bottom-nav .nav-item .nav-badge {
        position: absolute;
        top: -4px;
        right: -4px;
        background: var(--danger);
        color: #fff;
        font-size: 0.5rem;
        padding: 1px 6px;
        border-radius: 20px;
    }

    .bottom-nav .nav-item-wrapper {
        position: relative;
    }

    /* ============================================
       MEDIA QUERIES - TABLET Y DESKTOP
       ============================================ */
    @media (min-width: 768px) {
        body {
            padding-bottom: 0;
        }

        .app-header {
            padding: 16px 32px;
        }

        .app-header .brand h5 {
            font-size: 1.3rem;
        }

        .menu-toggle {
            display: block;
        }

        .sidebar {
            left: 0 !important;
            position: fixed;
            width: var(--sidebar-width);
            transform: none !important;
            box-shadow: 2px 0 20px rgba(0,0,0,0.05);
        }

        .sidebar-overlay {
            display: none !important;
        }

        .sidebar .close-sidebar {
            display: none;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            padding: 32px;
        }

        .stat-grid {
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }

        .analytics-grid {
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }

        .stat-card .stat-number {
            font-size: 2rem;
        }

        /* Ocultar bottom nav en desktop */
        .bottom-nav {
            display: none;
        }

        /* Mostrar tabla en desktop */
        .lectura-card {
            display: none;
        }

        .table-desktop {
            display: table;
        }

        .table-container .table {
            margin-bottom: 0;
        }

        .table-container .table thead th {
            font-size: 0.7rem;
            padding: 10px 12px;
        }

        .table-container .table tbody td {
            font-size: 0.8rem;
            padding: 10px 12px;
            vertical-align: middle;
        }
    }

    @media (max-width: 767px) {
        .table-desktop {
            display: none;
        }

        .sidebar {
            left: -100%;
        }

        .sidebar.open {
            left: 0;
        }

        .sidebar-overlay.active {
            display: block;
        }
    }

    @media (max-width: 480px) {
        .stat-grid {
            gap: 8px;
        }

        .stat-card {
            padding: 12px;
        }

        .stat-card .stat-number {
            font-size: 1.2rem;
        }

        .stat-card .stat-label {
            font-size: 0.6rem;
        }

        .analytics-grid {
            gap: 8px;
        }

        .analytics-card {
            padding: 10px;
        }

        .analytics-card .analytics-number {
            font-size: 1.1rem;
        }

        .lectura-card .lectura-details {
            grid-template-columns: repeat(3, 1fr);
            gap: 4px;
            padding: 8px;
        }

        .lectura-card .lectura-details .detail-item .value {
            font-size: 0.75rem;
        }
    }

    /* ============================================
       UTILIDADES
       ============================================ */
    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .skeleton {
        animation: pulse 1.5s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <!-- Título -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h5 class="fw-bold mb-0" style="font-size: 1.2rem;">Dashboard</h5>
            <small class="text-muted" style="font-size: 0.7rem;">
                <?= date('d/m/Y') ?> · <?= date('H:i') ?> hs
            </small>
        </div>
        <a href="<?= current_url() ?>" class="btn btn-primary btn-sm rounded-pill px-3" style="font-size: 0.75rem;">
            <i class="fas fa-sync-alt me-1"></i> Actualizar
        </a>
    </div>

    <!-- ==========================================
    TARJETAS DE ESTADÍSTICAS (Mobile First)
    ========================================== -->
    <div class="stat-grid">
        <!-- Clientes -->
        <div class="stat-card">
            <div class="stat-top">
                <div class="stat-icon" style="background: #e3f2fd; color: #0d6efd;">
                    <i class="fas fa-users"></i>
                </div>
                <span class="stat-change up">
                    <i class="fas fa-arrow-up"></i> <?= $clientesPorcentaje ?? 0 ?>%
                </span>
            </div>
            <p class="stat-number"><?= number_format($totalClientes ?? 0) ?></p>
            <p class="stat-label">Clientes Activos</p>
            <p class="stat-sub">+<?= $clientesNuevos ?? 0 ?> este mes</p>
        </div>

        <!-- Consumo -->
        <div class="stat-card">
            <div class="stat-top">
                <div class="stat-icon" style="background: #e8f5e9; color: #2e7d32;">
                    <i class="fas fa-water"></i>
                </div>
                <span class="stat-change up">
                    <i class="fas fa-arrow-up"></i> <?= $consumoPorcentaje ?? 0 ?>%
                </span>
            </div>
            <p class="stat-number"><?= number_format($consumoTotal ?? 0) ?></p>
            <p class="stat-label">m³ Consumidos</p>
            <p class="stat-sub"><?= $lecturasMes ?? 0 ?> lecturas este mes</p>
        </div>

        <!-- Ingresos -->
        <div class="stat-card">
            <div class="stat-top">
                <div class="stat-icon" style="background: #fff3e0; color: #e65100;">
                    <i class="fas fa-coin"></i>
                </div>
                <span class="stat-change up">
                    <i class="fas fa-arrow-up"></i> <?= $ingresosPorcentaje ?? 0 ?>%
                </span>
            </div>
            <p class="stat-number">Q<?= number_format($ingresosMes ?? 0, 0, ',', '.') ?></p>
            <p class="stat-label">Ingresos del Mes</p>
            <p class="stat-sub"><?= $pagosMes ?? 0 ?> pagos realizados</p>
        </div>

        <!-- Pendientes -->
        <div class="stat-card">
            <div class="stat-top">
                <div class="stat-icon" style="background: #fce4ec; color: #c62828;">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <span class="stat-change down">
                    <i class="fas fa-arrow-down"></i> <?= $pendientesPorcentaje ?? 0 ?>%
                </span>
            </div>
            <p class="stat-number"><?= $lecturasPendientes ?? 0 ?></p>
            <p class="stat-label">Pagos Pendientes</p>
            <p class="stat-sub">Q<?= number_format($montoPendiente ?? 0, 0, ',', '.') ?> por cobrar</p>
        </div>
    </div>

    <!-- ==========================================
    TARJETAS DE ANALÍTICAS
    ========================================== -->
    <div class="analytics-grid">
        <div class="analytics-card">
            <p class="analytics-number text-success"><?= $tasaEntrega ?? 0 ?>%</p>
            <p class="analytics-label">Entregas Exitosas</p>
        </div>
        <div class="analytics-card">
            <p class="analytics-number text-primary"><?= $tasaApertura ?? 0 ?>%</p>
            <p class="analytics-label">Apertura Única</p>
        </div>
        <div class="analytics-card">
            <p class="analytics-number text-info"><?= $reenvios ?? 0 ?></p>
            <p class="analytics-label">Reenviados</p>
        </div>
        <div class="analytics-card">
            <p class="analytics-number text-danger"><?= $reportesAbuso ?? 0 ?></p>
            <p class="analytics-label">Reportes de Abuso</p>
        </div>
    </div>

    <!-- ==========================================
    TABLA DE LECTURAS PENDIENTES
    ========================================== -->
    <div class="table-container">
        <div class="table-header">
            <h6>
                <i class="fas fa-file-invoice me-2 text-primary"></i>
                Lecturas Pendientes
            </h6>
            <a href="<?= site_url('pagos/pendientes') ?>" class="btn btn-sm btn-outline-primary rounded-pill">
                <i class="fas fa-eye me-1"></i> Ver todas
            </a>
        </div>

        <!-- ======================================
        VISTA MÓVIL - Cards
        ====================================== -->
        <div class="lectura-cards">
            <?php if (!empty($lecturas)): ?>
                <?php foreach ($lecturas as $lectura): ?>
                    <div class="lectura-card <?= $lectura['estado'] ?? 'pendiente' ?>">
                        <div class="lectura-top">
                            <div>
                                <div class="lectura-cliente">
                                    <?= esc($lectura['cliente_nombre'] ?? 'Cliente') ?>
                                    <small><?= esc($lectura['contador_codigo'] ?? 'N/A') ?></small>
                                </div>
                            </div>
                            <span class="badge-status <?= $lectura['estado'] ?? 'pendiente' ?>">
                                <?= ucfirst($lectura['estado'] ?? 'pendiente') ?>
                            </span>
                        </div>

                        <div class="lectura-details">
                            <div class="detail-item">
                                <div class="value"><?= $lectura['consumo'] ?? 0 ?></div>
                                <div class="label">m³</div>
                            </div>
                            <div class="detail-item">
                                <div class="value">Q<?= number_format($lectura['monto_total'] ?? 0, 2) ?></div>
                                <div class="label">Monto</div>
                            </div>
                            <div class="detail-item">
                                <div class="value"><?= date('M Y', strtotime($lectura['periodo'] ?? 'now')) ?></div>
                                <div class="label">Período</div>
                            </div>
                        </div>

                        <div class="lectura-actions">
                            <a href="<?= site_url('lecturas/recibo/' . $lectura['id']) ?>" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-receipt"></i> Ver recibo
                            </a>
                            <a href="<?= site_url('pagos/registrar/' . $lectura['id']) ?>" class="btn btn-success btn-sm">
                                <i class="fas fa-check"></i> Pagar
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-check-circle fa-2x mb-2 d-block text-success"></i>
                    <p class="mb-0">No hay lecturas pendientes</p>
                    <small>Todos los pagos están al día</small>
                </div>
            <?php endif; ?>
        </div>

        <!-- ======================================
        VISTA DESKTOP - Tabla
        ====================================== -->
        <div class="table-responsive table-desktop">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Contador</th>
                        <th>Consumo</th>
                        <th>Monto</th>
                        <th>Período</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($lecturas)): ?>
                        <?php foreach ($lecturas as $index => $lectura): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td>
                                    <strong><?= esc($lectura['cliente_nombre'] ?? '') ?></strong>
                                </td>
                                <td><?= esc($lectura['contador_codigo'] ?? '') ?></td>
                                <td><?= $lectura['consumo'] ?? 0 ?> m³</td>
                                <td>Q<?= number_format($lectura['monto_total'] ?? 0, 2) ?></td>
                                <td><?= date('M Y', strtotime($lectura['periodo'] ?? 'now')) ?></td>
                                <td>
                                    <span class="badge-status <?= $lectura['estado'] ?? 'pendiente' ?>">
                                        <?= ucfirst($lectura['estado'] ?? 'Pendiente') ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?= site_url('lecturas/recibo/' . $lectura['id']) ?>" class="btn btn-sm btn-outline-primary me-1" title="Ver recibo">
                                        <i class="fas fa-receipt"></i>
                                    </a>
                                    <a href="<?= site_url('pagos/registrar/' . $lectura['id']) ?>" class="btn btn-sm btn-success" title="Registrar Pago">
                                        <i class="fas fa-check"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-3">
                                No hay lecturas pendientes
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="pagination-wrapper">
            <small>
                Mostrando <?= $inicio ?? 1 ?>-<?= $fin ?? 5 ?> de <?= $totalRegistros ?? 0 ?> lecturas
            </small>
            <nav>
                <ul class="pagination pagination-sm">
                    <li class="page-item <?= ($paginaActual ?? 1) <= 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="#">Anterior</a>
                    </li>
                    <?php for ($i = 1; $i <= ($totalPaginas ?? 1); $i++): ?>
                        <li class="page-item <?= ($paginaActual ?? 1) == $i ? 'active' : '' ?>">
                            <a class="page-link" href="#"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?= ($paginaActual ?? 1) >= ($totalPaginas ?? 1) ? 'disabled' : '' ?>">
                        <a class="page-link" href="#">Siguiente</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

<?= $this->endSection() ?>