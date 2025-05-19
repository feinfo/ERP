<div class="container mt-4">
    <h2>Pedido #<?= $pedido->id ?></h2>
    <p><strong>Status:</strong> <?= $pedido->status_nome ?></p>
    <p><strong>Data:</strong> <?= date('d/m/Y H:i:s', strtotime($pedido->criado_em)) ?></p>
    <p><strong>Total:</strong> R$ <?= number_format($pedido->total, 2, ',', '.') ?></p>

    <h4 class="mt-4">Itens do Pedido</h4>
    <table class="table table-bordered mt-2">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Preço Unitário</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($itens as $item): ?>
                <tr>
                    <td><?= $item->nome ?></td>
                    <td><?= $item->quantidade ?></td>
                    <td>R$ <?= number_format($item->preco, 2, ',', '.') ?></td>
                    <td>R$ <?= number_format($item->quantidade * $item->preco, 2, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="row mt-4">
    <div class="col-md-6 offset-md-3">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">Resumo do Pedido</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <span>Subtotal:</span>
                    <span>R$ <?= number_format($pedido->subtotal, 2, ',', '.') ?></span>
                </div>

                <?php if ($pedido->desconto > 0): ?>
                    <div class="d-flex justify-content-between text-danger">
                        <span>Desconto:</span>
                        <span>-R$ <?= number_format($pedido->desconto, 2, ',', '.') ?></span>
                    </div>
                    <!-- <div class="d-flex justify-content-between text-muted small">
                        <span>Cupom aplicado:</span>
                        <span><strong><?= $pedido->cupom_codigo ?></strong></span>
                    </div> -->
                <?php endif; ?>

                <hr>
                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Total:</span>
                    <span class="text-success">R$ <?= number_format($pedido->total, 2, ',', '.') ?></span>
                </div>
            </div>
        </div>
    </div>
</div>


    <a href="<?= base_url('pedido/listar') ?>" class="btn btn-secondary mt-3">Voltar</a>
</div>
