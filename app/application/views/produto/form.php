<div class="container mt-5">
    <h2><?= isset($produto) ? 'Editar' : 'Novo' ?> Produto</h2>
    <form method="post" action="<?= base_url('produto/salvar') ?>">
        <input type="hidden" name="id" value="<?= $produto->id ?? '' ?>">

        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" name="nome" class="form-control" value="<?= $produto->nome ?? '' ?>" required>
        </div>

        <div class="mb-3">
            <label for="preco" class="form-label">Preço Base</label>
            <input type="number" step="0.01" name="preco" class="form-control" value="<?= $produto->preco ?? '' ?>" required>
        </div>

        <h5>Variações</h5>
        <div id="variacoes">
            <?php if (!empty($variacoes)): ?>
                <?php foreach ($variacoes as $i => $v): ?>
                    <div class="row mb-2 variacao-item">
                        <div class="col-md-6">
                            <input type="text" name="variacoes[<?= $i ?>][descricao]" class="form-control" placeholder="Ex: Tamanho P / Branco" value="<?= $v->descricao ?>" required>
                        </div>
                        <div class="col-md-4">
                            <input type="number" name="variacoes[<?= $i ?>][estoque]" class="form-control" placeholder="Estoque" value="<?= $v->estoque ?>" required>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger btn-remover">Remover</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="row mb-2 variacao-item">
                    <div class="col-md-6">
                        <input type="text" name="variacoes[0][descricao]" class="form-control" placeholder="Ex: Tamanho P / Branco" required>
                    </div>
                    <div class="col-md-4">
                        <input type="number" name="variacoes[0][estoque]" class="form-control" placeholder="Estoque" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-remover">Remover</button>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <button type="button" id="btnAdicionarVariacao" class="btn btn-secondary">Adicionar Variação</button>

        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="<?= base_url('produto') ?>" class="btn btn-secondary">Voltar</a>
    </form>
</div>

<script>
let contador = document.querySelectorAll('.variacao-item').length;

// Adiciona nova linha de variação
document.getElementById('btnAdicionarVariacao').addEventListener('click', function () {
    const div = document.createElement('div');
    div.classList.add('row', 'mb-2', 'variacao-item');
    div.innerHTML = `
        <div class="col-md-6">
            <input type="text" name="variacoes[\${contador}][descricao]" class="form-control" placeholder="Ex: Tamanho M / Azul" required>
        </div>
        <div class="col-md-4">
            <input type="number" name="variacoes[\${contador}][estoque]" class="form-control" placeholder="Estoque" required>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger btn-remover">Remover</button>
        </div>
    `;
    document.getElementById('variacoes').appendChild(div);
    contador++;
});

// Remove variação
document.getElementById('variacoes').addEventListener('click', function (e) {
    if (e.target.classList.contains('btn-remover')) {
        e.target.closest('.variacao-item').remove();
    }
});
</script>