<!-- app/Views/layouts/main.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title><?= $this->renderSection('title') ?> - GOTA</title>
    <script>
        (function () {
            var theme = localStorage.getItem('gotaTheme') ||
                (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            document.documentElement.setAttribute('data-theme', theme);
            document.documentElement.setAttribute('data-bs-theme', theme);
        })();
    </script>
    
    <!-- Bootstrap 5 Mobile First -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <?= $this->renderSection('styles') ?>
    <style>
        :root {
            --app-primary: #0d6efd;
            --app-primary-dark: #0a58ca;
            --app-sidebar-width: 280px;
            --app-bg: #f5f7fb;
            --app-surface: #ffffff;
            --app-card: #ffffff;
            --app-card-soft: #f8f9fa;
            --app-border: rgba(0, 0, 0, 0.05);
            --app-text: #1a1a2e;
            --app-muted: #6c757d;
            --app-shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.06);
            --app-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        }

        html[data-theme="dark"] {
            --app-primary: #4f9dff;
            --app-primary-dark: #3a7ce0;
            --app-bg: #0f1220;
            --app-surface: #181c2e;
            --app-card: #1e2437;
            --app-card-soft: #252b40;
            --app-border: rgba(255, 255, 255, 0.08);
            --app-text: #e9edf5;
            --app-muted: #94a0b8;
            --app-shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.35);
            --app-shadow: 0 2px 12px rgba(0, 0, 0, 0.4);
        }

        body {
            background: var(--app-bg);
            min-height: 100vh;
            padding-bottom: 72px;
            transition: background 0.3s ease, color 0.3s ease;
        }

        .app-header {
            position: sticky;
            top: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            background: var(--app-surface);
            box-shadow: var(--app-shadow);
        }

        .app-header .brand,
        .app-header .header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .app-header .brand h5 {
            margin: 0;
            color: var(--app-primary);
            font-weight: 800;
        }

        .app-header .brand small {
            display: block;
            color: var(--app-muted);
            font-size: 0.65rem;
        }

        .theme-toggle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid var(--app-border);
            background: var(--app-card-soft);
            color: var(--app-text);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .theme-toggle:hover {
            color: var(--app-primary);
            border-color: var(--app-primary);
        }

        .menu-toggle,
        .close-sidebar {
            border: 0;
            background: transparent;
        }

        .menu-toggle {
            color: var(--app-text);
            font-size: 1.4rem;
        }

        .user-avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--app-primary), var(--app-primary-dark));
            color: #fff;
            font-weight: 700;
        }

        .shared-sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 2000;
            background: rgba(0, 0, 0, 0.5);
        }

        .shared-sidebar-overlay.active { display: block; }

        .shared-sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 3000;
            width: var(--app-sidebar-width);
            overflow-y: auto;
            background: #1a1a2e;
            color: #fff;
            transform: translateX(-100%);
            transition: transform 0.25s ease;
        }

        .shared-sidebar.open { transform: translateX(0); }

        .shared-sidebar-brand {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 24px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .shared-sidebar-brand strong { color: #4fc3f7; }
        .shared-sidebar-brand .close-sidebar { color: rgba(255, 255, 255, 0.7); font-size: 1.4rem; }
        .shared-sidebar-menu { list-style: none; padding: 12px 0; margin: 0; }
        .shared-sidebar-menu .menu-label {
            padding: 12px 20px 6px;
            color: rgba(255, 255, 255, 0.35);
            font-size: 0.65rem;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .shared-sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 20px;
            border-left: 3px solid transparent;
            color: rgba(255, 255, 255, 0.65);
            font-size: 0.9rem;
            text-decoration: none;
        }

        .shared-sidebar-menu a:hover,
        .shared-sidebar-menu a.active {
            border-left-color: #4fc3f7;
            background: rgba(79, 195, 247, 0.08);
            color: #fff;
        }

        .shared-sidebar-menu i { width: 22px; text-align: center; }

        .shared-main-content { padding: 16px; }

        .shared-bottom-nav {
            position: fixed;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-around;
            padding: 8px 0;
            border-top: 1px solid var(--app-border);
            background: var(--app-surface);
            box-shadow: var(--app-shadow);
        }

        .shared-bottom-nav a {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
            color: var(--app-muted);
            font-size: 0.6rem;
            text-decoration: none;
        }

        .shared-bottom-nav a.active { color: var(--app-primary); }
        .shared-bottom-nav i { font-size: 1.15rem; }

        @media (min-width: 768px) {
            body { padding-bottom: 0; }
            .app-header { padding: 16px 32px; }
            .menu-toggle { display: none; }
            .shared-sidebar { transform: translateX(0); }
            .shared-sidebar-overlay,
            .shared-bottom-nav { display: none; }
            .shared-main-content { margin-left: var(--app-sidebar-width); padding: 32px; }
        }
    </style>
</head>
<body>
    <?php
        $currentPath = trim(uri_string(), '/');
        $sharedShellExcluded = str_starts_with($currentPath, 'lecturas/');
    ?>

    <?php if (! $sharedShellExcluded && session()->get('isLoggedIn')): ?>
        <?php $activeSection = explode('/', $currentPath)[0] ?: 'dashboard'; ?>
        <header class="app-header">
            <div class="brand">
                <button class="menu-toggle" id="sharedMenuToggle" aria-label="Abrir menú">
                    <i class="fas fa-bars"></i>
                </button>
                <div>
                    <h5>GOTA</h5>
                    <small>Sistema de Agua</small>
                </div>
            </div>
            <div class="header-actions">
                <?php if ($activeSection === 'dashboard'): ?>
                    <button type="button" class="theme-toggle" id="themeToggle" aria-label="Cambiar tema claro/oscuro">
                        <i class="fas fa-moon"></i>
                    </button>
                <?php endif; ?>
                <div class="user-avatar">
                    <?= esc(gota_initials(session()->get('usuario_nombre'))) ?>
                </div>
            </div>
        </header>

        <div class="shared-sidebar-overlay" id="sharedSidebarOverlay"></div>
        <aside class="shared-sidebar" id="sharedSidebar">
            <div class="shared-sidebar-brand">
                <h4 class="mb-0"><strong>GOTA</strong>·agua</h4>
                <button class="close-sidebar" id="sharedCloseSidebar" aria-label="Cerrar menú">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <nav class="shared-sidebar-menu">
                <div class="menu-label">Menú Principal</div>
                <a class="<?= $activeSection === 'dashboard' ? 'active' : '' ?>" href="<?= site_url('dashboard') ?>"><i class="fas fa-th-large"></i>Dashboard</a>
                <a class="<?= $activeSection === 'clientes' ? 'active' : '' ?>" href="<?= site_url('clientes') ?>"><i class="fas fa-users"></i>Clientes</a>
                <a class="<?= $activeSection === 'contadores' ? 'active' : '' ?>" href="<?= site_url('contadores') ?>"><i class="fas fa-gauge-high"></i>Contadores</a>
                <a class="<?= $activeSection === 'pagos' && str_contains($currentPath, 'pendientes') ? 'active' : '' ?>" href="<?= site_url('pagos/pendientes') ?>"><i class="fas fa-file-invoice"></i>Lecturas</a>
                <a class="<?= $activeSection === 'pagos' && ! str_contains($currentPath, 'pendientes') ? 'active' : '' ?>" href="<?= site_url('pagos') ?>"><i class="fas fa-money-bill-wave"></i>Pagos</a>
                <?php if ($currentPath !== 'dashboard'): ?>
                    <a class="<?= $activeSection === 'tarifas' ? 'active' : '' ?>" href="<?= site_url('tarifas') ?>"><i class="fas fa-tags"></i>Tarifas</a>
                    <a class="<?= $activeSection === 'tipos-servicio' ? 'active' : '' ?>" href="<?= site_url('tipos-servicio') ?>"><i class="fas fa-cog"></i>Tipos de Servicio</a>
                <?php endif; ?>
                <?php if (in_array(mb_strtolower(trim((string) session()->get('rol_nombre'))), ['administrador', 'desarrollador'], true)): ?>
                    <a class="<?= $activeSection === 'usuarios' ? 'active' : '' ?>" href="<?= site_url('usuarios') ?>"><i class="fas fa-user-shield"></i>Usuarios</a>
                <?php endif; ?>
                <div class="menu-label">Sesión</div>
                <a href="<?= site_url('logout') ?>"><i class="fas fa-sign-out-alt"></i>Cerrar sesión</a>
            </nav>
        </aside>

        <main class="shared-main-content">
            <?= $this->renderSection('content') ?>
        </main>

        <nav class="shared-bottom-nav">
            <a class="<?= $activeSection === 'dashboard' ? 'active' : '' ?>" href="<?= site_url('dashboard') ?>"><i class="fas fa-th-large"></i>Inicio</a>
            <a class="<?= $activeSection === 'clientes' ? 'active' : '' ?>" href="<?= site_url('clientes') ?>"><i class="fas fa-users"></i>Clientes</a>
            <a class="<?= $activeSection === 'contadores' ? 'active' : '' ?>" href="<?= site_url('contadores') ?>"><i class="fas fa-gauge-high"></i>Contadores</a>
            <a class="<?= $activeSection === 'pagos' ? 'active' : '' ?>" href="<?= site_url('pagos') ?>"><i class="fas fa-money-bill-wave"></i>Pagos</a>
        </nav>

        <script>
            const sharedMenuToggle = document.getElementById('sharedMenuToggle');
            const sharedSidebar = document.getElementById('sharedSidebar');
            const sharedSidebarOverlay = document.getElementById('sharedSidebarOverlay');
            const sharedCloseSidebar = document.getElementById('sharedCloseSidebar');
            const closeSharedSidebar = () => {
                sharedSidebar.classList.remove('open');
                sharedSidebarOverlay.classList.remove('active');
            };
            sharedMenuToggle?.addEventListener('click', () => {
                sharedSidebar.classList.add('open');
                sharedSidebarOverlay.classList.add('active');
            });
            sharedCloseSidebar?.addEventListener('click', closeSharedSidebar);
            sharedSidebarOverlay?.addEventListener('click', closeSharedSidebar);

            const themeToggle = document.getElementById('themeToggle');
            const updateThemeIcon = () => {
                const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
                const icon = themeToggle?.querySelector('i');
                if (icon) icon.className = isDark ? 'fas fa-sun' : 'fas fa-moon';
            };
            updateThemeIcon();
            themeToggle?.addEventListener('click', () => {
                const current = document.documentElement.getAttribute('data-theme');
                const next = current === 'dark' ? 'light' : 'dark';
                document.documentElement.setAttribute('data-theme', next);
                document.documentElement.setAttribute('data-bs-theme', next);
                localStorage.setItem('gotaTheme', next);
                updateThemeIcon();
            });
        </script>
    <?php else: ?>
        <?= $this->renderSection('content') ?>
    <?php endif; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>