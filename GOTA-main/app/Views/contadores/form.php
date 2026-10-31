<?php
/** @var array|null $contador */
/** @var array $clientes */
/** @var array $tiposServicio */
?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?><?= $contador ? 'Editar contador' : 'Nuevo contador' ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">

    <h2 class="mb-4 fw-bold" style="color:#1a1a2e;">
        <?= $contador ? 'Editar contador' : 'Nuevo contador' ?>
    </h2>

    <?php if (!empty($errores)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errores as $mensaje): ?>
                    <li><?= esc($mensaje) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="<?= $contador ? '/contadores/actualizar/' . $contador['id'] : '/contadores/crear' ?>" method="post">
                <?= csrf_field() ?>

                <?php
                // old() siempre tiene prioridad: solo trae algo cuando el
                // formulario se reenvió y falló la validación, así que
                // preserva lo que el usuario acababa de escribir/elegir
                // en vez de mostrarle de nuevo el valor viejo de la BD.
                $clienteSeleccionado = old('cliente_id', $contador['cliente_id'] ?? '');
                $tipoSeleccionado    = old('tipo_servicio_id', $contador['tipo_servicio_id'] ?? '');
                ?>

                <div class="mb-3">
                    <label class="form-label" for="cliente_id">Cliente *</label>
                    <select id="cliente_id" name="cliente_id" class="form-select" required>
                        <option value="">-- Selecciona un cliente --</option>
                        <?php foreach ($clientes as $cliente): ?>
                            <option value="<?= $cliente['id'] ?>"
                                <?= ($clienteSeleccionado != '' && $clienteSeleccionado == $cliente['id']) ? 'selected' : '' ?>>
                                <?= esc($cliente['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="tipo_servicio_id">Tipo de servicio *</label>
                    <select id="tipo_servicio_id" name="tipo_servicio_id" class="form-select" required>
                        <option value="">-- Selecciona un tipo de servicio --</option>
                        <?php foreach ($tiposServicio as $tipo): ?>
                            <option value="<?= $tipo['id'] ?>"
                                <?= ($tipoSeleccionado != '' && $tipoSeleccionado == $tipo['id']) ? 'selected' : '' ?>>
                                <?= esc($tipo['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="codigo">Código *</label>
                    <input id="codigo" type="text" name="codigo" class="form-control" maxlength="20"
                           value="<?= esc(old('codigo', $contador['codigo'] ?? '')) ?>" required>
                    <div class="form-text">Debe ser único, es el número de serie del medidor.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="referencia">Referencia</label>
                    <input id="referencia" type="text" name="referencia" class="form-control" maxlength="50"
                           value="<?= esc(old('referencia', $contador['referencia'] ?? '')) ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="sector">Sector</label>
                    <input id="sector" type="text" name="sector" class="form-control" maxlength="50"
                           value="<?= esc(old('sector', $contador['sector'] ?? '')) ?>">
                </div>

                <div class="mb-4">
                    <label class="form-label" for="ubicacion">Ubicación</label>
                    <input id="ubicacion" type="text" name="ubicacion" class="form-control" maxlength="100"
                           value="<?= esc(old('ubicacion', $contador['ubicacion'] ?? '')) ?>">
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <?= $contador ? 'Guardar cambios' : 'Registrar contador' ?>
                    </button>
                    <a href="/contadores" class="btn btn-outline-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

</div>
<?= $this->endSection() ?>