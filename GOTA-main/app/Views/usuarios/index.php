<?php
/** @var array $usuarios */
?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Usuarios<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid py-3 py-md-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
        <div>
            <h2 class="mb-1 fw-bold">Usuarios</h2>
            <p class="mb-0 text-muted">Administra las cuentas y los roles del sistema.</p>
        </div>
        <a href="<?= site_url('usuarios/nuevo') ?>" class="btn btn-primary">
            <i class="fa-solid fa-user-plus me-1"></i> Nuevo usuario
        </a>
    </div>

    <?php if (session()->getFlashdata('exito')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('exito')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <div class="table-responsive">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Rol</th>
                            <th>Creado</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($usuarios === []): ?>
                            <tr>
                                <td colspan="5" class="py-4 text-center text-muted">No hay usuarios registrados.</td>
                            </tr>
                        <?php endif; ?>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td><?= esc($usuario['nombre']) ?></td>
                                <td><?= esc($usuario['email']) ?></td>
                                <td><span class="badge bg-primary-subtle text-primary-emphasis"><?= esc($usuario['rol_nombre']) ?></span></td>
                                <td><?= esc($usuario['created_at'] ?? '-') ?></td>
                                <td class="text-end">
                                    <a href="<?= site_url('usuarios/editar/' . $usuario['id']) ?>" class="btn btn-sm btn-outline-primary" title="Editar usuario">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
