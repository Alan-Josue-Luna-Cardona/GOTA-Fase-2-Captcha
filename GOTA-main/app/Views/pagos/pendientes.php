<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Lecturas pendientes de pago<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Lecturas pendientes de pago</h4>
        <a href="<?= site_url('pagos') ?>" class="btn btn-outline-secondary">
            <i class="fa-solid fa-list"></i> Ver todos los pagos
        </a>
    </div>

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
                    <th>Consumo (m³)</th>
                    <th>Monto a pagar</th>
                    <th class="text-end">Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($lecturas)): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            No hay lecturas pendientes de pago.
                        </td>
                    </tr>
                <?php endif; ?>

                <?php foreach ($lecturas as $lectura): ?>
                    <tr>
                        <td><?= esc($lectura['cliente_nombre']) ?></td>
                        <td><?= esc($lectura['contador_codigo']) ?></td>
                        <td><?= esc($lectura['periodo']) ?></td>
                        <td><?= number_format((float) $lectura['consumo'], 2) ?></td>
                        <td>Q<?= number_format((float) $lectura['monto_total'], 2) ?></td>
                        <td class="text-end">
                            <a href="<?= site_url('pagos/registrar/' . $lectura['id']) ?>" class="btn btn-sm btn-primary">
                                Registrar pago
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
