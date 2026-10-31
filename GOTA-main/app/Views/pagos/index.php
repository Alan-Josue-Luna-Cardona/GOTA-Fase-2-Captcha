<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Pagos<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Pagos</h4>
        <a href="<?= site_url('pagos/pendientes') ?>" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Registrar pago
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
                    <th>Cliente</th>
                    <th>Contador</th>
                    <th>Período</th>
                    <th>Monto</th>
                    <th>Método</th>
                    <th>Fecha de pago</th>
                    <th>Estado</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($pagos)): ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            Todavía no hay pagos registrados.
                        </td>
                    </tr>
                <?php endif; ?>

                <?php foreach ($pagos as $pago): ?>
                    <tr>
                        <td><?= esc($pago['cliente_nombre']) ?></td>
                        <td><?= esc($pago['contador_codigo']) ?></td>
                        <td><?= esc($pago['periodo']) ?></td>
                        <td>Q<?= number_format((float) $pago['monto'], 2) ?></td>
                        <td><?= esc($pago['metodo']) ?></td>
                        <td><?= esc($pago['fecha_pago']) ?></td>
                        <td>
                            <?php
                                $clase = match ($pago['estado']) {
                                    'Completado' => 'bg-success',
                                    'Pendiente'  => 'bg-warning text-dark',
                                    'Anulado'    => 'bg-secondary',
                                    default      => 'bg-secondary',
                                };
                            ?>
                            <span class="badge <?= $clase ?>"><?= esc($pago['estado']) ?></span>
                        </td>
                        <td class="text-end">
                            <?php if ($pago['estado'] !== 'Anulado'): ?>
                                <form action="<?= site_url('pagos/anular/' . $pago['id']) ?>" method="post" class="d-inline">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('¿Anular este pago? La lectura quedará pendiente de pago otra vez.');">
                                        <i class="fa-solid fa-ban"></i> Anular
                                    </button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
