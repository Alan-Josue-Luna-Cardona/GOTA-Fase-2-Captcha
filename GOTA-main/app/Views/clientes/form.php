<?php
/** @var array|null $cliente */
?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?><?= $cliente ? 'Editar cliente' : 'Nuevo cliente' ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">

    <h2 class="mb-4 fw-bold" style="color:#1a1a2e;">
        <?= $cliente ? 'Editar cliente' : 'Nuevo cliente' ?>
    </h2>

    <?php if (!empty($errores)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errores as $campo => $mensaje): ?>
                    <li><?= esc($mensaje) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="<?= $cliente ? '/clientes/actualizar/' . $cliente['id'] : '/clientes/crear' ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label" for="nombre">Nombre *</label>
                    <input id="nombre" type="text" name="nombre" class="form-control" maxlength="100"
                           value="<?= esc(old('nombre', $cliente['nombre'] ?? '')) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="telefono">Teléfono</label>
                    <input id="telefono" type="text" name="telefono" class="form-control" maxlength="20"
                           value="<?= esc(old('telefono', $cliente['telefono'] ?? '')) ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="direccion">Dirección *</label>
                    <input id="direccion" type="text" name="direccion" class="form-control" maxlength="200"
                           value="<?= esc(old('direccion', $cliente['direccion'] ?? '')) ?>" required>
                </div>

                <div class="mb-4">
                    <label class="form-label" for="email">Email</label>
                    <input id="email" type="email" name="email" class="form-control" maxlength="100"
                           value="<?= esc(old('email', $cliente['email'] ?? '')) ?>">
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <?= $cliente ? 'Guardar cambios' : 'Registrar cliente' ?>
                    </button>
                    <a href="/clientes" class="btn btn-outline-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

</div>
<?= $this->endSection() ?>