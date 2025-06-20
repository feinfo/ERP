<div class="container mt-4">
    <h2 class="mb-4">Carrinho de Compras</h2>

    <?php if (empty($carrinho)): ?>
        <div class="alert alert-warning">Seu carrinho está vazio.</div>
        <a href="<?= base_url('produto') ?>" class="btn btn-primary">Continuar comprando</a>
    <?php else: ?>
        <form method="post" action="<?= base_url('pedido/finalizar') ?>" id="formEndereco">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Variação</th>
                            <th>Quantidade</th>
                            <th>Preço Unitário</th>
                            <th>Subtotal</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($carrinho as $id => $item): ?>
                            <tr>
                                <td><?= $item['nome'] ?></td>
                                <td><?= $item['descricao'] ?></td>
                                <td><?= $item['quantidade'] ?></td>
                                <td>R$ <?= number_format($item['preco_unitario'], 2, ',', '.') ?></td>
                                <td>R$ <?= number_format($item['quantidade'] * $item['preco_unitario'], 2, ',', '.') ?></td>
                                <td>
                                    <a href="<?= base_url("carrinho/remover/$id") ?>" class="btn btn-sm btn-danger" onclick="return confirm('Remover item do carrinho?')">Remover</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="card mt-4">
                <div class="card-header" data-bs-toggle="collapse" data-bs-target="#dadosEntrega" aria-expanded="true" aria-controls="dadosEntrega">
                    <strong>Endereço de Entrega</strong>
                    <i class="bi bi-chevron-up transition" id="iconeSetaEntrega"></i>
                </div>
       
                <div id="dadosEntrega" class="collapse show">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="cep" class="form-label">CEP</label>
                            <input type="text" id="cep" name="cep" class="form-control" placeholder="Digite o CEP" maxlength="9">
                        </div>

                        <div id="endereco-info" class="d-none">
                            <p><strong>Rua:</strong> <span id="logradouro"></span></p>
                            <p><strong>Bairro:</strong> <span id="bairro"></span></p>
                            <p><strong>Cidade:</strong> <span id="localidade"></span></p>
                            <p><strong>UF:</strong> <span id="uf"></span></p>

                            <!-- Campos hidden -->
                            <input type="hidden" name="logradouro" id="inputLogradouro">
                            <input type="hidden" name="bairro" id="inputBairro">
                            <input type="hidden" name="localidade" id="inputLocalidade">
                            <input type="hidden" name="uf" id="inputUf">
                        </div>

                        <div id="endereco-manual" class="d-none">
                            <div class="mb-2">
                                <label class="form-label">Rua</label>
                                <input type="text" name="logradouro_manual" class="form-control">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Bairro</label>
                                <input type="text" name="bairro_manual" class="form-control">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Cidade</label>
                                <input type="text" name="localidade_manual" class="form-control">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">UF</label>
                                <input type="text" name="uf_manual" class="form-control" maxlength="2">
                            </div>
                        </div>
                        <div class="mb-3 mt-3">
                            <label class="form-label">Número</label>
                            <input type="text" name="numero" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Complemento</label>
                            <input type="text" name="complemento" class="form-control">
                        </div>

                        <div id="mensagem-erro" class="alert alert-warning d-none mt-3">CEP não encontrado. Preencha manualmente.</div>
                    </div>
                </div>
            </div>

            <h4 class="mt-4">Resumo do Pedido</h4>

            <div class="alert alert-primary">
                <p class="mb-1"><strong>Subtotal:</strong> R$ <?= number_format($subtotal ?? 0, 2, ',', '.') ?></p>
                <p class="mb-1"><strong>Frete:</strong> <?= isset($frete) && $frete == 0 ? 'Grátis' : 'R$ ' . number_format($frete ?? 0, 2, ',', '.') ?></p>

                <?php if (isset($cupom_aplicado) && $desconto > 0): ?>
                    <hr class="my-2">
                    <p class="mb-1">
                        <strong>Cupom:</strong> <span class="text-uppercase"><?= $cupom_aplicado['codigo'] ?></span>
                        <?php if ($cupom_aplicado['tipo'] === 'percentual'): ?>
                            <small class="text-muted">(<?= number_format($cupom_aplicado['valor'], 2, ',', '.') ?>%)</small>
                        <?php else: ?>
                            <small class="text-muted">(R$ <?= number_format($cupom_aplicado['valor'], 2, ',', '.') ?>)</small>
                        <?php endif; ?>
                    </p>
                    <p class="mb-1"><strong>Desconto:</strong> <span class="text-success">- R$ <?= number_format($desconto, 2, ',', '.') ?></span></p>
                <?php endif; ?>

                <hr class="my-2">
                <p class="mb-0"><strong>Total:</strong> <span class="fw-bold text-danger">R$ <?= number_format($total_com_desconto ?? $subtotal ?? 0, 2, ',', '.') ?></span></p>
            </div>

            <?php if (!isset($cupom_aplicado)): ?>
                <!-- Formulário de aplicação de cupom -->
                <div class="row g-2 mb-3">
                    <div class="col-auto">
                        <input type="text" name="codigo" class="form-control" placeholder="Código do cupom">
                    </div>
                    <div class="col-auto">
                        <button type="submit" formaction="<?= base_url('carrinho/aplicar_cupom') ?>" class="btn btn-outline-success">Aplicar Cupom</button>
                    </div>
                </div>
            <?php else: ?>
                <!-- Botão para remover cupom -->
                <div class="mb-3">
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="removerCupom()">Remover cupom</button>
                </div>
            <?php endif; ?>

            <div class="mt-4 d-flex justify-content-between align-items-center">
                <a href="<?= base_url('produto') ?>" class="btn btn-secondary">Continuar comprando</a>
                <button type="submit" class="btn btn-success">Finalizar pedido</button>
            </div>
        </form>
    <?php endif; ?>
</div>
