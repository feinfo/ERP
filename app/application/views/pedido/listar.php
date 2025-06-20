<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Pedidos Realizados</h2>
        <!-- Se houver botão de novo pedido, coloque aqui -->
    </div>
    <div class="table-responsive">
        <table class="table table-bordered w-100 mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Status</th>
                    <th>Data</th>
                    <th>Total</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedidos as $p): ?>
                    <tr>
                        <td>#<?= $p->id; ?></td>
                        <td><?= $p->status_descricao ?></td>
                        <td><?= date('d/m/Y H:i:s', strtotime($p->criado_em)) ?></td>
                        <td>R$ <?= number_format($p->total, 2, ',', '.') ?></td>
                        <td>
                            <a href="<?= base_url("pedido/visualizar/{$p->id}") ?>" class="btn btn-sm btn-primary" title="Visualizar">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- Se houver ação de novo pedido, botão flutuante para mobile -->
</div>