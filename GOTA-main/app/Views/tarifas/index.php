<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Tarifas<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Tarifas</h4>
        <a href="<?= site_url('tarifas/nuevo') ?>" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Nueva tarifa
        </a>
    </div>

    <?php if (session()->getFlashdata('exito')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('exito')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Tipo de servicio</th>
                    <th>Vol. incluido (m³)</th>
                    <th>Tarifa base</th>
                    <th>Tarifa exceso</th>
                    <th>Vigente desde</th>
                    <th>Vigente hasta</th>
                    <th>Estado</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($tarifas)): ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            Todavía no hay tarifas registradas.
                        </td>
                    </tr>
                <?php endif; ?>

                <?php foreach ($tarifas as $tarifa): ?>
                    <tr>
                        <td><?= esc($tarifa['tipo_servicio_nombre']) ?></td>
                        <td><?= number_format((float) $tarifa['volumen_incluido_m3'], 2) ?></td>
                        <td>Q<?= number_format((float) $tarifa['tarifa_base'], 4) ?></td>
                        <td>Q<?= number_format((float) $tarifa['tarifa_exceso'], 4) ?></td>
                        <td><?= esc($tarifa['vigente_desde']) ?></td>
                        <td>
                            <?php if ($tarifa['vigente_hasta']): ?>
                                <?= esc($tarifa['vigente_hasta']) ?>
                            <?php else: ?>
                                <span class="text-muted">Indefinida</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($tarifa['activo']): ?>
                                <span class="badge bg-success">Activa</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Inactiva</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end">
                            <a href="<?= site_url('tarifas/editar/' . $tarifa['id']) ?>" class="btn btn-sm btn-outline-primary">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="<?= site_url('tarifas/desactivar/' . $tarifa['id']) ?>" method="post" class="d-inline">
                                <?= csrf_field() ?>
                                <button type="submit"
                                        class="btn btn-sm btn-outline-<?= $tarifa['activo'] ? 'danger' : 'success' ?>"
                                        onclick="return confirm('¿Seguro que quieres <?= $tarifa['activo'] ? 'desactivar' : 'activar' ?> esta tarifa?');">
                                    <i class="fa-solid fa-<?= $tarifa['activo'] ? 'ban' : 'check' ?>"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
