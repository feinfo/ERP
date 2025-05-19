<div class="container mt-5 text-center">
    <div class="alert alert-success">
        <h4 class="alert-heading">Pedido realizado com sucesso!</h4>
        <p>O número do seu pedido é <strong>#<?= $pedido_id ?></strong>.</p>
        <?php if (!empty($pedido_data)): ?>
        <p>Efetuado em: <strong><?= date('d/m/Y H:i:s', strtotime($pedido_data)) ?></strong></p>
        <?php endif; ?>
        <hr>
        <a href="<?= base_url('produto') ?>" class="btn btn-primary">Voltar à loja</a>
    </div>
</div>