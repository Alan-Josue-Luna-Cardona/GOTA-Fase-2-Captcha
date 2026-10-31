<?php
/** @var array $contadores */
/** @var bool $mostrarInactivos */
?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Contadores<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">

    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
        <h2 class="fw-bold m-0" style="color:#1a1a2e;">Contadores</h2>
        <a href="/contadores/nuevo" class="btn btn-primary">
            <i class="fa-solid fa-plus me-1"></i> Nuevo contador
        </a>
    </div>

    <?php if (session()->getFlashdata('mensaje')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('mensaje')) ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <div class="mb-3">
        <?php if ($mostrarInactivos): ?>
            <a href="/contadores" class="btn btn-sm btn-outline-secondary">Ver solo activos</a>
        <?php else: ?>
            <a href="/contadores?mostrar=inactivos" class="btn btn-sm btn-outline-secondary">Ver todos (incluye inactivos)</a>
        <?php endif; ?>
    </div>

    <div class="table-responsive">
        <div class="card shadow-sm">
            <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Cliente</th>
                        <th>Tipo de servicio</th>
                        <th>Sector</th>
                        <th>Ubicación</th>
                        <th>Instalación</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($contadores)): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">No hay contadores para mostrar.</td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($contadores as $contador): ?>
                        <tr>
                            <td><?= esc($contador['codigo']) ?></td>
                            <td><?= esc($contador['cliente_nombre']) ?></td>
                            <td><?= esc($contador['tipo_servicio_nombre']) ?></td>
                            <td><?= esc($contador['sector'] ?? '-') ?></td>
                            <td><?= esc($contador['ubicacion'] ?? '-') ?></td>
                            <td><?= esc($contador['fecha_instalacion']) ?></td>
                            <td>
                                <?php if ($contador['activo']): ?>
                                    <span class="badge bg-success">Activo</span>
                                <?php else: ?>
                                    <span class="badge" style="background:#e9ecef;color:#6c757d;">Inactivo</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <?php if ($contador['activo']): ?>
                                    <a href="/lecturas/nueva/<?= $contador['id'] ?>" class="btn btn-sm btn-primary">
                                        <i class="fa-solid fa-droplet me-1"></i>Nueva lectura
                                    </a>
                                <?php endif; ?>
                                <a href="/contadores/editar/<?= $contador['id'] ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                                <?php if ($contador['activo']): ?>
                                    <form action="/contadores/desactivar/<?= $contador['id'] ?>" method="post" class="d-inline"
                                          onsubmit="return confirm('¿Desactivar este contador?');">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Desactivar</button>
                                    </form>
                                <?php else: ?>
                                    <form action="/contadores/activar/<?= $contador['id'] ?>" method="post" class="d-inline">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-outline-success">Activar</button>
                                    </form>
                                <?php endif; ?>
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