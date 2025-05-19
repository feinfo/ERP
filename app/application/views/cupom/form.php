<div class="container mt-5">
  <h2><?= isset($cupom) ? 'Editar' : 'Novo' ?> Cupom</h2>

  <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success"> <?= $this->session->flashdata('success') ?> </div>
  <?php elseif ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger"> <?= $this->session->flashdata('error') ?> </div>
  <?php endif; ?>

  <form action="<?= base_url('cupom/salvar') ?>" method="post">
    <?php if (isset($cupom)): ?>
      <input type="hidden" name="id" value="<?= $cupom->id ?>">
    <?php endif; ?>
    <div class="mb-3">
      <label for="codigo" class="form-label">Código</label>
      <input type="text" class="form-control" id="codigo" name="codigo" required value="<?= $cupom->codigo ?? '' ?>">
    </div>
    <div class="mb-3">
      <label for="tipo" class="form-label">Tipo</label>
      <select name="tipo" id="tipo" class="form-select" required>
        <option value="percentual" <?= isset($cupom) && $cupom->tipo == 'percentual' ? 'selected' : '' ?>>Percentual</option>
        <option value="valor" <?= isset($cupom) && $cupom->tipo == 'valor' ? 'selected' : '' ?>>Valor</option>
      </select>
    </div>
    <div class="mb-3">
      <label for="valor" class="form-label">Valor do Desconto</label>
      <input type="number" step="0.01" class="form-control" name="valor" required value="<?= $cupom->valor ?? '' ?>">
    </div>
    <div class="mb-3">
      <label for="valor_minimo" class="form-label">Valor Mínimo do Pedido</label>
      <input type="number" step="0.01" class="form-control" name="valor_minimo" required value="<?= $cupom->valor_minimo ?? '' ?>">
    </div>
    <div class="mb-3">
      <label for="validade" class="form-label">Validade</label>
      <input type="date" class="form-control" name="validade" required value="<?= $cupom->validade ?? '' ?>">
    </div>
    <button type="submit" class="btn btn-success">Salvar</button>
    <a href="<?= base_url('cupom') ?>" class="btn btn-secondary">Cancelar</a>
  </form>
</div>