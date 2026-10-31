<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Iniciar sesión<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    :root {
        --primary: #0d6efd;
        --primary-dark: #0a58ca;
        --accent: #4fc3f7;
        --shadow-lg: 0 8px 40px rgba(0, 0, 0, 0.12);
    }

    * {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        box-sizing: border-box;
    }

    body {
        min-height: 100vh;
        margin: 0;
        background: var(--app-bg);
        transition: background 0.3s ease;
    }

    .login-page {
        min-height: 100vh;
        display: grid;
        grid-template-columns: minmax(280px, 0.9fr) minmax(320px, 1.1fr);
    }

    .login-brand {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 40px clamp(28px, 6vw, 88px);
        color: #fff;
        background: #1a1a2e;
    }

    .login-brand h1 {
        margin: 0;
        font-size: clamp(2.5rem, 5vw, 4.5rem);
        font-weight: 800;
        letter-spacing: 0;
    }

    .login-brand h1 span {
        color: var(--accent);
    }

    .login-brand p {
        max-width: 360px;
        margin: 16px 0 0;
        color: rgba(255, 255, 255, 0.7);
        line-height: 1.7;
    }

    .login-brand .brand-mark {
        color: var(--accent);
        font-size: 1.35rem;
    }

    .login-brand small {
        color: rgba(255, 255, 255, 0.45);
    }

    .login-form-area {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 32px 24px;
    }

    .login-card {
        width: min(100%, 420px);
        padding: clamp(28px, 5vw, 48px);
        background: var(--app-card);
        border-radius: 16px;
        box-shadow: var(--shadow-lg);
    }

    .login-card h2 {
        margin: 0 0 8px;
        color: var(--app-text);
        font-weight: 800;
    }

    .login-card .subtitle {
        margin-bottom: 28px;
        color: var(--app-muted);
    }

    .login-card .form-label {
        color: var(--app-text);
        font-weight: 600;
    }

    .login-card .form-control {
        min-height: 48px;
        border-color: var(--app-border);
        background-color: var(--app-card-soft);
        color: var(--app-text);
        border-radius: 10px;
    }

    .login-card .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
    }

    .login-card .btn-primary {
        min-height: 48px;
        border: 0;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        font-weight: 700;
    }

    .login-theme-toggle {
        position: fixed;
        top: 16px;
        right: 16px;
        z-index: 1080;
    }

    @media (max-width: 720px) {
        .login-page {
            display: block;
        }

        .login-brand {
            min-height: 220px;
            padding: 28px 24px;
        }

        .login-brand p {
            margin-top: 8px;
        }

        .login-brand small {
            display: none;
        }

        .login-form-area {
            min-height: calc(100vh - 220px);
            padding: 24px 16px;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<button type="button" class="theme-toggle login-theme-toggle" id="themeToggle" aria-label="Cambiar tema claro/oscuro">
    <i class="fas fa-moon"></i>
</button>
<main class="login-page">
    <section class="login-brand" aria-label="GOTA">
        <div>
            <div class="brand-mark"><i class="fa-solid fa-droplet"></i></div>
            <h1>G<span>O</span>TA</h1>
            <p>Gestión clara y eficiente para la Oficina del Agua.</p>
        </div>
        <small>Administración de servicios de agua</small>
    </section>

    <section class="login-form-area">
        <div class="login-card">
            <h2>Bienvenido</h2>
            <p class="subtitle">Ingresa tus credenciales para continuar.</p>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger" role="alert"><?= esc(session()->getFlashdata('error')) ?></div>
            <?php endif; ?>

            <form action="/login" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label" for="email">Correo</label>
                    <input id="email" type="email" name="email" class="form-control" autocomplete="email" required>
                </div>
                <div class="mb-4">
                    <label class="form-label" for="password">Contraseña</label>
                    <input id="password" type="password" name="password" class="form-control" autocomplete="current-password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Ingresar</button>
            </form>
        </div>
    </section>
</main>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const themeToggle = document.getElementById('themeToggle');
    if (themeToggle) {
        const updateThemeIcon = () => {
            const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
            themeToggle.querySelector('i').className = isDark ? 'fas fa-sun' : 'fas fa-moon';
        };
        updateThemeIcon();
        themeToggle.addEventListener('click', () => {
            const current = document.documentElement.getAttribute('data-theme');
            const next = current === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', next);
            document.documentElement.setAttribute('data-bs-theme', next);
            localStorage.setItem('gotaTheme', next);
            updateThemeIcon();
        });
    }
</script>
<?= $this->endSection() ?>