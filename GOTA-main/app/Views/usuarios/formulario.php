<?php
/** @var array|null $usuario */
/** @var array $roles */
$errores = session()->getFlashdata('errores') ?? [];
$editando = $usuario !== null;
?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?><?= $editando ? 'Editar usuario' : 'Nuevo usuario' ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid py-3 py-md-4">
    <div class="mb-4">
        <a href="<?= site_url('usuarios') ?>" class="btn btn-sm btn-outline-secondary mb-3">
            <i class="fa-solid fa-arrow-left me-1"></i> Usuarios
        </a>
        <h2 class="mb-1 fw-bold"><?= $editando ? 'Editar usuario' : 'Nuevo usuario' ?></h2>
        <p class="mb-0 text-muted">Define los datos de acceso y el rol de la cuenta.</p>
    </div>

    <?php if ($errores !== []): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errores as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="post" action="<?= $editando ? site_url('usuarios/actualizar/' . $usuario['id']) : site_url('usuarios/crear') ?>">
                <?= csrf_field() ?>

                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label for="nombre" class="form-label">Nombre completo</label>
                        <input id="nombre" name="nombre" type="text" class="form-control" maxlength="100" required
                               value="<?= esc(old('nombre', $usuario['nombre'] ?? '')) ?>">
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input id="email" name="email" type="email" class="form-control" maxlength="150" required
                               value="<?= esc(old('email', $usuario['email'] ?? '')) ?>">
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="rol_id" class="form-label">Rol</label>
                        <select id="rol_id" name="rol_id" class="form-select" required>
                            <option value="">Selecciona un rol</option>
                            <?php foreach ($roles as $rol): ?>
                                <option value="<?= $rol['id'] ?>" <?= old('rol_id', $usuario['rol_id'] ?? '') == $rol['id'] ? 'selected' : '' ?>>
                                    <?= esc($rol['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="password" class="form-label">
                            <?= $editando ? 'Nueva contraseña (opcional)' : 'Contraseña' ?>
                        </label>
                        <input id="password" name="password" type="password" class="form-control" minlength="6" <?= $editando ? '' : 'required' ?> autocomplete="new-password">
                        <?php if ($editando): ?>
                            <div class="form-text">Déjala vacía para conservar la contraseña actual.</div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk me-1"></i> <?= $editando ? 'Guardar cambios' : 'Crear usuario' ?>
                    </button>
                    <a href="<?= site_url('usuarios') ?>" class="btn btn-outline-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
