<div class="container mt-5">
  <h2 class="mb-3">Cupons</h2>

  <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success"> <?= $this->session->flashdata('success') ?> </div>
  <?php elseif ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger"> <?= $this->session->flashdata('error') ?> </div>
  <?php endif; ?>

  <a href="<?= base_url('cupom/form') ?>" class="btn btn-primary mb-3">Novo Cupom</a>
  <div class="table-responsive">
    <table class="table table-striped table-bordered">
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
</div>