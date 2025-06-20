<div class="container mt-5">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-3">Cupons</h2>
    <a href="<?= base_url('cupom/form') ?>" class="btn btn-outline-primary d-none d-md-block">Novo Cupom</a>
  </div>
  <div class="table-responsive">
    <table class="table table-striped table-bordered w-100">
      <thead>
        <tr>
          <th>ID</th>
          <th>Código</th>
          <th>Tipo</th>
          <th>Valor</th>
          <th>Valor Mínimo</th>
          <th>Validade</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($cupons as $c): ?>
          <tr>
            <td><?= $c->id ?></td>
            <td><?= $c->codigo ?></td>
            <td><?= ucfirst($c->tipo) ?></td>
            <td><?= $c->tipo == 'percentual' ? $c->valor . '%' : 'R$ ' . number_format($c->valor, 2, ',', '.') ?></td>
            <td>R$ <?= number_format($c->valor_minimo, 2, ',', '.') ?></td>
            <td><?= date('d/m/Y', strtotime($c->validade)) ?></td>
            <td>
              <a href="<?= base_url('cupom/form/' . $c->id) ?>" class="btn btn-sm btn-warning">Editar</a>
              <a href="<?= base_url('cupom/excluir/' . $c->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Deseja excluir este cupom?')">Excluir</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <a href="<?= base_url('cupom/form') ?>" class="btn btn-outline-primary btn-lg rounded-circle position-fixed d-md-none" style="bottom: 24px; right: 24px; z-index: 1050; width: 56px; height: 56px; display: flex; align-items: center; justify-content: center; font-size: 2rem; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
    <i class="bi bi-plus"></i>
  </a>
</div>