<?php
/** @var array $clientes */
/** @var bool $mostrarInactivos */
?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Clientes<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .clientes-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 20px;
    }

    .clientes-header h2 {
        margin: 0;
        color: #1a1a2e;
        font-weight: 800;
    }

    .table-clientes th {
        color: #6c757d;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .badge-inactivo {
        background-color: #e9ecef;
        color: #6c757d;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">

    <div class="clientes-header">
        <h2>Clientes</h2>
        <a href="/clientes/nuevo" class="btn btn-primary">
            <i class="fa-solid fa-plus me-1"></i> Nuevo cliente
        </a>
    </div>

    <?php if (session()->getFlashdata('mensaje')): ?>
        <div class="alert alert-success" role="alert"><?= esc(session()->getFlashdata('mensaje')) ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger" role="alert"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <div class="mb-3">
        <?php if ($mostrarInactivos): ?>
            <a href="/clientes" class="btn btn-sm btn-outline-secondary">Ver solo activos</a>
        <?php else: ?>
            <a href="/clientes?mostrar=inactivos" class="btn btn-sm btn-outline-secondary">Ver todos (incluye inactivos)</a>
        <?php endif; ?>
    </div>

    <div class="table-responsive">
        <div class="card shadow-sm">
            <div class="card-body p-0">
            <table class="table table-hover table-clientes mb-0">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Email</th>
                        <th>Registro</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($clientes)): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">No hay clientes para mostrar.</td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($clientes as $cliente): ?>
                        <tr>
                            <td><?= esc($cliente['nombre']) ?></td>
                            <td><?= esc($cliente['telefono'] ?? '-') ?></td>
                            <td><?= esc($cliente['direccion']) ?></td>
                            <td><?= esc($cliente['email'] ?? '-') ?></td>
                            <td><?= esc($cliente['fecha_registro']) ?></td>
                            <td>
                                <?php if ($cliente['activo']): ?>
                                    <span class="badge bg-success">Activo</span>
                                <?php else: ?>
                                    <span class="badge badge-inactivo">Inactivo</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal"
                                        data-bs-target="#detalleClienteModal"
                                        data-nombre="<?= esc($cliente['nombre'], 'attr') ?>"
                                        data-telefono="<?= esc($cliente['telefono'] ?? '-', 'attr') ?>"
                                        data-direccion="<?= esc($cliente['direccion'], 'attr') ?>"
                                        data-email="<?= esc($cliente['email'] ?? '-', 'attr') ?>"
                                        data-registro="<?= esc($cliente['fecha_registro']) ?>"
                                        data-activo="<?= $cliente['activo'] ? 'Activo' : 'Inactivo' ?>"
                                        data-creado="<?= esc($auditoria[$cliente['created_by']] ?? 'Sistema', 'attr') ?>"
                                        data-actualizado="<?= esc($auditoria[$cliente['updated_by']] ?? 'Sin ediciones', 'attr') ?>">
                                    Detalle
                                </button>
                                <a href="/clientes/editar/<?= $cliente['id'] ?>" class="btn btn-sm btn-outline-primary">
                                    Editar
                                </a>
                                <?php if ($cliente['activo']): ?>
                                    <form action="/clientes/desactivar/<?= $cliente['id'] ?>" method="post" class="d-inline"
                                          onsubmit="return confirm('¿Desactivar este cliente?');">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Desactivar</button>
                                    </form>
                                <?php else: ?>
                                    <form action="/clientes/activar/<?= $cliente['id'] ?>" method="post" class="d-inline">
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

<div class="modal fade" id="detalleClienteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Detalle del cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <dl class="row mb-0">
                    <dt class="col-sm-4">Nombre</dt>
                    <dd class="col-sm-8" id="det-nombre">-</dd>

                    <dt class="col-sm-4">Teléfono</dt>
                    <dd class="col-sm-8" id="det-telefono">-</dd>

                    <dt class="col-sm-4">Dirección</dt>
                    <dd class="col-sm-8" id="det-direccion">-</dd>

                    <dt class="col-sm-4">Email</dt>
                    <dd class="col-sm-8" id="det-email">-</dd>

                    <dt class="col-sm-4">Registro</dt>
                    <dd class="col-sm-8" id="det-registro">-</dd>

                    <dt class="col-sm-4">Estado</dt>
                    <dd class="col-sm-8" id="det-activo">-</dd>

                    <dt class="col-sm-4">Creado por</dt>
                    <dd class="col-sm-8" id="det-creado">-</dd>

                    <dt class="col-sm-4">Actualizado por</dt>
                    <dd class="col-sm-8" id="det-actualizado">-</dd>
                </dl>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const modal = document.getElementById('detalleClienteModal');
    modal.addEventListener('show.bs.modal', (event) => {
        const btn = event.relatedTarget;
        modal.querySelector('#det-nombre').textContent      = btn.dataset.nombre;
        modal.querySelector('#det-telefono').textContent    = btn.dataset.telefono;
        modal.querySelector('#det-direccion').textContent   = btn.dataset.direccion;
        modal.querySelector('#det-email').textContent       = btn.dataset.email;
        modal.querySelector('#det-registro').textContent    = btn.dataset.registro;
        modal.querySelector('#det-activo').textContent      = btn.dataset.activo;
        modal.querySelector('#det-creado').textContent      = btn.dataset.creado;
        modal.querySelector('#det-actualizado').textContent = btn.dataset.actualizado;
    });
</script>
<?= $this->endSection() ?>