<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Registrar pago<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <h4 class="mb-3">Registrar pago</h4>

    <?php if (session()->getFlashdata('errores')): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errores') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card mb-3">
        <div class="card-body">
            <h6 class="card-subtitle mb-2 text-muted">Datos de la lectura</h6>
            <p class="mb-1"><strong>Cliente:</strong> <?= esc($lectura['cliente_nombre']) ?></p>
            <p class="mb-1"><strong>Contador:</strong> <?= esc($lectura['contador_codigo']) ?></p>
            <p class="mb-1"><strong>Período:</strong> <?= esc($lectura['periodo']) ?></p>
            <p class="mb-1"><strong>Consumo:</strong> <?= number_format((float) $lectura['consumo'], 2) ?> m³</p>
            <p class="mb-0"><strong>Monto a pagar:</strong> Q<?= number_format((float) $lectura['monto_total'], 2) ?></p>
        </div>
    </div>

    <form method="post" action="<?= site_url('pagos/guardar/' . $lectura['id']) ?>">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label class="form-label">Método de pago</label>
            <select name="metodo" class="form-select" required>
                <option value="">-- Selecciona un método --</option>
                <?php foreach ($metodos as $metodo): ?>
                    <option value="<?= esc($metodo) ?>" <?= old('metodo') === $metodo ? 'selected' : '' ?>>
                        <?= esc($metodo) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">No. de comprobante (opcional)</label>
            <input type="text" name="comprobante" maxlength="100" class="form-control" value="<?= old('comprobante') ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Observaciones (opcional)</label>
            <textarea name="observaciones" maxlength="200" class="form-control" rows="2"><?= old('observaciones') ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Registrar pago</button>
        <a href="<?= site_url('pagos/pendientes') ?>" class="btn btn-outline-secondary">Cancelar</a>
    </form>
</div>
<?= $this->endSection() ?>
