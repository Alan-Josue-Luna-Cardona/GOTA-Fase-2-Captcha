<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?><?= $tarifa ? 'Editar tarifa' : 'Nueva tarifa' ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <h4 class="mb-3"><?= $tarifa ? 'Editar tarifa' : 'Nueva tarifa' ?></h4>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('errores')): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errores') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post"
          action="<?= $tarifa ? site_url('tarifas/actualizar/' . $tarifa['id']) : site_url('tarifas/crear') ?>">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label class="form-label">Tipo de servicio</label>
            <select name="tipo_servicio_id" class="form-select" required>
                <option value="">-- Selecciona un tipo de servicio --</option>
                <?php foreach ($tiposServicio as $tipo): ?>
                    <option value="<?= $tipo['id'] ?>"
                        <?= (old('tipo_servicio_id', $tarifa['tipo_servicio_id'] ?? '') == $tipo['id']) ? 'selected' : '' ?>>
                        <?= esc($tipo['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Volumen incluido (m³)</label>
                <input type="number" step="0.01" min="0" name="volumen_incluido_m3" class="form-control"
                       value="<?= old('volumen_incluido_m3', $tarifa['volumen_incluido_m3'] ?? '0.00') ?>">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Tarifa base (Q/m³)</label>
                <input type="number" step="0.0001" min="0" name="tarifa_base" class="form-control" required
                       value="<?= old('tarifa_base', $tarifa['tarifa_base'] ?? '') ?>">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Tarifa de exceso (Q/m³)</label>
                <input type="number" step="0.0001" min="0" name="tarifa_exceso" class="form-control" required
                       value="<?= old('tarifa_exceso', $tarifa['tarifa_exceso'] ?? '') ?>">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Vigente desde</label>
                <input type="date" name="vigente_desde" class="form-control" required
                       value="<?= old('vigente_desde', $tarifa['vigente_desde'] ?? '') ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Vigente hasta (opcional)</label>
                <input type="date" name="vigente_hasta" class="form-control"
                       value="<?= old('vigente_hasta', $tarifa['vigente_hasta'] ?? '') ?>">
                <div class="form-text">Déjalo vacío si la tarifa sigue vigente indefinidamente.</div>
            </div>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="activo" value="1" class="form-check-input" id="activo"
                <?= old('activo', $tarifa['activo'] ?? 1) ? 'checked' : '' ?>>
            <label class="form-check-label" for="activo">Tarifa activa</label>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="<?= site_url('tarifas') ?>" class="btn btn-outline-secondary">Cancelar</a>
    </form>
</div>
<?= $this->endSection() ?>
